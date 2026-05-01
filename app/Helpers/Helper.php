<?php

/**
 * @author muabanwebsite.io.vn
 * @package HelperClasses
 *
 * @version 1.0.0
 */

namespace App\Helpers;

use App\Models\Logs;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;


class Helper
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }


  public static function muabanwebsite_enc($string)
  {
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', 'duykhanh');
    $iv = substr(hash('sha256', 'dichvuright.cam'), 0, 16); // IV giữ nguyên để backward-compat với dữ liệu cũ
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
  }
  public static function muabanwebsite_dec($string)
  {
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', 'duykhanh');
    $iv = substr(hash('sha256', 'dichvuright.cam'), 0, 16); // IV giữ nguyên để backward-compat với dữ liệu cũ
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    return $output;
  }
  /** @deprecated dùng muabanwebsite_enc() */
  public static function dichvuright_enc($string) { return self::muabanwebsite_enc($string); }
  /** @deprecated dùng muabanwebsite_dec() */
  public static function dichvuright_dec($string) { return self::muabanwebsite_dec($string); }
  public static function getConfig($name, $default = null, $type = 'config')
  {
    switch ($type) {
      case 'config':
        $config = \App\Models\Config::where('name', $name)->first();
        if ($config) {
          return $config->value;
        } else {
          \App\Models\Config::create(['name' => $name, 'value' => $default]);
        }

        return $default;
      case 'api':
        $config = \App\Models\ApiConfig::where('name', $name)->first();
        if ($config) {
          return $config->value;
        } else {
          \App\Models\ApiConfig::create(['name' => $name, 'value' => $default]);
        }

        return $default;
      default:
        return $default;
    }
  }

  public static function setConfig($name, $data = [], $type = 'config')
  {
    switch ($type) {
      case 'config':
        $config = \App\Models\Config::firstOrCreate(['name' => $name], ['value' => $data]);

        return $config->update(['value' => $data]);
      case 'api':
        $config = \App\Models\ApiConfig::firstOrCreate(['name' => $name], ['value' => $data]);

        return $config->update(['value' => $data]);
      default:
        return null;
    }
  }

  public static function getNotice($name, $default = '')
  {
    $notice = \App\Models\Notification::where('name', $name)->first();
    if ($notice) {
      return $notice->value;
    } else {
      \App\Models\Notification::create(['name' => $name, 'value' => $default]);
    }

    return $default;
  }

  public static function getApiConfig($name, $key = null, $default = '')
  {
    $config = \App\Models\ApiConfig::where('name', $name)->first();
    if ($config) {
      if ($key) {
        return $config->value[$key] ?? $config->value;
      }
      return $config->value;
    } else {
      \App\Models\ApiConfig::create(['name' => $name, 'value' => $default]);
    }

    return $default;
  }
  public static function random($chars, $length = 2)
  {
    $randomString = '';
    $charLength = strlen($chars);

    for ($i = 0; $i < $length; $i++) {
      $randomString .= $chars[rand(0, $charLength - 1)];
    }

    return $randomString;
  }
  public static function randoms($chars, $length = 2)
  {
    return substr(str_shuffle($chars), 0, $length);
  }

  public static function getDiscountByRank($rank, $amount = null)
  {
    $config = self::getConfig('rank_discount', []);

    $discount = (int) ($config[$rank] ?? 0);

    if ($amount) {
      return $amount - ($amount * $discount) / 100;
    }

    return $discount;
  }

  // function for string
  public static function text2array($string)
  {
    $array = explode("\n", $string);
    $array = array_filter($array, function ($value) {
      return $value !== '';
    });

    return $array;
  }

  public static function validStatusCode($statusCode)
  {
    $statusCode = intval($statusCode);

    if ($statusCode < 100 || $statusCode > 599) {
      $statusCode = 422;
    }

    return $statusCode;
  }
  public static function status_hosting_view($status, $type = 'html')
  {
    switch ($status) {
      case '2':
        return $type == 'html' ? '<div class="d-flex align-items-center gap-2 text-success">
                                            <i class="fa-solid fa-circle" style="font-size: 5px;"></i>
                                            <span>Đang sử dụng</span>
                                        </div>' : 'Đang sử dụng';
      case '3':
        return $type == 'html' ? '<div class="d-flex align-items-center gap-2 text-primary">
                                            <i class="fa-solid fa-circle" style="font-size: 5px;"></i>
                                            <span>Đã hết hạn sử dụng</span>
                                        </div>' : 'Đã hết hạn sử dụng';
      case '0':
        return $type == 'html' ? '<div class="d-flex align-items-center gap-2 text-danger">
                                            <i class="fa-solid fa-circle" style="font-size: 5px;"></i>
                                            <span>Đã bị khóa</span>
                                        </div>' : 'Đã bị khóa';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_hosting_admin($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge bg-success">Đang hoạt động</span>' : 'Đang hoạt động';
      case '1':
        return $type == 'html' ? '<span class="badge bg-warning">Đang tạo hosting</span>' : 'Đang tạo hosting';
      case '3':
        return $type == 'html' ? '<span class="badge bg-danger">Đã hết hạn</span>' : 'Đã hết hạn';
      case '0':
        return $type == 'html' ? '<span class="badge bg-danger">Đang Bị Khóa</span>' : 'Đang Bị Khóa';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_hosting($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge badge-success">Đang hoạt động</span>' : 'Đang hoạt động';
      case '1':
        return $type == 'html' ? '<span class="badge badge-warning">Đang tạo hosting</span>' : 'Đang tạo hosting';
      case '3':
        return $type == 'html' ? '<span class="badge badge-danger">Đã hết hạn</span>' : 'Đã hết hạn';
      case '0':
        return $type == 'html' ? '<span class="badge badge-danger">Đang Bị Khóa</span>' : 'Đang Bị Khóa';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function formatRank($rank)
  {
    return ucfirst($rank);
  }
  public static function status_blogs_admin($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '1':
        return $type == 'html' ? '<span class="badge bg-success">Hiển Thị</span>' : 'Hiển Thị';
      case '0':
        return $type == 'html' ? '<span class="badge bg-danger">Ẩn</span>' : 'Ẩn';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_voucher_admin($expire_date, $type = 'html')
  {
    if (now()->greaterThan($expire_date)) {
      return $type == 'html' ? '<span class="badge bg-danger">Đã hết hạn</span>' : 'Đã hết hạn';
    } else {
      return $type == 'html' ? '<span class="badge bg-success">Đang hoạt động</span>' : 'Đang hoạt động';
    }
  }
  public static function status_tranfer_admin($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge bg-success">Đã thanh toán</span>' : 'Đã thanh toán';
      case '1':
        return $type == 'html' ? '<span class="badge bg-warning">Đang chờ thanh toán</span>' : 'Đang chờ thanh toán';
      case '3':
        return $type == 'html' ? '<span class="badge bg-danger">Đã hủy</span>' : 'Đã hủy';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_tranfer($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge badge-success">Đã thanh toán</span>' : 'Đã thanh toán';
      case '1':
        return $type == 'html' ? '<span class="badge badge-warning">Đang chờ thanh toán</span>' : 'Đang chờ thanh toán';
      case '3':
        return $type == 'html' ? '<span class="badge badge-danger">Đã hủy</span>' : 'Đã hủy';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function type_tranfer_admin($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case 'code':
        return $type == 'html' ? '<span class="badge bg-outline-danger">Mã Nguồn</span>' : 'Mã Nguồn';
      case 'domain':
        return $type == 'html' ? '<span class="badge bg-outline-danger">Tên Miền</span>' : 'Tên Miền';
      case 'hosting':
          return $type == 'html' ? '<span class="badge bg-outline-danger">Hosting</span>' : 'Hosting';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function type_tranfer($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case 'code':
        return $type == 'html' ? '<span class="badge badge-light-danger">Mã Nguồn</span>' : 'Mã Nguồn';
      case 'domain':
        return $type == 'html' ? '<span class="badge badge-light-danger">Tên Miền</span>' : 'Tên Miền';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_server_cron_admin($status, $type = 'html')
  {
    switch ($status) {
      case '1':
        return $type == 'html' ? '<span class="badge bg-success">Đang hoạt động</span>' : 'Đang hoạt động';
      case '0':
        return $type == 'html' ? '<span class="badge bg-danger">Không hoạt động</span>' : 'Không hoạt động';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_server_cron($status, $type = 'html')
  {
    switch ($status) {
      case 'hoatdong':
        return $type == 'html' ? '<span class="badge badge-light-success">Đang chạy</span>' : 'Đang chạy';
      case 'tamdung':
        return $type == 'html' ? '<span class="badge badge-light-warning">Tạm dừng</span>' : 'Tạm dừng';
      case 'loi':
        return $type == 'html' ? '<span class="badge badge-light-danger">Lỗi</span>' : 'Lỗi';
      case 'hethan':
        return $type == 'html' ? '<span class="badge badge-light-primary">Hết hạn</span>' : 'Hết hạn';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_code_admin($status, $type = 'html')
  {
    switch ($status) {
      case '1':
        return $type == 'html' ? '<span class="badge bg-success">Đang hoạt động</span>' : 'Đang hoạt động';
      case '2':
        return $type == 'html' ? '<span class="badge bg-warning">Đang chờ xử lý</span>' : 'Đang chờ xử lý';
      case '0':
        return $type == 'html' ? '<span class="badge bg-danger">Không hoạt động</span>' : 'Không hoạt động';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function statuscard($status, $type = 'html')
  {
    switch ($status) {
      case 'Completed':
        return $type == 'html' ? '<span class="badge badge-success">Thẻ đúng	</span>' : 'Thẻ đúng	';
      case 'Cancelled':
        return $type == 'html' ? '<span class="badge badge-warning">Thẻ sai hoặc đã được sử dụng</span>' : 'Thẻ sai hoặc đã được sử dụng';
      case 'Processing':
        return $type == 'html' ? '<span class="badge badge-warning">Thẻ đang được sử lý</span>' : 'Thẻ đang được sử lý';
      case 'Error':
        return $type == 'html' ? '<span class="badge badge-danger">Thẻ sai hoặc đã được sử dụng</span>' : 'Thẻ sai hoặc đã được sử dụng';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_domain_admin($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge bg-success">Đang hoạt động</span>' : 'Đang hoạt động';
      case '1':
        return $type == 'html' ? '<span class="badge bg-warning">Đang chờ duyệt</span>' : 'Đang chờ duyệt';
      case '3':
        return $type == 'html' ? '<span class="badge bg-danger">Không còn hoạt động</span>' : 'Không còn hoạt động';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function statusdomain($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge badge-success">Đang hoạt động</span>' : 'Đang hoạt động';
      case '1':
        return $type == 'html' ? '<span class="badge badge-warning">Đang chờ duyệt</span>' : 'Đang chờ duyệt';
      case '3':
        return $type == 'html' ? '<span class="badge badge-danger">Không còn hoạt động</span>' : 'Không còn hoạt động';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_withdraw_admin($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge bg-success">Thành Công</span>' : 'Thành Công';
      case '1':
        return $type == 'html' ? '<span class="badge bg-warning">Đang chuyển tiền</span>' : 'Đang chuyển tiền';
      case '3':
        return $type == 'html' ? '<span class="badge bg-danger">Thất Bại</span>' : 'Thất Bại';
      case '0':
        return $type == 'html' ? '<span class="badge bg-warning">Chờ xử lý</span>' : 'Chờ xử lý';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_ns_admin($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '1':
        return $type == 'html' ? '<span class="badge bg-success">ns đã được trỏ</span>' : 'Đã hoàn thành';
      case '0':
        return $type == 'html' ? '<span class="badge bg-warning">Đang chờ trỏ ns</span>' : 'Chờ xử lý';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_ns_client($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '1':
        return $type == 'html' ? '<span class="badge badge-success">ns đã được trỏ</span>' : 'Đã hoàn thành';
      case '0':
        return $type == 'html' ? '<span class="badge badge-warning">Đang chờ trỏ ns</span>' : 'Chờ xử lý';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_web_client($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge badge-success">Đang hoạt động</span>' : 'Đã hoàn thành';
      case '1':
        return $type == 'html' ? '<span class="badge badge-danger">Đã hủy đơn</span>' : 'Đã hủy đơn';
      case '3':
        return $type == 'html' ? '<span class="badge badge-danger">Thất Bại</span>' : 'Thất Bại';
      case '4':
        return $type == 'html' ? '<span class="badge badge-danger">Đã hết hạn</span>' : 'Đã hết hạn';
     case '5':
        return $type == 'html' ? '<span class="badge badge-danger">Đã bị khóa</span>' : 'Đã bị khóa';
      case '0':
        return $type == 'html' ? '<span class="badge badge-warning">Chờ xử lý</span>' : 'Chờ xử lý';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_web_admin($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge bg-success">Website đã được tạo</span>' : 'Đã hoàn thành';
      case '1':
        return $type == 'html' ? '<span class="badge bg-danger">Đã hủy đơn</span>' : 'Đã hủy đơn';
      case '3':
        return $type == 'html' ? '<span class="badge bg-danger">Thất Bại</span>' : 'Thất Bại';
      case '4':
        return $type == 'html' ? '<span class="badge bg-danger">Đã hết hạn</span>' : 'Đã hết hạn';
      case '5':
        return $type == 'html' ? '<span class="badge bg-danger">Đã bị khóa</span>' : 'Đã bị khóa';
      case '0':
        return $type == 'html' ? '<span class="badge bg-warning">Chờ xử lý</span>' : 'Chờ xử lý';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_logo_admin($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge bg-success">Đã hoàn thành</span>' : 'Đã hoàn thành';
      case '1':
        return $type == 'html' ? '<span class="badge bg-danger">Đã hủy đơn</span>' : 'Đã hủy đơn';
      case '3':
        return $type == 'html' ? '<span class="badge bg-danger">Thất Bại</span>' : 'Thất Bại';
      case '0':
        return $type == 'html' ? '<span class="badge bg-warning">Chờ xử lý</span>' : 'Chờ xử lý';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function status_logo_client($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge badge-success">Đã hoàn thành</span>' : 'Đã hoàn thành';
      case '1':
        return $type == 'html' ? '<span class="badge badge-danger">Đã hủy đơn</span>' : 'Đã hủy đơn';
      case '3':
        return $type == 'html' ? '<span class="badge badge-danger">Thất Bại</span>' : 'Thất Bại';
      case '0':
        return $type == 'html' ? '<span class="badge badge-warning">Chờ xử lý</span>' : 'Chờ xử lý';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function statuswithdraw($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case '2':
        return $type == 'html' ? '<span class="badge badge-success">Thành Công</span>' : 'Thành Công';
      case '1':
        return $type == 'html' ? '<span class="badge badge-warning">Đang chuyển tiền</span>' : 'Đang chuyển tiền';
      case '3':
        return $type == 'html' ? '<span class="badge badge-danger">Thất Bại</span>' : 'Thất Bại';
      case '0':
        return $type == 'html' ? '<span class="badge badge-warning">Chờ xử lý</span>' : 'Chờ xử lý';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function format_status_admin($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case 'paid':
        return $type == 'html' ? '<span class="badge bg-success">Đã thanh toán</span>' : 'Đã thanh toán';
      case 'unpaid':
        return $type == 'html' ? '<span class="badge bg-danger">Chưa thanh toán</span>' : 'Chưa thanh toán';
      case 'pending':
        return $type == 'html' ? '<span class="badge bg-warning">Chờ xử lý</span>' : 'Chờ xử lý';
      case 'processing':
        return $type == 'html' ? '<span class="badge bg-primary">Đang xử lý</span>' : 'Đang xử lý';
      case 'completed':
        return $type == 'html' ? '<span class="badge bg-success">Hoàn thành</span>' : 'Hoàn thành';
      case 'cancelled':
        return $type == 'html' ? '<span class="badge bg-danger">Đã bị hủy</span>' : 'Đã bị hủy';
      case 'active':
        return $type == 'html' ? '<span class="badge bg-success">Đang hoạt động</span>' : 'Đang hoạt động';
      case 'inactive':
        return $type == 'html' ? '<span class="badge bg-danger">Đã khóa</span>' : 'Đã khóa';
      case 'expired':
        return $type == 'html' ? '<span class="badge bg-danger">Đã hết hạn</span>' : 'Đã hết hạn';
      case 'error':
        return $type == 'html' ? '<span class="badge bg-danger">Không hợp lệ</span>' : 'Không hợp lệ';
      case 'refund':
        return $type == 'html' ? '<span class="badge bg-danger">Đã hoàn tiền</span>' : 'Đã hoàn tiền';
      default:
        return $type == 'html' ? '<span class="badge bg-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function formatStatus($status, $type = 'html')
  {
    switch (strtolower($status)) {
      case 'paid':
        return $type == 'html' ? '<span class="badge badge-success">Đã thanh toán</span>' : 'Đã thanh toán';
      case 'unpaid':
        return $type == 'html' ? '<span class="badge badge-danger">Chưa thanh toán</span>' : 'Chưa thanh toán';
      case 'pending':
        return $type == 'html' ? '<span class="badge badge-warning">Chờ xử lý</span>' : 'Chờ xử lý';
      case 'processing':
        return $type == 'html' ? '<span class="badge badge-primary">Đang xử lý</span>' : 'Đang xử lý';
      case 'completed':
        return $type == 'html' ? '<span class="badge badge-success">Hoàn thành</span>' : 'Hoàn thành';
      case 'cancelled':
        return $type == 'html' ? '<span class="badge badge-danger">Đã bị hủy</span>' : 'Đã bị hủy';
      case 'active':
        return $type == 'html' ? '<span class="badge badge-success">Đang hoạt động</span>' : 'Đang hoạt động';
      case 'inactive':
        return $type == 'html' ? '<span class="badge badge-danger">Đã khóa</span>' : 'Đã khóa';
      case 'expired':
        return $type == 'html' ? '<span class="badge badge-danger">Đã hết hạn</span>' : 'Đã hết hạn';
      case 'error':
        return $type == 'html' ? '<span class="badge badge-danger">Không hợp lệ</span>' : 'Không hợp lệ';
      case 'refund':
        return $type == 'html' ? '<span class="badge badge-danger">Đã hoàn tiền</span>' : 'Đã hoàn tiền';
      default:
        return $type == 'html' ? '<span class="badge badge-secondary">' . $status . '</span>' : $status;
    }
  }
  public static function formatPrice($price, $currency = 'đ')
  {
    return number_format($price, 0, ',', '.') . ' ' . $currency;
  }

  public static function formatNumber($number)
  {
    return number_format($number, 0, ',', '.');
  }

  public static function formatTime($time, $format = 'd/m/Y H:i:s')
  {
    return date($format, strtotime($time));
  }

  public static function formatDate($time, $format = 'd/m/Y')
  {
    return date($format, strtotime($time));
  }

  public static function formatTimeAgo($time)
  {
    $time = strtotime($time);
    $diff = time() - $time;

    if ($diff < 60) {
      // if zero
      if ($diff < 0) {
        return 'vừa xong';
      } else {
        return $diff . ' giây trước';
      }
    }
    $diff = round($diff / 60);
    if ($diff < 60) {
      return $diff . ' phút trước';
    }
    $diff = round($diff / 60);
    if ($diff < 24) {
      return $diff . ' giờ trước';
    }
    $diff = round($diff / 24);
    if ($diff < 7) {
      return $diff . ' ngày trước';
    }
    $diff = round($diff / 7);
    if ($diff < 4) {
      return $diff . ' tuần trước';
    }

    return date('d/m/Y H:i:s', $time);
  }

  public static function formatTransType($type)
  {
    switch (strtolower($type)) {
      case 'deposit':
        return 'Nạp tiền';
      default:
        return strtoupper($type);
    }
  }

  public static function vnToStr($str)
  {

    $unicode = array(

      'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

      'd' => 'đ',

      'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

      'i' => 'í|ì|ỉ|ĩ|ị',

      'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

      'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

      'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

      'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

      'D' => 'Đ',

      'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

      'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

      'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

      'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

      'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

    );

    foreach ($unicode as $nonUnicode => $uni) {

      $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    $str = str_replace(' ', '_', $str);

    return $str;
  }

  public static function getCountryName($code, $lng = 'en')
  {
    return \Locale::getDisplayRegion('-' . strtoupper($code), $lng);
  }

  public static function randomString($length = 10, $uppercase = false)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $uppercase ? strtoupper($randomString) : $randomString;
  }

  public static function randomNumber($length = 10)
  {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
  }

  public static function parseOrderId($string, $prefix)
  {
    $re = '/' . $prefix . '\w+/im';
    preg_match_all($re, $string, $matches, PREG_SET_ORDER, 0);
    if (count($matches) == 0) {
      return null;
    }

    // Print the entire match result
    $orderCode = $matches[0][0];
    $prefixLength = strlen($prefix);
    $orderId = intval(substr($orderCode, $prefixLength));

    return $orderId;
  }

  public static function parseOrderName($string, $prefix)
  {
    $re = '/' . $prefix . '\w+/im';
    preg_match_all($re, $string, $matches, PREG_SET_ORDER, 0);
    if (count($matches) == 0) {
      return null;
    }

    // Print the entire match result
    $orderCode = $matches[0][0];
    $prefixLength = strlen($prefix);
    $orderId = substr($orderCode, $prefixLength);

    return $orderId;
  }

  public static function hideUsername($string, $length = 3)
  {
    $string = substr($string, 0, $length) . str_repeat('*', strlen($string) - $length);

    return $string;
  }

  public static function hideEmail($string, $length = 3)
  {
    $email = explode('@', $string);
    $email = substr($email[0], 0, $length) . str_repeat('*', strlen($email[0]) - $length) . '@' . $email[1];

    return $email;
  }


  // function for datetime
  public static function getRemainingHours($end, $format = '%h giờ')
  {
    $end = !strtotime($end) ? date('Y-m-d H:i:s', $end) : $end;

    $startDate = new \DateTime();
    $endDate = new \DateTime($end);

    if ($startDate > $endDate) {
      return sprintf($format, 0, 0, 0);
    }

    $diff = $endDate->diff($startDate);
    $days = $diff->days;
    $hours = $diff->h;
    $minutes = $diff->i;
    $seconds = $diff->s;

    $totalSeconds = $days * 86400 + $hours * 3600 + $minutes * 60 + $seconds;
    $diffDays = floor($totalSeconds / 86400);
    $diffHours = floor(($totalSeconds - $diffDays * 86400) / 3600);
    $diffMinutes = floor(($totalSeconds - $diffDays * 86400 - $diffHours * 3600) / 60);

    return str_replace(['%d', '%h', '%m', '%s'], [$diffDays, $diffHours, $diffMinutes, $seconds], $format);
  }

  public static function getRemainingDays($end, $format = '%dd %hh')
  {
    $end = !strtotime($end) ? date('Y-m-d H:i:s', $end) : $end;

    $startDate = new \DateTime();
    $endDate = new \DateTime($end);

    if ($startDate > $endDate) {
      return sprintf($format, 0, 0, 0);
    }

    $diff = $endDate->diff($startDate);
    $days = $diff->days;
    $hours = $diff->h;
    $minutes = $diff->i;
    $seconds = $diff->s;

    $totalSeconds = $days * 86400 + $hours * 3600 + $minutes * 60 + $seconds;
    $diffDays = floor($totalSeconds / 86400);
    $diffHours = floor(($totalSeconds - $diffDays * 86400) / 3600);
    $diffMinutes = floor(($totalSeconds - $diffDays * 86400 - $diffHours * 3600) / 60);

    return sprintf($format, $diffDays, $diffHours, $diffMinutes);
  }

  public static function getTimeAgo($timestamp)
  {
    $time = strtotime($timestamp) ? strtotime($timestamp) : $timestamp;
    // $time  = time() - $time_ago;

    $time_difference = time() - $time;

    if ($time_difference < 1) {
      return 'vài giây trước';
    }
    $condition = [
      12 * 30 * 24 * 60 * 60 => 'năm',
      30 * 24 * 60 * 60 => 'tháng',
      24 * 60 * 60 => 'ngày',
      60 * 60 => 'giờ',
      60 => 'phút',
      1 => 'giây',
    ];

    foreach ($condition as $secs => $str) {
      $d = $time_difference / $secs;

      if ($d >= 1) {
        $t = round($d);

        return $t . ' ' . $str . ' trước';
      }
    }
  }
  public static function time_His_hosting($time_ago)
{
    $time_ago = date("Y-m-d H:i:s", $time_ago);
    $time_ago = strtotime($time_ago);
    $cur_time = time();
    $time_elapsed = $time_ago - $cur_time;

    if ($time_elapsed <= 0) {
        return "Đã hết thời gian";
    }

    $days = floor($time_elapsed / 86400); // Tính số ngày còn lại

    if ($days > 0) {
        return "Còn $days ngày";
    } else {
        return "Còn 0 ngày";
    }
}

  public static function time_His($time_ago)
  {
    $time_ago = date("Y-m-d H:i:s", $time_ago);
    $time_ago = strtotime($time_ago);
    $cur_time = time();
    $time_elapsed = $time_ago - $cur_time;

    if ($time_elapsed <= 0) {
      return "Đã hết thời gian";
    }

    $days = floor($time_elapsed / 86400);
    $time_elapsed %= 86400;
    $hours = floor($time_elapsed / 3600);
    $time_elapsed %= 3600;
    $minutes = floor($time_elapsed / 60);

    if ($days > 0) {
      return "Còn $days ngày, $hours giờ, và $minutes phút";
    } elseif ($hours > 0) {
      return "Còn $hours giờ và $minutes phút";
    } else {
      return "Còn $minutes phút";
    }
  }
  public static function addLogs($content, $data = '{}')
  {
    $dataJson = is_array($data) || is_object($data) ? json_encode($data) : $data;

    return Logs::create([
      'data' => 0,
      'action' => $content,
      'description' => "Thực hiện hành động " . $content . " với địa chỉ ip " . request()->ip(),
      'old_data' => 0,
      'new_data' => 0,
      'user_id' => auth()->id(),
      'ip' => request()->ip(),
      'data_json' => $dataJson,
    ]);
  }


  // function convert timezone to new timezone
  public static function convertTimezone($time, $from = 'UTC', $timezone = 'Asia/Ho_Chi_Minh')
  {
    $date = new \DateTime($time, new \DateTimeZone($from));
    $date->setTimezone(new \DateTimeZone($timezone));

    return $date->format('Y-m-d H:i:s');
  }
  // function convert number to currency
  public static function formatCurrency($number, $currency = 'VND')
  {
    $currency = strtoupper($currency);
    switch ($currency) {
      case 'VND':
        return number_format($number, 0, '.', ',') . ' ₫';
      case 'USD':
        return '$' . number_format($number, 2, '.', ',');
      default:
        return number_format($number, 0, ',', '.') . ' ₫';
    }
  }

  // function for server
  public static function getDomain()
  {
    return $_SERVER['HTTP_HOST'] ?? '';
  }

  public static function getHostname()
  {
    return $_SERVER['HTTP_HOST'] ?? '';
  }

  public static function getIp()
  {
    $ip = request()->ip();

    if (request()->header('CF-Connecting-IP')) {
      $ip = request()->header('CF-Connecting-IP');
    }

    return $ip;
  }

  public static function getBrowser()
  {
    return request()->header('User-Agent');
  }

  // function for http request
  public static function curlGet($url)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
  }

  public static function curlPost($url, $data = [])
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);

    return $server_output;
  }


  public static function sendMessageTelegramAuto($message)
  {
    $config = self::getApiConfig('telegram');

    if (!isset($config['status']) || !isset($config['chat_id']) || !isset($config['bot_token'])) {
      return false;
    }

    if ($config['status'] == '0') {
      return false;
    }

    return self::sendMessageTelegram($message, $config['chat_id'], $config['bot_token']);
  }

  public static function sendMessageTelegram($message, $chat_id, $token)
  {
    $url = 'https://api.telegram.org/bot' . $token . '/sendMessage';
    $data = [
      'chat_id' => $chat_id,
      'text' => $message,
    ];
    $options = [
      'http' => [
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'method' => 'POST',
        'content' => http_build_query($data),
      ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) {
      return false;
    } else {
      $json = json_decode($result);
      if ($json->ok) {
        return true;
      } else {
        return false;
      }
    }
  }

  public static function getListBank($code = null)
  {
    try {
      if (Cache::has('list_bank')) {
        $data = Cache::get('list_bank');
      } else {
        $response = Http::get('https://api.vieqr.com/list-banks/');

        if ($response->failed()) {
          return [];
        }

        $result = $response->json();

        if (isset($result['code']) && $result['code'] != '00') {
          return [];
        }

        $data = collect($result['data']);

        Cache::put('list_bank', $data, 60 * 5);
      }

      if ($code)
        return $data->where('code', $code)->first();

      return $data;
    } catch (\Throwable $th) {
      return [];
    }
  }

  // function for upload
  public static function uploadFile($file, $provider = 'public', $path = null, $name = null)
  {
    switch ($provider) {
      case 'imgur':
        return self::uploadImgur($file->getContent());
      case 'public':
        return self::uploadPublic($file, $path, $name);
      default:
        return null;
    }
  }

  public static function uploadPublic($file, $path = null, $name = null)
  {
    if ($file->isValid()) {
      // Store the image
      $fileExt = $file->extension();
      $filePath = 'uploads/' . date('d-m-Y');
      $fileName = ($name !== null ? $name : str()->uuid()) . '.' . $fileExt;

      if ($path) {
        $filePath = $filePath . '/' . $path;
      }

      $file->move($filePath, $fileName);

      return '/' . ($filePath . '/' . $fileName);
    }

    return null;
  }

  public static function uploadImgur($file)
  {
    $client_id = '86e171e4f20f914';
    $client_secret = 'cd9540ff7140fe4210350816a44db7b4ab95fd95';

    $result = Http::withHeaders([
      'Authorization' => 'Client-ID ' . $client_id,
    ])
      ->post('https://api.imgur.com/3/image', ['image' => base64_encode($file)])
      ->json();

    if ($result['success'] === true) {

      return $result['data']['link'];
    }

    return null;
  }

  // function send mail
  public static function sendMail($data)
  {
    $to = $data['to'] ?? '';
    $subject = $data['subject'] ?? '';
    $body = $data['body'] ?? $data['content'] ?? '';
    $from = $data['from'] ?? '';
    $fromName = $data['fromName'] ?? '';
    $cc = $data['cc'] ?? null;
    $bcc = $data['bcc'] ?? '';
    $replyTo = $data['replyTo'] ?? '';
    $replyToName = $data['replyToName'] ?? '';
    $attachments = $data['attachments'] ?? [];
    $headers = $data['headers'] ?? [];

    try {
      self::sendMailNow($to, $subject, $body, $from, $fromName, $cc, $bcc, $replyTo, $replyToName, $attachments, $headers);

      return true;
    } catch (\Throwable $th) {
      // throw $th;
      return false;
    }
  }

  private static function sendMailNow($to, $subject, $body, $from = null, $fromName = null, $cc = null, $bcc = null, $replyTo = null, $replyToName = null, $attachments = null, $headers = null)
  {

    $smtp = self::getApiConfig('smtp_server');

    if ($smtp) {
      config([
        'mail.mailers.smtp.host' => $smtp['host'],
        'mail.mailers.smtp.port' => $smtp['port'],
        'mail.mailers.smtp.encryption' => 'tls',
        'mail.mailers.smtp.username' => $smtp['user'],
        'mail.mailers.smtp.password' => $smtp['pass'],
        'mail.from.address' => $smtp['user'],
        'mail.from.name' => $smtp['name'] ?? strtoupper(self::getDomain()),
      ]);
    }

    return Mail::send([], [], function ($message) use ($to, $subject, $body, $from, $fromName, $cc, $bcc, $replyTo, $replyToName, $attachments, $headers) {
      $message->to($to);
      $message->subject($subject);
      $message->html($body);
      // $message->setContent($body);
      // $message->text(strip_tags($body));

      if ($from) {
        $message->from($from, $fromName);
      }
      if ($cc) {
        $message->cc($cc);
      }
      if ($bcc) {
        $message->bcc($bcc);
      }
      if ($replyTo) {
        $message->replyTo($replyTo, $replyToName);
      }
      if ($attachments) {
        foreach ($attachments as $attachment) {
          $message->attach($attachment);
        }
      }
      if ($headers) {
        foreach ($headers as $key => $value) {
          $message->getHeaders()->addTextHeader($key, $value);
        }
      }
    });
  }

  // External Function
  public static function getDomainFromLink($link)
  {
    $url = parse_url($link);
    $domain = $url['host'] ?? '';
    $domain = str_replace('www.', '', $domain);
    return $domain;
  }
}
