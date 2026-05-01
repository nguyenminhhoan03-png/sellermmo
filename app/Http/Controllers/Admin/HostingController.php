<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryHosting;
use App\Models\Logs;
use App\Models\User;
use App\Models\WhmInfo;
use App\Models\Transaction;
use App\Models\HostingPackages;
use App\Models\PurchasedHosting;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HostingController extends Controller
{
  public function category_hosting_view()
  {
    $category_hosting = CategoryHosting::all();
    return view('admin.hosting.category', compact('category_hosting'));
  }
  public function category_hosting_store(Request $request)
  {
    $user = User::find(auth()->user()->id);
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->level != 1) {
      return response()->json([
        'status'  => 403,
        'message' => 'Bạn không phải là admin.',
      ], 403);
    }
    $payload = $request->validate([
      'name' => 'required|string|max:255',
      'anh' => 'required|string',
      'status' => 'required',

    ]);

    $category_hosting_store = CategoryHosting::create([
      'name' => $payload['name'],
      'anh' => $payload['anh'],
      'status' => $payload['status'],
    ]);
    Logs::create([
      'data'       => '0',
      'action'    => 'Đăng tải danh mục Hosting' . $payload['name'],
      'description' => 'Thực hiện hành động đăng danh mục Hosting với địa chỉ ip' . request()->ip(),
      'old_data' => 0,
      'new_data' => 0,
      'user_id'    => $user->id,
      'ip' => request()->ip(),
      'data_json' => '',
    ]);
    if ($category_hosting_store) {
      return redirect()->back()->with('success', 'Thêm danh mục Hosting thành công');
    } else {
      return redirect()->back()->with('error', 'Không thể tạo danh mục Hosting, hãy thử lại!');
    }
  }
  public function category_hosting_update(Request $request)
  {
    $user = User::find(auth()->user()->id);
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->level != 1) {
      return response()->json([
        'status'  => 403,
        'message' => 'Bạn không phải là admin.',
      ], 403);
    }
    $payload = $request->validate([
      'id'          => 'required|integer',
      'name' => 'required|string|max:255',
      'anh' => 'required|string',
      'status' => 'required',

    ]);

    $category_hosting_update = CategoryHosting::find($payload['id']);

    if (!$category_hosting_update) {
      return redirect()->route('admin.hosting.category')->with('error', 'Không tìm thấy danh mục Hosting #' . $payload['id']);
    }
    $category_hosting_update->update($payload);

    Logs::create([
      'data'       => '0',
      'action'    => 'Cập nhật danh mục Hosting' . $payload['name'] . '',
      'description' => 'Thực hiện hành động cập nhật danh mục Hosting với địa chỉ ip' . request()->ip(),
      'old_data' => 0,
      'new_data' => 0,
      'user_id'    => $user->id,
      'ip' => request()->ip(),
      'data_json' => '',
    ]);
    return redirect()->back()->with('success', 'Cập nhật danh mục Hosting thành công #' . $category_hosting_update->id);
  }
  public function category_hosting_delete(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $category_hosting_update = CategoryHosting::whereIn('id', $ids)->get();

      foreach ($category_hosting_update as $category_hosting_updates) {
        $category_hosting_updates->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều danh mục Hosting cùng lúc; số lượng: :count', ['count' => $category_hosting_update->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Danh mục Hosting đã được xóa thành công.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $category_hosting_updates = CategoryHosting::where('id', $payload['id'])->firstOrFail();
    $category_hosting_updates->delete();

    Helper::addLogs('Xóa danh mục Hosting #' . $category_hosting_updates->name);

    return response()->json([
      'status'  => 200,
      'message' => 'Danh mục Hosting đã được xóa thành công.',
    ]);
  }
  public function whm_info_view()
  {
    $whm_info = WhmInfo::all();
    $category_hosting = CategoryHosting::where('status', 1)->get();
    return view('admin.hosting.whm', compact('whm_info', 'category_hosting'));
  }
  public function whm_info_store(Request $request)
  {
    $payload = $request->validate([
      'category' => 'required|integer',
      'whm_host' => 'required|string|max:255',
      'whm_user' => 'required|string|max:255',
      'whm_pass' => 'required|string|max:255',
      'status' => 'required|boolean',
    ]);
    $whm_link = checkIpOrHostname($payload['whm_host']);

    $params = [
      'serverusername' => $payload['whm_user'],
      'serverpassword' => $payload['whm_pass'],
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => '',
    ];
    $whm_check = WhmInfo::where('whm_host', $payload['whm_host'])->first();
    if ($whm_check) {
      return response()->json([
        'status'  => 400,
        'message' => 'Máy chủ WHM đã tồn tại trên hệ thống.',
      ], 400);
    }
    $whm_link = checkIpOrHostname($payload['whm_host']);
    if ($whm_link) {
      $params['serverip'] = $payload['whm_host'];
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $payload['whm_host'];
    }
    $payload['accesshash'] = '';
    $response = cpanel_create_api_token($params);
    if (isset($response) && $response['message'] == 1) {
      $payload['accesshash'] = $response['api_token'];
      $vars = array(
        'api.version' => 1,
      );
      $reg = cpanel_get_ip($params, $vars);
      if (isset($reg) && $reg['message'] == 1) {
        $payload['ip'] = $reg['ip'];
      }
      WhmInfo::create($payload);
      Helper::addLogs('Tạo máy chủ hosting: ' . $payload['whm_host']);
      return response()->json([
        'status'  => 200,
        'message' => 'Thêm máy chủ WHM thành công.',
      ]);
    } else {
      return response()->json([
        'status'  => 400,
        'message' => 'cPanel API Response: ' . $response['error'],
      ], 400);
    }
  }
  public function whm_info_login(Request $request)
  {
    $payload = $request->validate([
      'whm_host' => 'required|string|max:255',
      'whm_user' => 'required|string|max:255',
      'whm_pass' => 'required|string|max:255',
    ]);

    $whm_link = checkIpOrHostname($payload['whm_host']);

    $params = [
      'serverusername' => $payload['whm_user'],
      'serverpassword' => $payload['whm_pass'],
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => '',
    ];

    if ($whm_link) {
      $params['serverip'] = $payload['whm_host'];
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $payload['whm_host'];
    }

    $whm = cpanel_TestConnection($params);

    return $whm;
  }
  public function whm_info_update(Request $request)
  {
    $user = User::find(auth()->user()->id);
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->level != 1) {
      return response()->json([
        'status'  => 403,
        'message' => 'Bạn không phải là admin.',
      ], 403);
    }
    $payload = $request->validate([
      'id'          => 'required|integer',
      'category' => 'required|integer',
      'whm_host' => 'required|string|max:255',
      'whm_user' => 'required|string|max:255',
      'whm_pass' => 'required|string|max:255',
      'status' => 'required|boolean',

    ]);

    $whm_info_update = WhmInfo::find($payload['id']);

    if (!$whm_info_update) {
      return redirect()->route('admin.hosting.category')->with('error', 'Không tìm thấy máy chủ WHM #' . $payload['id']);
    }
    $whm_info_update->update($payload);

    Logs::create([
      'data'       => '0',
      'action'    => 'Cập nhật máy chủ WHM' . $payload['whm_host'] . '',
      'description' => 'Thực hiện hành động cập nhật máy chủ WHM với địa chỉ ip' . request()->ip(),
      'old_data' => 0,
      'new_data' => 0,
      'user_id'    => $user->id,
      'ip' => request()->ip(),
      'data_json' => '',
    ]);
    return redirect()->back()->with('success', 'Cập nhật máy chủ WHM thành công #' . $whm_info_update->id);
  }
  public function whm_info_link_login(Request $request)
  {
    $payload = $request->validate([
      'id'          => 'required|integer',
    ]);
    $whm_info_update = WhmInfo::find($payload['id']);
    $whm_link = checkIpOrHostname($whm_info_update->whm_host);

    $params = [
      'serverusername' => $whm_info_update->whm_user,
      'serverpassword' => $whm_info_update->whm_pass,
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => '',
    ];

    if ($whm_link) {
      $params['serverip'] = $whm_info_update->whm_host;
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $whm_info_update->whm_host;
    }
    $user = $whm_info_update->whm_user;
    $service = 'whostmgrd';
    $app = '';
    $result = cpanel_SingleSignOn($params, $user, $service, $app);
    if (!$whm_info_update) {
      return $result;
    }
    return $result;
  }
  public function whm_info_delete(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $whm_info_update = WhmInfo::whereIn('id', $ids)->get();

      foreach ($whm_info_update as $whm_info_updates) {
        $whm_info_updates->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều Máy chủ WHM cùng lúc; số lượng: :count', ['count' => $whm_info_update->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Máy chủ WHM đã được xóa thành công.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $whm_info_updates = WhmInfo::where('id', $payload['id'])->firstOrFail();
    $whm_info_updates->delete();

    Helper::addLogs('Xóa Máy chủ WHM #' . $whm_info_updates->name);

    return response()->json([
      'status'  => 200,
      'message' => 'Máy chủ WHM đã được xóa thành công.',
    ]);
  }
  public function hosting_packages_view()
  {
    $hosting_packages_view = HostingPackages::all();
    $category_hosting = CategoryHosting::where('status', 1)->get();

    return view('admin.hosting.packages', compact('hosting_packages_view', 'category_hosting'));
  }
  public function hosting_packages_store(Request $request)
  {
    $user = User::find(auth()->user()->id);
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->level != 1) {
      return response()->json([
        'status'  => 403,
        'message' => 'Bạn không phải là admin.',
      ], 403);
    }
    $payload = $request->validate([
      'category' => 'required|integer',
      'package_name' => 'required|string|max:255',
      'price' => 'required|integer',
      'disk_quota' => 'required',
      'bandwidth_limit' => 'required',
      'max_subdomains' => 'required',
      'max_parked_domains' => 'required',
      'max_addon_domains' => 'required',
      'language' => 'required|string',
      'cpanel_module' => 'required|string',
      'description' => 'required|string',
      'status' => 'required',

    ]);
    $pack_check = HostingPackages::where('category', $payload['category'])->where('package_name', $payload['package_name'])->first();
    if ($pack_check) {
      return response()->json([
        'status'  => 400,
        'message' => 'Gói Hosting này đã tồn tại trên hệ thống.',
      ], 400);
    }
    $whm_cp = WhmInfo::where('category', $payload['category'])->first();
    if (!$whm_cp) {
      return response()->json([
        'status'  => 401,
        'message' => 'Danh mục này hiện tại chưa có máy chủ WHM nào',
      ], 401);
    }
    $whm_link = checkIpOrHostname($whm_cp->whm_host);

    $params = [
      'serverusername' => $whm_cp->whm_user,
      'serverpassword' => $whm_cp->whm_pass,
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => '',
    ];

    if ($whm_link) {
      $params['serverip'] = $whm_cp->whm_host;
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $whm_cp->whm_host;
    }
    if ($payload['bandwidth_limit'] == 'unlimited') {
      $payload['bandwidth_limit'] = 1048576;
    }
    $vars = array(
      'api.version' => 1,
      'name' => $payload['package_name'],
      'quota' => $payload['disk_quota'],
      'bwlimit' => $payload['bandwidth_limit'],
      'maxsub' => $payload['max_subdomains'],
      'maxpark' => $payload['max_parked_domains'],
      'maxaddon' => $payload['max_addon_domains'],
      'language' => $payload['language'],
      'cpmod' => $payload['cpanel_module'],
      'cgi' => 1,
    );
    $response = cpanel_createHostingPackageAPI($params, $vars);

    if (isset($response) && $response['message'] == 1) {
      HostingPackages::create([
        'category' => $payload['category'],
        'package_name' => $payload['package_name'],
        'language' => $payload['language'],
        'cpanel_module' => $payload['cpanel_module'],
        'price' => $payload['price'],
        'description' => base64_encode($payload['description']),
        'disk_quota' => $payload['disk_quota'],
        'bandwidth_limit' => $payload['bandwidth_limit'],
        'max_subdomains' => $payload['max_subdomains'],
        'max_parked_domains' => $payload['max_parked_domains'],
        'max_addon_domains' => $payload['max_addon_domains'],
        'created_at' => gettime(),
        'status' => $payload['status'],
      ]);
      Logs::create([
        'data'       => '0',
        'action'    => 'Đăng tải gói Hosting' . $payload['package_name'],
        'description' => 'Thực hiện hành động đăng gói Hosting với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);

      return response()->json([
        'status'  => 200,
        'message' => 'Thêm gói Hosting thành công',
      ], 200);
    } else {
      return response()->json([
        'status'  => 400,
        'message' => 'cPanel API Response: ' . $response['message'],
      ], 400);
    }
  }
  public function hosting_packages_delete(Request $request)
  {
    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $hosting_packages_delete = HostingPackages::where('id', $payload['id'])->firstOrFail();

    $whm_cp = WhmInfo::where('category', $hosting_packages_delete->category)->first();
    if (!$whm_cp) {
      return response()->json([
        'status'  => 401,
        'message' => 'Có vẻ như gói hosting này đang không có máy chủ WHM nào',
      ], 401);
    }
    $whm_link = checkIpOrHostname($whm_cp->whm_host);

    $params = [
      'serverusername' => $whm_cp->whm_user,
      'serverpassword' => $whm_cp->whm_pass,
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => $whm_cp->accesshash,
    ];

    if ($whm_link) {
      $params['serverip'] = $whm_cp->whm_host;
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $whm_cp->whm_host;
    }
    $pkgname = $whm_cp->whm_user . "_" . $hosting_packages_delete->package_name;

    $vars = array(
      'api.version' => 1,
      'pkgname' => $pkgname,
    );
    $response = cpanel_editHostingPackageAPI($params, $vars);

    if (isset($response) && $response['message'] == 1) {
      $hosting_packages_delete->delete();

      Helper::addLogs('Xóa gói Hosting #' . $hosting_packages_delete->package_name);
      return response()->json([
        'status'  => 200,
        'message' => 'Gói Hosting đã được xóa thành công.',
      ]);
    } else {
      return response()->json([
        'status'  => 400,
        'message' => 'cPanel API Response: ' . $response['message'],
      ], 400);
    }
  }
  public function hosting_packages_update(Request $request)
  {
    $user = User::find(auth()->user()->id);
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->level != 1) {
      return response()->json([
        'status'  => 403,
        'message' => 'Bạn không phải là admin.',
      ], 403);
    }
    $payload = $request->validate([
      'id' => 'required|integer',
      'category' => 'required|integer',
      'package_name' => 'required|string|max:255',
      'price' => 'required|integer',
      'disk_quota' => 'required',
      'bandwidth_limit' => 'required',
      'max_subdomains' => 'required',
      'max_parked_domains' => 'required',
      'max_addon_domains' => 'required',
      'language' => 'required|string',
      'cpanel_module' => 'required|string',
      'description' => 'required|string',
      'status' => 'required',
    ]);
    $payload['description'] = base64_encode($payload['description']);
    $hosting_packages_update = HostingPackages::find($payload['id']);

    if (!$hosting_packages_update) {
      return response()->json([
        'status'  => 400,
        'message' => 'Gói Hosting không tồn tại.',
      ], 400);
    }
    $whm_cp = WhmInfo::where('category', $payload['category'])->first();
    if (!$whm_cp) {
      return response()->json([
        'status'  => 401,
        'message' => 'Danh mục này hiện tại chưa có máy chủ WHM nào',
      ], 401);
    }
    $whm_link = checkIpOrHostname($whm_cp->whm_host);

    $params = [
      'serverusername' => $whm_cp->whm_user,
      'serverpassword' => $whm_cp->whm_pass,
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => '',
    ];

    if ($whm_link) {
      $params['serverip'] = $whm_cp->whm_host;
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $whm_cp->whm_host;
    }
    if ($payload['bandwidth_limit'] == 'unlimited') {
      $payload['bandwidth_limit'] = 1048576;
    }
    $vars = array(
      'api.version' => 1,
      'name' => $payload['package_name'],
      'quota' => $payload['disk_quota'],
      'bwlimit' => $payload['bandwidth_limit'],
      'maxsub' => $payload['max_subdomains'],
      'maxpark' => $payload['max_parked_domains'],
      'maxaddon' => $payload['max_addon_domains'],
      'language' => $payload['language'],
      'cpmod' => $payload['cpanel_module'],
      'cgi' => 1,
    );
    $response = cpanel_editHostingPackageAPI($params, $vars);
    if (isset($response) && $response['message'] == 1) {
      $hosting_packages_update->update($payload);
      Logs::create([
        'data'       => '0',
        'action'    => 'Đăng tải gói Hosting' . $payload['package_name'],
        'description' => 'Thực hiện hành động cập nhật gói Hosting với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);

      return response()->json([
        'status'  => 200,
        'message' => 'Cập nhật gói Hosting thành công',
      ], 200);
    } else {
      return response()->json([
        'status'  => 400,
        'message' => 'cPanel API Response: ' . $response['message'],
      ], 400);
    }
  }
  public function hosting_list_view(Request $request)
  {
    $host = PurchasedHosting::get();
    return view('admin.hosting.list', compact('host'));
  }
  public function update_giahan(Request $request)
  {
    $payload = $request->validate([
      'id'     => 'required|integer',
      'status' => 'required|boolean',
    ]);

    $product = PurchasedHosting::where('id', $payload['id'])->firstOrFail();

    $product->update([
      'giahan' => $payload['status'],
    ]);

    return response()->json([
      'status'  => 200,
      'message' => 'Cập nhật trạng thái gia hạn auto thành công.',
    ]);
  }
  public function hosting_SuspendAccount(Request $request)
  {
    $user = User::find(auth()->user()->id);
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->level != 1) {
      return response()->json([
        'status'  => 403,
        'message' => 'Bạn không phải là admin.',
      ], 403);
    }
    $payload = $request->validate([
      'suspendreason' => 'required|string|max:255',
      'id' => 'required|integer',
    ]);
    $host = PurchasedHosting::find($payload['id']);
    if (!$host) {
      return response()->json([
        'status'  => 400,
        'message' => 'Không tìm thấy hosting cần khóa.',
      ], 400);
    }
    $whm_link = checkIpOrHostname($host->server_whm['whm_host']);

    $params = [
      'serverusername' => $host->server_whm['whm_user'],
      'serverpassword' => $host->server_whm['whm_pass'],
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => $host->server_whm['accesshash'],
      'type' => 'cpanelaccount',
      'username' => $host->username,
      'suspendreason' => $payload['suspendreason'],
    ];
    if ($whm_link) {
      $params['serverip'] = $host->server_whm['whm_host'];
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $host->server_whm['whm_host'];
    }
    $response = cpanel_SuspendAccount($params);
    if (isset($response) && $response['message'] == 1) {
      $host->update([
        'status' => 0,
      ]);
      Logs::create([
        'data'       => '0',
        'action'    => 'Đăng tải gói Hosting' . $host->id,
        'description' => 'Thực hiện hành động khóa Hosting với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);

      return response()->json([
        'status'  => 200,
        'message' => 'Khóa hosting thành công',
      ], 200);
    } else {
      return response()->json([
        'status'  => 400,
        'message' => 'cPanel API Response: ' . $response['message'],
      ], 400);
    }
  }
  public function hosting_UnsuspendAccount(Request $request)
  {
    $user = User::find(auth()->user()->id);
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->level != 1) {
      return response()->json([
        'status'  => 403,
        'message' => 'Bạn không phải là admin.',
      ], 403);
    }
    $payload = $request->validate([
      'id' => 'required|integer',
    ]);
    $host = PurchasedHosting::find($payload['id']);
    if (!$host) {
      return response()->json([
        'status'  => 400,
        'message' => 'Không tìm thấy hosting cần khóa.',
      ], 400);
    }
    if ($host->status != 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Hosting này chưa bị khóa hoặc đã hết hạn.',
      ], 400);
    }
    $whm_link = checkIpOrHostname($host->server_whm['whm_host']);

    $params = [
      'serverusername' => $host->server_whm['whm_user'],
      'serverpassword' => $host->server_whm['whm_pass'],
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => $host->server_whm['accesshash'],
      'type' => 'cpanelaccount',
      'username' => $host->username,
    ];
    if ($whm_link) {
      $params['serverip'] = $host->server_whm['whm_host'];
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $host->server_whm['whm_host'];
    }
    $response = cpanel_UnsuspendAccount($params);
    if (isset($response) && $response['message'] == 1) {
      $host->update([
        'status' => 2,
      ]);
      Logs::create([
        'data'       => '0',
        'action'    => 'Đăng tải gói Hosting' . $host->id,
        'description' => 'Thực hiện hành động mở khóa Hosting với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);

      return response()->json([
        'status'  => 200,
        'message' => 'Mở khóa hosting thành công',
      ], 200);
    } else {
      return response()->json([
        'status'  => 400,
        'message' => 'cPanel API Response: ' . $response['message'],
      ], 400);
    }
  }
  public function hosting_DeleteAccount(Request $request)
  {

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $host = PurchasedHosting::where('id', $payload['id'])->firstOrFail();

    $whm_link = checkIpOrHostname($host->server_whm['whm_host']);

    $params = [
      'serverusername' => $host->server_whm['whm_user'],
      'serverpassword' => $host->server_whm['whm_pass'],
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => $host->server_whm['accesshash'],
    ];

    if ($whm_link) {
      $params['serverip'] = $host->server_whm['whm_host'];
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $host->server_whm['whm_host'];
    }
    $vars = array(
      'api.version' => 1,
      'username' => $host->username,
    );
    $response = cpanel_DeleteAccount($params, $vars);
    if (isset($response) && $response['message'] == 1) {

      $host->delete();
      Helper::addLogs('Xóa hosting #' . $host->id);
      return response()->json([
        'status'  => 200,
        'message' => 'hosting đã được xóa thành công.',
      ]);
    } else {
      return response()->json([
        'status'  => 400,
        'message' => 'cPanel API Response: ' . $response['message'],
      ], 400);
    }
  }
  public function Login(Request $request)
  {
    $payload = $request->validate([
      'id'          => 'required|integer',
    ]);
    $host = PurchasedHosting::find($payload['id']);
    $whm_link = checkIpOrHostname($host->server_whm['whm_host']);

    $params = [
      'serverusername' => $host->server_whm['whm_user'],
      'serverpassword' => $host->server_whm['whm_pass'],
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => '',
    ];

    if ($whm_link) {
      $params['serverip'] = $host->server_whm['whm_host'];
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $host->server_whm['whm_host'];
    }
    $user = $host->username;
    $service = 'cpaneld';
    $app = '';
    $result = cpanel_SingleSignOn($params, $user, $service, $app);
    if ($result['success'] == true) {
      if (isset($result['redirectTo'])) {
        return response()->json([
          'success' => true,
          'message' => 'Đã chuyển hướng tới cpanel thành công',
          'redirectTo' => $result['redirectTo'],
        ], 200);
      } else {
        return response()->json([
          'status' => 400,
          'message' => 'redirectTo không có trong kết quả trả về',
        ], 400);
      }
    } else {
      $content = "Thông Báo Lỗi\n";
      $content .= 'cPanel API Response: ' . $result['errorMsg'];
      Helper::sendMessageTelegramAuto($content);
      return $result;
    }
  }
  public function changePackage(Request $request)
  {
    $payload = $request->validate([
      'id' => 'required|integer',
      'money_user' => 'required|integer',
      'category' => 'required|integer',
    ]);
    $host = PurchasedHosting::find($payload['id']);
    if (!$host) {
      return response()->json([
        'status'  => 404,
        'message' => 'Không tìm thấy hosting.',
      ], 404);
    }
    $user = User::where('id', $host->user_id)->first();
    if (!$user) {
      return response()->json([
        'status'  => 404,
        'message' => 'Không tìm thấy tài khoản user này.',
      ], 404);
    }
    $pack = HostingPackages::find($payload['category']);
    if (!$pack) {
      return response()->json([
        'status'  => 404,
        'message' => 'Không tìm thấy gói hosting này.',
      ], 404);
    }
    $whm_link = checkIpOrHostname($host->server_whm['whm_host']);
    if ($host->server_whm['whm_user'] == 'root') {
      $package = $pack->package_name;
    } else {
      $package = $host->server_whm['whm_user'] . '_' . $pack->package_name;
    }
    $params = [
      'serverusername' => $host->server_whm['whm_user'],
      'serverpassword' => $host->server_whm['whm_pass'],
      'serverhttpprefix' => 'https',
      'serverport' => 2087,
      'serversecure' => true,
      'serveraccesshash' => $host->server_whm['accesshash'],
      'type' => 'cpanelaccount',
      'username' => $host->username,
      'pkg' => $package,
    ];
    if ($whm_link) {
      $params['serverip'] = $host->server_whm['whm_host'];
      $params['serverhostname'] = null;
    } else {
      $params['serverip'] = null;
      $params['serverhostname'] = $host->server_whm['whm_host'];
    }
    if ($payload['money_user'] == 1) {
      $response = cpanel_ChangePackage($params);
      if (isset($response) && $response['message'] == 1) {
        $month = $host->month;
        $price = $pack->price;
        $total = $month * $price;

        if ($user->balance < $total - $host->total) {
          return response()->json([
            'status'  => 403,
            'message' => 'Tài khoản của bạn không đủ để thực hiện hành động này',
          ], 403);
        }
        if ($user->decrement('balance', $total - $host->total) === false) {
          return response()->json([
            'status'  => 500,
            'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
          ], 500);
        }
        $host->update([
          'info_package' => $pack,
          'price' => $host->price + ($price - $host->price),
          'total' => $host->total + ($total - $host->total),
        ]);
        $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
        Transaction::create([
          'code'           => $trans_id,
          'amount'         => $total,
          'balance_before' => $user->balance + $total,
          'balance_after'  => $user->balance,
          'type'           => 'new-order',
          'status'         => 'paid',
          'content'        => 'Nâng cấp gói hosting #' . $host->id . ' thành công Thanh toán thành công cho người dùng ' . $user->username,
          'extras'         => [
            'id'         => $host->id,
            'order_code' => $trans_id,
          ],
          'user_id'        => $user->id,
          'username'       => $user->username,
          'order_id'       => $host->id,
        ]);
        Logs::create([
          'data'       => '0',
          'action'    => 'nâng cấp gói hosting #' . $host->id . ' với gói #' . $pack->package_name,
          'description' => 'Thực hiện hành động mua hosting với địa chỉ ip' . request()->ip(),
          'old_data' => 0,
          'new_data' => 0,
          'user_id'    => $user->id,
          'ip' => request()->ip(),
          'data_json' => '',
        ]);
      }
      return response()->json([
        'status'  => 200,
        'message' => 'Thay đổi gói hosting thành công',
      ], 200);
    } else {
      $response = cpanel_ChangePackage($params);
      if (isset($response) && $response['message'] == 1) {
        $month = $host->month;
        $price = $pack->price;
        $total = $month * $price;
        $host->update([
          'info_package' => $pack,
          'price' => $host->price + ($price - $host->price),
          'total' => $host->total + ($total - $host->total),
        ]);
      }
      Logs::create([
        'data'       => '0',
        'action'    => 'nâng cấp gói hosting #' . $host->id . ' với gói #' . $pack->package_name,
        'description' => 'Thực hiện hành động mua hosting với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);
      return response()->json([
        'status'  => 200,
        'message' => 'Thay đổi gói hosting thành công',
      ], 200);
    }
  }
}
