<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Events\LoginNoti;
class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $attributes = [
            'email'    => 'Email',
            'username' => 'Tên tài khoản',
            'password' => 'Mật khẩu',
          ];
      
        $messages = [

            'username.required'  => 'Trường tên tài khoản là bắt buộc.',
            'username.string'    => 'Trường tên tài khoản phải là một chuỗi.',
            'username.max'       => 'Trường tên tài khoản không được dài quá 255 ký tự.',
            'username.unique'    => 'Trường tên tài khoản đã được sử dụng.',
            'email.required'     => 'Trường email là bắt buộc.',
            'email.string'       => 'Trường email phải là một chuỗi.',
            'email.email'        => 'Trường email phải là một địa chỉ email hợp lệ.',
            'email.max'          => 'Trường email không được dài quá 255 ký tự.',
            'email.unique'       => 'Địa chỉ email đã được sử dụng.',
            
            'password.required'  => 'Trường mật khẩu là bắt buộc.',
            'username.regex'     => 'Trường tên tài khoản không hợp lệ.',
            'password.string'    => 'Trường mật khẩu phải là một chuỗi.',
            'password.min'       => 'Mật khẩu phải dài ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
          ];

        $valid = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
        ], $messages, $attributes);
    
        if ($valid->fails()) {
            return response()->json([
                'errors'  => $valid->errors(),
                'status'  => 400,
                'message' => $valid->errors()->first(),
            ], 400);
        } 
        $check_user = User::where('username', $request->username)->exists();

        if ($check_user) {
            return response()->json([
                'status' => 409,
                'message' => 'Tên đăng nhập đã tồn tại trong hệ thống',
            ], 409);
        }

        $exists = User::where('email', $request->email)->exists();

        if ($exists) {
            return response()->json([
                'status' => 409,
                'message' => 'Email đã tồn tại trong hệ thống',
            ], 409);
        }
    
        if ($request->username == $request->password) {
            return response()->json([
                'status' => 400,
                'message' => 'Tài khoản và mật khẩu không được giống nhau',
            ], 400);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->username,
            'email' => $request->email ?? time() . '@host.local',
            'access_token' => '',
            'level' => 0,
            'ip' => request()->ip(),
            'device' => request()->userAgent(),
            'balance' => 0,
            'balance_ctv' => 0,
            'total_deposit' => 0,
            'banned' => 0,
            'loai' => 'tk',
        ]);
        if ($user->id === 1 && User::count() === 1) {
            $user->update([
              'level' => '1',
            ]);
          }
          $user->update([
            'access_token' => explode('|', $user->createToken('access_token')->plainTextToken)[1],
          ]);
        if ($user) {
            Logs::create([
                'user_id' => $user->id,
                'action' => 'Đăng kí tài khoản',
                'data' => 0,
                'old_data' => 0,
                'new_data' => 0,
                'ip' => $request->ip(),
                'description' => "Thực hiện đăng kí tài khoản địa chỉ ip " . $request->ip(),
                'data_json' => '',
            ]);
            Auth::login($user);
            return response()->json([
                'data'    => [
                    'user_id'  => $user->id,
                    'username' => $user->username,
                    'redirect' => route('home'),
                ],
                'status'  => 201,
                'message' => 'Tài khoản ' . $user->username . ' đã được khởi tạo thành công',
                
            ], 201);
        }
    
        return response()->json([
            'status' => 500,
            'message' => 'Có lỗi xảy ra, vui lòng thử lại sau',
        ], 500);
    }
    
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home')->with('error', 'Bạn đã đăng nhập');

        }
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $attributes = [
            'username' => 'Tên tài khoản',
            'password' => 'Mật khẩu',
        ];
        $messages = [
            'required' => ':attribute không được để trống',
            'string' => ':attribute phải là chuỗi',
        ];
    
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
            'remember' => 'nullable',
        ], $messages, $attributes);
    
        $remember = $request->remember === 'on';
    
        $phase1 = Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember);
        $phase2 = $phase1 ? false : Auth::attempt(['email' => $request->username, 'password' => $request->password], $remember);
    
        if ($phase1 || $phase2) {
            $user = Auth::user();
            $user->ip = request()->ip();
            $user->device = request()->userAgent();
            $user->time_request = time();
            $user->save();
            Logs::create([
                'user_id' => $user->id,
                'action' => 'Đăng nhập thành công vào vào hệ thống',
                'data' => 0,
                'old_data' => 0,
                'new_data' => 0,
                'ip' => request()->ip(),
                'description' => "Thực hiện đăng nhập tài khoản qua website địa chỉ ip".request()->ip(),
                'data_json' => '',

            ]);
            broadcast(new LoginNoti(
                'Thông báo tài khoản ' . ($request->username) . ' đã online !',
                'notification'
            ));
            return response()->json([
                'status' => 200,
                'message' => 'Đăng nhập thành công.',
                'data' => [
                    'user' => $user,
                    'redirect' => redirect()->intended(route('home'))->getTargetUrl(),
                ],
            ]);
        }
    
        return response()->json([
            'status' => 401,
            'message' => 'Thông tin đăng nhập không chính xác.',
        ], 401);
    }
    
    public function LoginGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

  public function LoginGoogleCallback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        $check = User::where('email', $user->email)->first();
        if ($check) {
            Auth::login($check);
            return redirect()->route('home')->with('success', 'Đăng nhập thành công');
        } else {
            $newUser = User::create([
                'username' => $user->id,
                'password' => Hash::make($user->id),
                'name' => $user->name,
                'email' => $user->email ?? time() . '@host.local',
                'access_token' => '',
                'level' => 0,
                'ip' => request()->ip(),
                'device' => request()->userAgent(),
                'balance' => 0,
                'balance_ctv' => 0,
                'total_deposit' => 0,
                'banned' => 0,
                'loai' => 'gg',
            ]);
            if ($newUser->id === 1 && User::count() === 1) {
                $newUser->update([
                    'level' => '1',
                ]);
            }
            $newUser->update([
                'access_token' => explode('|', $newUser->createToken('access_token')->plainTextToken)[1],
            ]);
            if ($newUser) {
                Logs::create([
                    'user_id' => $newUser->id,
                    'action' => 'Đăng nhập google',
                    'data' => 0,
                    'old_data' => 0,
                    'new_data' => 0,
                    'ip' => request()->ip(),
                    'description' => "Thực hiện đăng nhập tài khoản bằng phương thức google địa chỉ ip" . request()->ip(),
                    'data_json' => '',

                ]);
                Auth::login($newUser);
                return redirect()->route('home')->with('success', 'Đăng nhập thành công');
            } else {
                return redirect()->back()->with('error', 'Đăng kí thất bại');
            }
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất thành công.');
    }
}