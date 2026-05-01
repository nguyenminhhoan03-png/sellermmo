<?php
/**
 * @author muabanwebsite.io.vn
 * @package HelperFunctions
 *
 * @version 1.0.0
 */

use App\Helpers\Helper;
use App\Models\Config;
use App\Models\CurrencyList;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

if (!function_exists('gettime')) {
  function gettime()
  {
    $timestamp = time();
    $formattedTime = Carbon::createFromTimestamp($timestamp, config('app.timezone'))->format('Y-m-d H:i:s');
    return $formattedTime;
  }
}
if (!function_exists('FormatDungLuong')) {
   function FormatDungLuong($value)
    {
        if ($value >= 1024 * 1024) {
            $value = $value / (1024 * 1024);
            return number_format($value, 2) . ' TB';
        } elseif ($value >= 1024) {
            $value = $value / 1024;
            return number_format($value, 2) . ' GB';
        } else {
            return number_format($value, 2) . ' MB';
        }
    }
}
if (!function_exists('FormatDuLieu')) {
  function FormatDuLieu($value)
    {
        if (strtolower($value) === 'unlimited') {
            return 'Không giới hạn';
        }      
        if (is_numeric($value)) {
            return number_format($value);
        }

        return 'Giá trị không hợp lệ';
    }
}
if (!function_exists('FormatBandwidth')) {
  function FormatBandwidth($value)
    {
        if (strtolower($value) === 'unlimited') {
            return 'Không giới hạn';
        }
        if ($value == 1048576) {
          return 'Không giới hạn';
        }

        if (is_numeric($value)) {
            return number_format($value) . ' Mbps';
        }

        return 'Giá trị không hợp lệ';
    }
}
if (!function_exists('uploadImageToImgur')) {
    function uploadImageToImgur($file, $client_id, $path = null, $name = null)
    {
        $allowedExtensions = ['gif', 'png', 'jpg', 'jpeg'];
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions)) {
            return '1';
        }

        if ($file->isValid()) {
            $fileExt = $file->extension();
            $filePath = 'uploads/' . date('d-m-Y');
            $fileName = ($name !== null ? $name : str()->uuid()) . '.' . $fileExt;

            if ($path) {
                $filePath = $filePath . '/' . $path;
            }

            if (!file_exists(public_path($filePath))) {
                mkdir(public_path($filePath), 0777, true);
            }

            $file->move(public_path($filePath), $fileName);

            return '/' . $filePath . '/' . $fileName;
        }

        return 0;
    }
}
if (!function_exists('cur_setting')) {
  function cur_setting($key = null, $default = null)
  {
    if (Cache::has('cur_setting')) {
      $config = Cache::get('cur_setting');
    } else {
      $config = Helper::getConfig('currency_settings');
      if ($config === null) {
        $config = [
          'currency_code'               => 'VND',
          'currency_symbol'             => '₫',
          'currency_decimal'            => 2,
          'currency_thousand_separator' => 'comma',
          'currency_decimal_separator'  => 'dot',
          'currency_position'           => 'left',
          'new_currecry_rate'           => 1,
        ];
      } else {
        $config = is_array($config) ? $config : $config->toArray();
      }

      Cache::put('cur_setting', $config, 30);
    }

    if ($key !== null) {
      return $config[$key] ?? $default;
    }

    if (!request()->routeIs('admin*')) {
      unset($config['default_price_percentage_increase']);
    }

    return $config;
  }

  function cur_user_setting($key = null, $default = null)
  {
    if (Cache::has('cur_user_setting')) {
      $config = Cache::get('cur_user_setting');
    } else {
      $defaultConfig = [
        'currency_code'               => 'VND',
        'currency_symbol'             => '₫',
        'currency_thousand_separator' => 'comma',
        'currency_decimal_separator'  => 'dot',
        'currency_decimal'            => 2,
        'currency_position'           => 'left',
        'new_currecry_rate'           => 1,
      ];

      if (CurrencyList::count() == 0) {
        CurrencyList::create($defaultConfig);

        $config = $defaultConfig;
      } else if (auth()->check() && auth()->user()->currency_code !== cur_setting('currency_code')) {
        $config = CurrencyList::where('currency_code', auth()->user()->currency_code)->select([
          'currency_code',
          'currency_symbol',
          'currency_decimal',
          'new_currecry_rate',
          'currency_thousand_separator',
          'currency_decimal_separator',
        ])->first();

        if ($config === null) {
          $config = cur_setting();
        } else {
          $config = $config->toArray();
        }
      } else {
        $config = cur_setting();
      }

      Cache::put('cur_user_setting', $config, 30);
    }

    if (!request()->routeIs('admin*')) {
      unset($config['default_price_percentage_increase']);
    }

    if ($key !== null) {
      return $config[$key] ?? $default;
    }

    return $config;
  }
}
if (!function_exists('setting')) {
  function setting($key, $default = null)
  {
    if (Cache::has('general_settings_' . domain())) {
      $config = Cache::get('general_settings_' . domain());
    } else {
      $config = class_exists(\App\Helpers\Helper::class)
        ? \App\Helpers\Helper::getConfig('general', [])
        : [];
      Cache::put('general_settings_' . domain(), $config, 30);
    }

    return $config[$key] ?? $default;
  }
}
if (!function_exists('setting_asset')) {
  /**
   * Public URL for logo/favicon paths from settings.
   * - Full http(s) URLs → pass through (except blocked imgur hotlinks).
   * - Local paths like /uploads/... → returned as root-relative (/uploads/...) so they
   *   always resolve against the current domain, regardless of APP_URL or port.
   * - Empty or broken legacy paths → fall back to a default SVG.
   */
  function setting_asset(string $key, string $defaultPublicPath = 'assets/media/logos/default-small.svg'): string
  {
    $currentScheme = request()->isSecure() ? 'https:' : 'http:';
    $rootRelative = static function (string $path): string {
      // Ensure leading slash for root-relative URL
      return '/' . ltrim($path, '/');
    };

    $path = setting($key);
    if ($path === null || $path === '') {
      return $rootRelative($defaultPublicPath);
    }
    $path = trim((string) $path);

    // Legacy broken paths → default
    if (str_contains($path, 'assets/images/brand-logos/desktop-white') || str_contains($path, 'brand-logos/desktop-white.png')) {
      return $rootRelative($defaultPublicPath);
    }

    if (preg_match('#^https?://#i', $path)) {
      // Avoid mixed content on HTTPS pages for legacy http:// assets.
      if (request()->isSecure() && str_starts_with(strtolower($path), 'http://')) {
        $path = preg_replace('#^http://#i', 'https://', $path);
      }

      // imgur hotlink blocked → use default
      if (in_array($key, ['logo_light', 'favicon', 'logo_dark'], true) && preg_match('#imgur\.com|i\.imgur\.com#i', $path)) {
        return $rootRelative($defaultPublicPath);
      }

      return $path;
    }

    // Scheme-relative URL: //cdn.example.com/img.png
    if (str_starts_with($path, '//')) {
      return $currentScheme . $path;
    }

    // Local path → root-relative (works on any domain/port)
    return $rootRelative($path);
  }
}
if (!function_exists('img_url')) {
  /**
   * Resolve an image path to a usable URL for <img src="...">.
   *
   * Cases:
   *   null / ''        → $default (root-relative or full URL)
   *   https?://...     → returned as-is
   *   /uploads/...     → returned as root-relative (/uploads/...)
   *   uploads/...      → prefixed with / → /uploads/...
   */
  function img_url(?string $path, string $default = '/assets/media/logos/default-small.svg'): string
  {
    if ($path === null || trim($path) === '') {
      return $default;
    }

    $path = trim(str_replace('\\', '/', $path));

    // Full external URL → pass through
    if (preg_match('#^https?://#i', $path)) {
      // Upgrade legacy http images on https page to avoid mixed content.
      if (request()->isSecure() && str_starts_with(strtolower($path), 'http://')) {
        return preg_replace('#^http://#i', 'https://', $path);
      }

      return $path;
    }

    // Scheme-relative URL: //cdn.example.com/image.jpg
    if (str_starts_with($path, '//')) {
      return (request()->isSecure() ? 'https:' : 'http:') . $path;
    }

    // Local path → ensure leading slash so it is root-relative
    return '/' . ltrim($path, '/');
  }
}
if (!function_exists('contact_info')) {
  function contact_info($key, $default = null)
  {
    if (Cache::has('general_contact_info_' . domain())) {
      $config = Cache::get('general_contact_info_' . domain());
    } else {
      $config = class_exists(\App\Helpers\Helper::class)
        ? \App\Helpers\Helper::getConfig('contact_info', [])
        : [];
      Cache::put('general_contact_info_' . domain(), $config, 30);
    }

    return $config[$key] ?? $default;
  }
}
if (!function_exists('theme_settings')) {
  function theme_settings($key, $default = null)
  {
    if (Cache::has('general_theme_settings_' . domain())) {
      $config = Cache::get('general_theme_settings_' . domain());
    } else {
      $config = class_exists(\App\Helpers\Helper::class)
        ? \App\Helpers\Helper::getConfig('theme_settings', [])
        : [];
      Cache::put('general_theme_settings_' . domain(), $config, 30);
    }

    return $config[$key] ?? $default;
  }
}
if (!function_exists('formatCurrency')) {
  function formatCurrency($number, $show_currency_symbol = true, $number_decimal = "", $decimalpoint = "", $separator = "")
  {
    if (!request()->routeIs('admin*') && cur_user_setting('currency_code') !== 'VND') {
      return formatCurrencyF($number, null, $show_currency_symbol, $number_decimal, $decimalpoint, $separator);
    }

    $config = cur_setting();

    $decimal = 2;

    $prefix = '';

    if ($number_decimal == "") {
      $decimal = $config['currency_decimal'] ?? 2;
    }

    if ($decimalpoint == "") {
      $decimalpoint = $config['currency_decimal_separator'] ?? 'comma';
    }

    if ($separator == "") {
      $separator = $config['currency_thousand_separator'] ?? 'space';
    }

    switch ($decimalpoint) {
      case 'dot':
        $decimalpoint = '.';
        break;
      case 'comma':
        $decimalpoint = ',';
        break;
      default:
        $decimalpoint = ".";
        break;
    }

    switch ($separator) {
      case 'dot':
        $separator = '.';
        break;
      case 'comma':
        $separator = ',';
        break;
      case 'space':
        $separator = ' ';
        break;
      default:
        $separator = ',';
        break;
    }

    $number = number_format($number, $decimal, $decimalpoint, $separator);

    if ($show_currency_symbol) {
      $symbol            = $config['currency_symbol'] ?? '';
      $currency_position = $config['currency_position'] ?? 'left';

      if ($currency_position === 'left') {
        return $prefix . $symbol . '' . $number;
      } else {
        return $prefix . $number . ' ' . $symbol;
      }

      // $locale   = 'en-US'; //browser or user locale
      // $currency = $config['currency_code'] ?? 'VND';
      // $fmt      = new NumberFormatter($locale . "@currency=$currency", NumberFormatter::CURRENCY);
      // $symbol   = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

      // if ($currency_position === 'left') {
      //   return $symbol . $number;
      // } else {
      //   return $number . $symbol;
      // }

    }

    return $number;
  }

  function formatCurrencyF($number, $config = null, $show_currency_symbol = true, $number_decimal = "", $decimalpoint = "", $separator = "")
  {
    if ($config === null) {
      $config = cur_user_setting();
      // return formatCurrencyF($number, cur_user_setting(), $show_currency_symbol, $number_decimal, $decimalpoint, $separator);
    }

    $prefix  = '≈ ';
    $decimal = 2;

    if ($config['currency_code'] !== 'VND') {
      $number = $number / $config['new_currecry_rate'];
    } else {
      $number = $number / 1;
      $prefix = '';
    }

    if ($number_decimal == "") {
      $decimal = $config['currency_decimal'] ?? 2;
    }

    if ($decimalpoint == "") {
      $decimalpoint = $config['currency_decimal_separator'] ?? 'comma';
    }

    if ($separator == "") {
      $separator = $config['currency_thousand_separator'] ?? 'space';
    }

    switch ($decimalpoint) {
      case 'dot':
        $decimalpoint = '.';
        break;
      case 'comma':
        $decimalpoint = ',';
        break;
      default:
        $decimalpoint = ".";
        break;
    }

    switch ($separator) {
      case 'dot':
        $separator = '.';
        break;
      case 'comma':
        $separator = ',';
        break;
      case 'space':
        $separator = ' ';
        break;
      default:
        $separator = ',';
        break;
    }

    $number = number_format($number, $decimal, $decimalpoint, $separator);

    if ($show_currency_symbol) {
      $symbol            = $config['currency_symbol'] ?? '';
      $currency_position = $config['currency_position'] ?? 'left';

      if ($currency_position === 'left') {
        return $prefix . $symbol . '' . $number;
      } else {
        return $prefix . $number . ' ' . $symbol;
      }

      // $locale   = 'en-US'; //browser or user locale
      // $currency = $config['currency_code'] ?? 'VND';
      // $fmt      = new NumberFormatter($locale . "@currency=$currency", NumberFormatter::CURRENCY);
      // $symbol   = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

      // return $prefix . $number . $symbol;
    }

    return $prefix . $number;
  }
}
if (!function_exists('prj_key')) {
  function prj_key()
  {

    if (Cache::has('prj_key')) {
      $key = Cache::get('prj_key');
    } else {
      $project = Config::firstOrCreate(['name' => 'prj_key'], ['value' => str()->random(12)]);

      Cache::put('prj_key', $project->value, 30);

      $key = $project->value;
    }

    return $key;
  }
}
if (!function_exists('deposit_status')) {
  function deposit_status($key = null)
  {
    if (Cache::has('deposit_status')) {
      $config = Cache::get('deposit_status');
    } else {
      $config = class_exists(\App\Helpers\Helper::class)
        ? \App\Helpers\Helper::getConfig('deposit_status')
        : [];
      Cache::put('deposit_status', $config, 5);
    }

    if ($key !== null) {
      return !!($config[$key] ?? true);
    }

    return $config;
  }
}
if (!function_exists('checkprice')) {
  function checkprice($price)
  {
      if ($price == 0) {
          return "Miễn Phí";
      } 
          return "Mất Phí";
      }
  }
if (!function_exists('getuser')) {
  function getuser($user)
  {
      if ($user == 1) {
          return "Admin";
      } elseif ($user == 2) {
          return "Đại lý";
      } else {
          return "Thành viên";
      }
  }
}

if (!function_exists('get_change_logs')) {
  function get_change_logs()
  {
    $filePath = resource_path('logs/change-logs.txt');

    // Check if file exists
    if (!file_exists($filePath)) {
      return [];
    }

    // Open the file for reading; convert newlines to array
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $logs  = [];
    foreach ($lines as $line) {
      $logs[] = json_decode($line, true);
    }

    return $lines;
  }

}

if (!function_exists('appVersion')) {
  function appVersion()
  {

    if (Cache::has('app_version')) {
      $version = Cache::get('app_version');
    } else {
      $version = class_exists(\App\Helpers\Helper::class)
        ? \App\Helpers\Helper::getConfig('version_code', 1000)
        : 1000;
      Cache::put('app_version', $version, 30);
    }

    return $version;
  }
}

if (!function_exists('parseItem')) {
  function parseItem($content)
  {
    $item = explode('|', $content);

    return [
      'username'   => $item[0] ?? '',
      'password'   => $item[1] ?? '',
      'extra_data' => $item[2] ?? '',
    ];
  }
}

if (!function_exists('parseProxy')) {
  function parseProxy($string)
  {
    //IP:port_http:port_socks5:user:pass
    $proxy = explode(':', $string);

    return [
      'host'       => $proxy[0] ?? -1,
      'user'       => $proxy[3] ?? -1,
      'pass'       => $proxy[4] ?? -1,
      'port_http'  => $proxy[1] ?? -1,
      'port_socks' => $proxy[2] ?? -1,
    ];
  }
}

if (!function_exists('getISPLocation')) {
  function getISPLocation($ip)
  {
    try {
      $url  = 'http://ip-api.com/json/' . $ip;
      $data = file_get_contents($url);
      $data = json_decode($data, true);

      return $data['countryCode'] ?? 'vn';
    } catch (Exception $e) {
      return 'vn';
    }
  }
}

if (!function_exists('getCountry')) {
  function getCountry($ip)
  {
    if (session()->has('country')) {
      return session()->get('country');
    }

    $data = getISPLocation($ip);

    $country = strtolower($data) !== 'vn' ? 'us' : 'vn';

    if (!session()->has('country')) {
      session()->put('country', $country);
    }

    return $country;
  }
}
if (!function_exists('domain')) {
  function domain($domain = null)
  {
    if ($domain) {
      return $domain;
    }

    if (class_exists(\App\Helpers\Helper::class)) {
      return \App\Helpers\Helper::getDomain();
    }

    return $_SERVER['HTTP_HOST'] ?? '';
  }
}

/** Currency Helper */
if (!function_exists("currency_codes")) {
  function currency_codes($code = null)
  {
    $data = array(
      "VND" => "Việt Nam Đồng",
      "AUD" => "Australian dollar",
      "BRL" => "Brazilian dollar",
      "CAD" => "Canadian dollar",
      "CZK" => "Czech koruna",
      "DKK" => "Danish krone",
      "EUR" => "Euro",
      "HKD" => "Hong Kong dollar",
      "HUF" => "Hungarian forint",
      "INR" => "Indian rupee",
      "ILS" => "Israeli",
      "JPY" => "Japanese yen",
      "MYR" => "Malaysian ringgit",
      "MXN" => "Mexican peso",
      "TWD" => "New Taiwan dollar",
      "NZD" => "New Zealand dollar",
      "NOK" => "Norwegian krone",
      "PHP" => "Philippine peso",
      "PLN" => "Polish złoty",
      "GBP" => "Pound sterling",
      "RUB" => "Russian ruble",
      "SGD" => "Singapore dollar",
      "SEK" => "Swedish krona",
      "CHF" => "Swiss franc",
      "THB" => "Thai baht",
      "USD" => "United States dollar",
    );

    if ($code !== null) {
      return $data[$code] ?? null;
    }

    return $data;
  }
}
if (!function_exists("get_client_ip")) {
  function get_client_ip()
  {
    if (getenv('HTTP_CLIENT_IP')) {
      $ip = getenv('HTTP_CLIENT_IP');
    } else if (getenv('HTTP_X_FORWARDED_FOR')) {
      $ip = getenv('HTTP_X_FORWARDED_FOR');

      if (strstr($ip, ',')) {
        $tmp = explode(',', $ip);
        $ip  = trim($tmp[0]);
      }
    } else {
      $ip = getenv('REMOTE_ADDR');
    }

    return $ip;
  }
}
if (!function_exists("get_curl")) {
  function get_curl($url)
  {
    $user_agent = 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3';

    $headers = array
    (
      'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
      'Accept-Language: en-US,fr;q=0.8;q=0.6,en;q=0.4,ar;q=0.2',
      'Accept-Encoding: gzip,deflate',
      'Accept-Charset: utf-8;q=0.7,*;q=0.7',
      'cookie:datr=; locale=en_US; sb=; pl=n; lu=gA; c_user=; xs=; act=; presence=',
    );

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
  }
}
if (!function_exists('getRealIP')) {
  function getRealIP()
  {
    $ip = $_SERVER["REMOTE_ADDR"];
    //Deep detect ip
    if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
      $ip = $_SERVER['HTTP_FORWARDED'];
    }
    if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
      $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
      $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
      $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    if ($ip == '::1') {
      $ip = '127.0.0.1';
    }

    return $ip;
  }
}