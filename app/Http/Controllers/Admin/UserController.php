<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index()
  {
    return view('admin.users.index');
  }
  public function edit($id)
  {
    $row = User::find($id);
    if (!$row) {
      return redirect()->route('admin.users.index')->with('error', 'User not found');
    }
    return view('admin.users.edit', [
      'pageTitle' => 'Chi tiết người dùng #' . $row->id,
    ],
    compact('row'));
  }
  public function update(Request $request, $id)
  {
    $action = $request->input('action', null);

    if ($action === 'info-users') {
      $payload = $request->validate([
        'username'                => 'required|string',
        'name'                => 'required|string',
        'email'               => 'required|email|unique:users,email,' . $id,
        'banned'              => 'required|in:1,0',
        'password'            => 'nullable|string|min:8',
        'access_token'        => 'required|string',
        'gioi_thieu'          => '',
        'level'               => 'required|in:0,1,2',
        'chat_id'             => 'nullable|string',
        'skill'               => '',
      ]);

      $user = User::findOrFail($id);

      if (isset($payload['password'])) {
        $payload['password'] = bcrypt($payload['password']);
      } else {
        unset($payload['password']);
      }

      $currentDeposit = $user->total_deposit;

      $user->update($payload);

      Helper::addLogs('Cập nhật thông tin của ' . $user->username . ' [' . $action . '] - [Tổng nạp: ' . formatCurrency($currentDeposit) . ']', $payload);

      return redirect()->back()->with('success', 'Cập nhật thông tin của ' . $user->username . ' thành công');
    } elseif ($action === 'cong-tien') {
      $payload = $request->validate([
        'amount' => 'required|numeric|min:0',
        'reason' => 'nullable|string|max:255',
      ]);

      $user = User::findOrFail($id);

      $user->balance += $payload['amount'];
      $user->total_deposit += $payload['amount'];
      $user->save();

      Transaction::create([
        'code'           => 'BMC-' . Helper::randomString(7, true),
        'amount'         => $payload['amount'],
        'balance_after'  => $user->balance,
        'balance_before' => $user->balance - $payload['amount'],
        'type'           => 'user-deposit',
        'extras'         => [
          'reason' => $payload['reason'] ?? '',
        ],
        'status'         => 'completed',
        'content'        => '#' . auth()->id() . ': ' . ($payload['reason'] ?? ''),
        'user_id'        => $user->id,
        'username'       => $user->username,
      ]);

      Helper::addLogs('Cộng tiền thành công cho ' . $user->username . ' [' . $action . ']', $payload);

      return redirect()->back()->with('success', 'Cộng tiền thành công cho ' . $user->username . ', số dư cuối : ' . number_format($user->balance) . ' đ');
    } elseif ($action === 'tru-tien') {
      $payload = $request->validate([
        'amount' => 'required|numeric|min:0',
        'reason' => 'nullable|string|max:255',
      ]);

      $user = User::findOrFail($id);

      $user->balance -= $payload['amount'];
      $user->save();

      Transaction::create([
        'code'           => 'BMC-' . Helper::randomString(7, true),
        'amount'         => $payload['amount'],
        'balance_after'  => $user->balance,
        'balance_before' => $user->balance + $payload['amount'],
        'type'           => 'admin-change',
        'extras'         => [
          'reason' => $payload['reason'] ?? '',
        ],
        'status'         => 'completed',
        'content'        => '#' . auth()->id() . ': ' . ($payload['reason'] ?? ''),
        'user_id'        => $user->id,
        'username'       => $user->username,
      ]);

      Helper::addLogs('Trừ tiền tài khoản ' . $user->username . ' thành công [' . $action . ']', $payload);

      return redirect()->back()->with('success', 'Trừ tiền tài khoản ' . $user->username . ', số dư cuối : ' . number_format($user->balance) . ' đ');
    }
  }
  public function loginTo($username)
  {

    Helper::addLogs('Đăng nhập vào tài khoản ' . $username . ' bằng tài khoản admin #' . auth()->user()->username);

    $user = User::where('username', $username)->firstOrFail();

    auth()->login($user);

    return redirect()->route('home');
  }
}  