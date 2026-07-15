<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\Transaction;
use App\Models\User;
use App\Models\AuthorForm;
use App\Models\WithdrawCtv;
use App\Http\Controllers\Api\ApiRutController;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\AuthorFormMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;


class ProfileController extends Controller
{
  public function index()
  {
    $user                = User::find(auth()->user()->id);
    $stats               = [
      'balance'          => number_format($user->balance),
      'total_spent'      => number_format($user->total_deposit - $user->balance),
      'total_deposit'    => number_format($user->total_deposit),
      'deposit_in_month' => number_format(Transaction::where('user_id', $user->id)->where('type', 'deposit')->whereMonth('created_at', date('m'))->sum('amount')),
    ];
    $histories           = Logs::where('user_id', $user->id)->orderBy('id', 'desc')->get();
    $totalDepositInMonth = Transaction::where('user_id', $user->id)->where('type', 'deposit')->whereMonth('created_at', date('m'))->sum('amount');



    return view('account.profile.index', [
      'pageTitle' => ('Thông tin tài khoản'),
    ], compact('user', 'stats', 'histories', 'totalDepositInMonth'));
  }

  public function transactions()
{
    $user = auth()->user();

    $transaction = Transaction::where('user_id', $user->id)->orderBy('id', 'desc')->get();

    $chartCategories = [];
    for ($i = 1; $i <= date('d'); $i++) {
        $chartCategories[] = date('Y-m-d', strtotime(date('Y-m') . '-' . $i));
    }

    $chartSpent = [];
    $chartDeposit = [];
    foreach ($chartCategories as $chartCategory) {
        $chartSpent[] = Transaction::where('type', 'new-order')->whereDate('created_at', $chartCategory)->where('user_id', $user->id)->sum('amount');
        $chartDeposit[] = Transaction::where('type', 'deposit')->whereDate('created_at', $chartCategory)->where('user_id', $user->id)->sum('amount');
    }

    return view('account.profile.transactions', [
        'pageTitle' => 'Lịch Sử Giao Dịch',
        'user' => $user,
        'transaction' => $transaction,
        'chartCategories' => $chartCategories,
        'chartSpent' => $chartSpent,
        'chartDeposit' => $chartDeposit,
    ]);
}

  public function orders(Request $request)
  {
      $user = auth()->user();
      $tab = $request->query('tab', 'ai');

      $data = [];
      if ($tab === 'ai') {
          $data['orders'] = \App\Models\AiAccountOrder::with(['aiAccount.seller', 'variant', 'seller'])
              ->where('user_id', $user->id)
              ->orderBy('id', 'desc')
              ->get();
      } elseif ($tab === 'code') {
          $data['orders'] = \App\Models\Hisproduct::with(['product.user'])->where('user_id', $user->id)->orderBy('id', 'desc')->get();
      } elseif ($tab === 'domain') {
          $data['orders'] = \App\Models\DomainOrder::where('user_id', $user->id)->orderBy('id', 'desc')->get();
      } elseif ($tab === 'hosting') {
          $data['orders'] = \App\Models\PurchasedHosting::where('user_id', $user->id)->orderBy('id', 'desc')->get();
      } elseif ($tab === 'logo') {
          $data['orders'] = \App\Models\Hislogo::where('user_id', $user->id)->orderBy('id', 'desc')->get();
      } elseif ($tab === 'web') {
          $data['orders'] = \App\Models\Createweb::where('user_id', $user->id)->orderBy('id', 'desc')->get();
      }

      return view('account.profile.orders', [
          'pageTitle' => 'Lịch sử mua hàng',
          'user' => $user,
          'tab' => $tab,
          'data' => $data,
      ]);
  }

  public function chat(Request $request)
  {
      $user = auth()->user();
      
      $conversations = \App\Models\ChatConversation::with('seller')
          ->where('user_id', $user->id)
          ->orderBy('last_message_at', 'desc')
          ->get();

      $totalUnread = $conversations->sum('unread_user');

      $sellerId = $request->query('seller_id');
      $activeId = (int) $request->query('room', $conversations->first()?->id ?? 0);
      
      if ($sellerId) {
          $seller = \App\Models\User::find($sellerId);
          if ($seller) {
              $conv = $conversations->where('seller_id', $sellerId)->first();
              if ($conv) {
                  $activeId = $conv->id;
              } else {
                  $newConv = new \App\Models\ChatConversation([
                      'id' => 0,
                      'user_id' => $user->id,
                      'seller_id' => $seller->id,
                      'unread_user' => 0
                  ]);
                  $newConv->setRelation('seller', $seller);
                  $conversations->prepend($newConv);
                  $activeId = 0;
              }
          }
      }

      $activeConversation = $conversations->firstWhere('id', $activeId) ?? ($conversations->firstWhere('seller_id', $sellerId) ?? $conversations->first());
      $messages = collect();

      if ($activeConversation && $activeConversation->id > 0) {
          if ($activeConversation->unread_user > 0) {
              $unreadBefore = (int) $activeConversation->unread_user;
              $activeConversation->update(['unread_user' => 0]);
              $activeConversation->unread_user = 0;
              $totalUnread = max(0, $totalUnread - $unreadBefore);

              \App\Models\ChatMessage::where('conversation_id', $activeConversation->id)
                  ->where('sender_type', 'seller')
                  ->where('is_read', 0)
                  ->update(['is_read' => 1]);
          }

          $messages = \App\Models\ChatMessage::where('conversation_id', $activeConversation->id)
              ->orderBy('created_at', 'asc')
              ->get();
      }

      return view('account.profile.chat', [
          'pageTitle' => 'Tin nhắn hỗ trợ',
          'user' => $user,
          'conversations' => $conversations,
          'activeConversation' => $activeConversation,
          'messages' => $messages,
          'totalUnread' => $totalUnread,
      ]);
  }

  public function tokenUpdate(Request $request)
  {
    $user = User::find(auth()->user()->id);

    $user->tokens()->delete();

    $user->update([
      'access_token' => explode('|', $user->createToken('access_token')->plainTextToken)[1],
    ]);

    Helper::addLogs('Thay đổi access_token tài khoản thành công');

    return response()->json([
      'data'    => [
        'access_token' => $user->access_token,
      ],
      'status'  => 200,
      'message' => ('Cập nhật access_token thành công'),
    ]);
  }



  public function passwordUpdate(Request $request)
  {
    $payload = $request->validate([
      'old_password'     => 'required|string|min:6',
      'new_password'     => 'required|string|min:6',
      'confirm_password' => 'required|string|min:6',
    ]);

    if (env('PRJ_DEMO_MODE', false) === true) {
      return redirect()->back()->withErrors([
        'old_password' => ('Chức năng này không hoạt động trong chế độ demo'),
      ]);
    }

    $user = User::find(auth()->user()->id);

    if (!password_verify($payload['old_password'], $user->password)) {
      return redirect()->back()->withErrors([
        'old_password' => ('Mật khẩu cũ không chính xác'),
      ]);
    }
    if (Hash::check($payload['new_password'], $user->password)) {
      return redirect()->back()->withErrors([
          'old_password' => 'Vui lòng không sử dụng lại mật khẩu cũ',
      ]);
    }

    if ($payload['new_password'] !== $payload['confirm_password']) {
      return redirect()->back()->withErrors([
        'confirm_password' => ('Mật khẩu xác nhận không chính xác'),
      ]);
    }

    $user->password = bcrypt($payload['new_password']);

    if ($user->save()) {
      $user->tokens()->delete();

      $user->update([
        'access_token' => explode('|', $user->createToken('access_token')->plainTextToken)[1],
      ]);
    }

    Helper::addLogs('Thay đổi mật khẩu thành công');

    return redirect()->back()->with('success', ('Cập nhật mật khẩu thành công'));
  }
  public function Showhistory()
  {
      $user = auth()->user();
  
      $log = Logs::where('user_id', $user->id)->orderBy('id', 'desc')->get();
  
      return view('account.profile.history', [
          'pageTitle' => 'Lịch sử hoạt động',
          'user' => $user,
          'log' => $log,
      ]);
  }
  public function authorform()
  {
      $user = auth()->user();
      if ($user->level == 1) {
        return redirect()->route('home')->with('error', 'Bạn là admin không thể thực hiện cái này.');
      } elseif ($user->level == 2) {
        return redirect()->route('home')->with('error', 'Tài khoản của bạn đã là người bán hàng rồi.');
      }

      $application = AuthorForm::where('user_id', $user->id)->first();

      return view('account.profile.author-form', [
          'pageTitle' => 'Đăng ký trở thành người bán hàng',
          'user' => $user,
          'application' => $application,
      ]);
  }
  public function authorformPost(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_facebook' => 'nullable|url|max:255',
            'contact_telegram' => 'nullable|string|max:100',
            'description' => 'required|string|max:1000',
            'workCategory' => 'required|array|min:1',
            'team' => 'required|in:yes,no',
            'teamMembers' => 'required|string',
            'otherAccount' => 'required|in:yes,no',
            'marketAccount' => 'required|in:yes,no',
        ], [
            'shop_name.required' => 'Vui lòng nhập tên gian hàng.',
            'contact_phone.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'description.required' => 'Vui lòng nhập mô tả năng lực/kinh nghiệm.',
            'workCategory.required' => 'Vui lòng chọn ít nhất một danh mục muốn bán.',
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $check = AuthorForm::where('user_id', $user_id)->first();
        if ($check && $check->status == '0') {
          return redirect()->back()->with('error', 'Đã có đơn đăng ký tồn tại trên hệ thống vui lòng chờ duyệt!');
        }

        $data = [
            'user_id' => $user_id,
            'shop_name' => $request->shop_name,
            'contact_phone' => $request->contact_phone,
            'contact_facebook' => $request->contact_facebook,
            'contact_telegram' => $request->contact_telegram,
            'description' => $request->description,
            'team' => $request->team,
            'team_members' => $request->teamMembers,
            'other_account' => $request->otherAccount,
            'market_account' => $request->marketAccount,
            'work_category' => $request->workCategory,
            'status' => '0',
        ];

        if ($check) {
            $check->update($data);
        } else {
            AuthorForm::create($data);
        }

        $reg = redirect()->back()->with('success', 'Cảm ơn bạn đã gửi đơn, chúng tôi sẽ phản hồi sớm nhất!');

        try {
            Mail::to($user->email)->send(new AuthorFormMail($user));
        } catch (\Exception $e) {
            // Ghi log nếu lỗi mail, không chặn luồng đăng ký
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return $reg;
    }
    public function CtvView()
    {
        return redirect()->route('seller.revenue');
    }
    public function withdrawView()
    {
        return redirect()->route('seller.withdraw');
    }
  public function withdrawPost(Request $request)
    {   
      $message     = [
        'amount.required'      => 'Vui lòng nhập số tiền muốn rút.',
        'amount.integer'       => 'Số tiền muốn rút phải là số.',
        'bank.required' => 'Vui lòng chọn ngân hàng rút tiền.',
        'stk.required'   => 'Vui lòng nhập số tài khoản.',
        'ctk.required'       => 'Vui lòng nhập chủ tài khoản.',
      ];
      $payload     = $request->validate([
        'amount'      => 'required|integer',
        'bank' => 'required|string|max:12',
        'stk' => 'required|string|max:128',
        'ctk' => 'required|string|max:128',
      ], $message);

        $user = auth()->user();
        $user_id = $user->id;
        $config = Helper::getConfig('general');
        if (!isset($config['minctv'])) {
          return redirect()->back()->with('error', 'API Token is not set!');
        }
        $min_withdraw  = $config['minctv'] ?? 0;

        if ($payload['amount'] < $min_withdraw) {
          return redirect()->back()->with('error', 'Số tiền rút tối thiểu là ' . number_format($min_withdraw) . 'đ.');
        }
        if ($payload['amount'] > $user->balance_ctv) {
          return redirect()->back()->with('error', 'Bạn không đủ số dư để thực hiện rút tiền.');
        }
        $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();

        $setting = setting('rutctv');
        if ($setting === 'auto') {
          $description = 'rutctv'.$user->id;
          $walletOrders = WithdrawCtv::create([
            'user_id' => $user_id,
            'price' => $payload['amount'],
            'bank' => $payload['bank'],
            'stk' => $payload['stk'],
            'ctk' => $payload['ctk'],
            'status' => '0',
            'url' => env('LINK_API_RUTTIEN'),          
           ]);
           $apiRutController = new ApiRutController();
          $dvr = $apiRutController->transferWebme($walletOrders, $description);
           if ($dvr != 1) {
            return redirect()->back()->with('error', $dvr);
           }
           if ($user->decrement('balance_ctv', $payload['amount']) === false) {
            return redirect()->back()->with('error', 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.');
           }
           $reg = redirect()->back()->with('success', 'Cảm ơn bạn đã gửi đơn rút tiền chúng tôi sẽ duyệt tiền của bạn sớm nhất!');
        } else {

        $with = WithdrawCtv::create([
            'user_id' => $user_id,
            'trans_id' => $trans_id,
            'price' => $payload['amount'],
            'bank' => $payload['bank'],
            'stk' => $payload['stk'],
            'ctk' => $payload['ctk'],
            'status' => '0',
            'url' => 'localhost',          
           ]);
           Transaction::create([
            'code'           => $trans_id,
            'amount'         => $payload['amount'],
            'balance_before' => $user->balance_ctv + $payload['amount'],
            'balance_after'  => $user->balance_ctv,
            'type'           => 'new-order',
            'status'         => 'paid',
            'content'        => 'Rút tiền CTV; số tiền :' . number_format($payload['amount']) . 'đ; Thanh toán thành công cho người dùng ' . $user->username,
            'extras'         => [
              'id'         => $with->id,
              'order_code' => $trans_id,
            ],
            'user_id'        => $user->id,
            'username'       => $user->username,
            'order_id'       => $with->id,
          ]);
      
          Logs::create([
            'data'       => '0',
            'action'    => 'Rút tiền CTV số tiền' . number_format($payload['amount']) . 'đ',
            'description' => 'Thực hiện hành động Thành toán Tên Miền với địa chỉ ip' . request()->ip(),
            'old_data' => 0,
            'new_data' => 0,
            'user_id'    => $user->id,
            'ip' => request()->ip(),
            'data_json' => '',
          ]);
          if ($user->decrement('balance_ctv', $payload['amount']) === false) {
            return redirect()->back()->with('error', 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.');
           }
           $content = "┏━━━━━━━━━━━━━━━┓\n";
          $content .= "┣➤ ".$user->name."\n";
          $content .= "┣➤ Mã Giao Dịch: ".$trans_id."\n";
          $content .= "┣➤ NGÂN HÀNG: ".$payload['bank']."\n";
          $content .= "┣➤ CHỦ TÀI KHOẢN: ".$payload['ctk']."\n";
          $content .= "┣➤ SỐ TÀI KHOẢN: ".$payload['stk']."\n";
          $content .= "┣➤ Trạng Thái: CHỜ DUYỆT\n";
          $content .= "┣➤ Tiền rút: ". number_format($payload['amount']) ." đ\n";
          $content .= "┣➤ PHƯƠNG THỨC: DUYỆT TAY\n";
          $content .= "┗━━━━━━━━━━━━━━━┛\n";
        
          Helper::sendMessageTelegramAuto($content);
        $reg = redirect()->back()->with('success', 'Cảm ơn bạn đã gửi đơn rút tiền chúng tôi sẽ duyệt tiền của bạn sớm nhất!');
        }
        return $reg;
    }
}
