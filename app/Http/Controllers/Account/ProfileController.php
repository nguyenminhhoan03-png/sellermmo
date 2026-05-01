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
      return view('account.profile.author-form', [
          'pageTitle' => 'Đăng ký trở thành người bán hàng',
          'user' => $user,
      ]);
  }
  public function authorformPost(Request $request)
    {
        $request->validate([
            'team' => 'required|in:yes,no',
            'teamMembers' => 'required|string',
            'otherAccount' => 'required|in:yes,no',
            'marketAccount' => 'required|in:yes,no',
            'workCategory' => 'nullable|array',
        ]);
        $user = auth()->user();
        $user_id = $user->id;

        $check = AuthorForm::where('user_id', $user_id)->first();
        if ($check) {
          return redirect()->back()->with('error', 'Đã có đơn đăng ký tồn tại trên hệ thống vui lòng chờ duyệt!');
        }
        AuthorForm::create([
            'user_id' => $user_id,
            'team' => $request->team,
            'team_members' => $request->teamMembers,
            'other_account' => $request->otherAccount,
            'market_account' => $request->marketAccount,
            'work_category' => $request->workCategory,
            'status' => '0',
        ]);
        $reg = redirect()->back()->with('success', 'Cảm ơn bạn đã gửi đơn chúng tôi sẽ phản hồi bạn lại sớm nhất!');

        Mail::to($user->email)->send(new AuthorFormMail($user));

        return $reg;
    }
    public function CtvView()
  {
      $user = auth()->user();
      if ($user->level != 2) {
        return redirect()->route('home')->with('error', 'Bạn không phải là người bán hàng.');
      }
      $hisctv = Transaction::where('user_id', $user->id)->where('sys_note', 'ctv')->get();
      $totalDeposit = Transaction::where('user_id', $user->id)->where('type', 'new-order')->where('sys_note', 'ctv')->sum('amount');
      $totalDepositInMonth = Transaction::where('user_id', $user->id)->where('type', 'new-order')->where('sys_note', 'ctv')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('amount');
      $totalDepositInToday = Transaction::where('user_id', $user->id)->where('type', 'new-order')->where('sys_note', 'ctv')->whereDate('created_at', Carbon::today())->sum('amount');
      $totalDepositInWeek = Transaction::where('user_id', $user->id)->where('type', 'new-order')->where('sys_note', 'ctv')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
      return view('account.profile.ctv', [
          'pageTitle' => 'Quản lý doanh thu người bán hàng',
          'user' => $user,
          'hisctv' => $hisctv,
          'totalDeposit' => $totalDeposit,
          'totalDepositInMonth' => $totalDepositInMonth,
          'totalDepositInToday' => $totalDepositInToday,
          'totalDepositInWeek' => $totalDepositInWeek,
      ]);
  }
  public function withdrawView()
  {
    $user = auth()->user();
    if ($user->level != 2) {
      return redirect()->route('home')->with('error', 'Bạn không phải là người bán hàng.');
    }
    $whithdraw = WithdrawCtv::where('user_id', $user->id)->get();
      return view('account.profile.withdraw', [
          'pageTitle' => 'Rút tiền hoa hồng cho cộng tác viên',
          'user' => $user,
          'whithdraw' => $whithdraw
      ]);
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
