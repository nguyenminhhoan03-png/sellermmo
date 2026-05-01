<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Helpers\Helper;
use App\Models\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
      return view('admin.settings.general');
    }
  
    public function update(Request $request)
    {
      $type = $request->input('type', null);
  
      if ($type === 'general') {
        $payload = $request->validate([
          'title'               => 'nullable|string|max:255',
          'favicon'             => 'nullable|file|mimes:png,jpg,jpeg,svg|max:20000',
          'ex_rate'             => 'nullable|numeric',
          'keywords'            => 'nullable|string|max:255',
          'thumbnail'           => 'nullable|file|mimes:png,jpg,jpeg,svg,gif|max:20000',
          'logo_dark'           => 'nullable|file|mimes:png,jpg,jpeg,svg,gif|max:20000',
          'logo_light'          => 'nullable|file|mimes:png,jpg,jpeg,svg,gif|max:20000',
          'description'         => 'nullable|string|max:255',
          'footer_text'         => 'nullable|string',
          'footer_link'         => 'nullable|string',
          'primary_lang'        => 'nullable|string|max:10',
          'rutctv'              => 'nullable|string|max:10',
          'minctv'              => 'nullable|numeric',
          'hosting' => 'nullable|numeric',
          'captcha_status'      => 'nullable|boolean',
          'captcha_siteKey'     => 'nullable|string',
          'captcha_secretKey'   => 'nullable|string',
          'ns1'  => 'nullable|string',
          'ns2'  => 'nullable|string',
        ]);
  
        $config = Config::firstOrCreate(['name' => $type], ['value' => []]);
  
        if ($request->hasFile('logo_dark')) {
          $payload['logo_dark'] = Helper::uploadFile($request->file('logo_dark'), 'public');
        } else {
          $payload['logo_dark'] = $config->value['logo_dark'] ?? null;
        }
  
        if ($request->hasFile('logo_light')) {
          $payload['logo_light'] = Helper::uploadFile($request->file('logo_light'), 'public');
        } else {
          $payload['logo_light'] = $config->value['logo_light'] ?? null;
        }
  
        if ($request->hasFile('favicon')) {
          $payload['favicon'] = Helper::uploadFile($request->file('favicon'), 'public');
        } else {
          $payload['favicon'] = $config->value['favicon'] ?? null;
        }
  
        if ($request->hasFile('thumbnail')) {
          $payload['thumbnail'] = Helper::uploadFile($request->file('thumbnail'), 'public');
        } else {
          $payload['thumbnail'] = $config->value['thumbnail'] ?? null;
        }
  
        $config->update([
          'value' => $payload,
        ]);
  
        Cache::forget('general_settings_' . domain());
  
        return redirect()->back()->with('success', 'Cập nhật cài đặt chung thành công.');
      } elseif ($type === 'theme_settings') {
        $payload = $request->validate([
          'auth_bg'         => 'nullable|file|mimes:png,jpg,jpeg,svg|max:20000',
          'ladi_name'       => 'nullable|string',
          'order_form_type' => 'nullable|string|in:default,form_csr',
        ]);
        $config = Config::firstOrCreate(['name' => $type], ['value' => []]);

        if ($request->hasFile('auth_bg')) {
          $payload['auth_bg'] = Helper::uploadFile($request->file('auth_bg'), 'public');
        } else {
            $payload['auth_bg'] = $config->value['auth_bg'] ?? null;
          }
  
        
  
        $config->update([
          'value' => $payload,
        ]);
  
        // return response()->json([
        //   'status'  => 200,
        //   'message' => __('Cập nhật cài đặt giao diện thành công.'),
        // ]);
        return redirect()->back()->with('success', __('Cập nhật cài đặt giao diện thành công.'));
      } elseif ($type === 'deposit_status') {
        $payload = $request->validate([
          'card'   => 'nullable|boolean',
          'bank'   => 'nullable|boolean',
          'crypto' => 'nullable|boolean',
        ]);
  
        $config = Config::firstOrCreate(['name' => $type], ['value' => []]);
  
        $config->update([
          'value' => $payload,
        ]);
  
        return response()->json([
          'status'  => 200,
          'message' => __('Cập nhật cài đặt giao diện thành công.'),
        ]);
      } elseif ($type === 'contact_info') {
        $payload = $request->validate([
          'email'    => 'nullable|string',
          'facebook' => 'nullable|string',
          'telegram' => 'nullable|string',
          'sdt' => 'nullable|string',
        ]);
  
        $config = Config::firstOrCreate(['name' => $type], ['value' => $payload]);
  
        $config->update([
          'value' => $payload,
        ]);
  
        // return redirect()->back()->with('success', 'Cập nhật thông tin liên hệ thành công.');
        return response()->json([
          'status'  => 200,
          'message' => __('Cập nhật thông tin liên hệ thành công.'),
        ]);
      } elseif ($type === 'deposit_info') {
        $payload = [
          'prefix'     => $_POST['prefix'] ?? 'hello ',
          'transfer' => $_POST['transfer'] ?? 'transfer ',
          'discount'   => (int) ($_POST['discount'] ?? 0),
          'min_amount' => (int) ($_POST['min_amount'] ?? 0),
        ];
  
        $config = Config::firstOrCreate(['name' => $type], ['value' => $payload]);
  
        $config->update([
          'value' => $payload,
        ]);
  
        // return redirect()->back()->with('success', 'Cập nhật thông tin nạp tiền thành công.');
        return response()->json([
          'status'  => 200,
          'message' => __('Cập nhật thông tin nạp tiền thành công'),
        ]);
      } elseif ($type === 'header_script') {
        $payload = $request->validate([
          'code' => 'nullable|string',
        ]);
  
        $config = Notification::firstOrCreate(['name' => $type], ['value' => $payload['code']]);
  
        $config->update([
          'value' => base64_encode($payload['code']),
        ]);
  
        return redirect()->back()->with('success', 'Cập nhật mã script thành công');
      } elseif ($type === 'footer_script') {
        $payload = $request->validate([
          'code' => 'nullable|string',
        ]);
  
        $config = Notification::firstOrCreate(['name' => $type], ['value' => $payload['code']]);
  
        $config->update([
          'value' => base64_encode($payload['code']),
        ]);
  
        return redirect()->back()->with('success', 'Cập nhật mã script thành công');
      } 
  
    }
    public function notices(Request $request)
    {
        foreach (Notification::get() as $item) {
            $notices[strtolower($item->name)] = $item->value;
        }

        return view('admin.settings.notices', $notices);
    }

    public function updateNotices(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'content' => 'nullable|string',
        ]);

        $type = $request->input('type', null);
        $value = $request->input('content', null);


        $config = Notification::firstOrCreate(['name' => $type], ['value' => '']);

        if ($config)
            $config->update([
                'value' => base64_encode($value),
            ]);
        else
            return back()->with('error', 'Cập nhật thông báo thất bại [' . $type . '].');

        return redirect()->back()->with('success', 'Cập nhật thông báo thành công [' . $type . '].');
    }
}
