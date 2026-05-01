<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hisproduct;
use App\Models\DomainOrder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Logs;
use App\Models\CronOrder;
use Helper;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(Request $request)
  {

    $stats = [];

    // Users stats
    $stats['users'] = [
      'total'               => User::count(),
      'today'               => User::whereDate('created_at', date('Y-m-d'))->count(),
      'balance'             => User::sum('balance'),
      'total_deposit'       => User::sum('total_deposit'),
      'total_deposit_today' => Transaction::where('type', 'deposit')->whereDate('created_at', date('Y-m-d'))->sum('amount'),
      'total_deposit_month' => Transaction::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('amount'),
    ];

    // Users translate
    $stats['t_users'] = [
      'total'               => [
        'label' => ('Tổng thành viên'),
        'color' => 'danger',
        'icon' => 'bi bi-people-fill',
      ],
      'today'               => [
        'label' => ('Đăng ký hôm nay'),
        'color' => 'primary',
        'icon' => 'bi bi-people-fill',
      ],
      'balance'             => [
        'label'  => ('Tổng số dư'),
        'color'  => 'success',
        'format' => 'currency',
        'icon' => 'bi bi-wallet-fill',
      ],
      'total_deposit'       => [
        'label'  => ('Tổng tiền nạp'),
        'color'  => 'warning',
        'format' => 'currency',
        'icon' => 'bi bi-wallet-fill',
      ],
      'total_deposit_today' => [
        'label'  => ('Nạp Hôm Nay'),
        'color'  => 'info',
        'format' => 'currency',
        'icon' => 'bi bi-coin',
      ],
      'total_deposit_month' => [
        'label'  => __('Nạp Tháng :month', ['month' => date('m/Y')]),
        'color'  => 'info',
        'format' => 'currency',
        'icon' => 'bi bi-coin',
      ],
    ];
      $stats['product']   = [
        'total_pay_product'         => Hisproduct::count(),
        'total_pay_full'            => Hisproduct::sum('price'),
        'total_pay_payment' => Hisproduct::whereDate('created_at', date('Y-m-d'))->sum('price'),
        'total_orders_month' => Hisproduct::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count(),
        'total_orders_week'    => Hisproduct::whereBetween('created_at', [date('Y-m-d', strtotime('last monday')), date('Y-m-d', strtotime('next sunday'))])->count(),
        'total_orders_today'   => Hisproduct::whereDate('created_at', date('Y-m-d'))->count(),
      ];
      $stats['t_product'] = [
        'total_pay_product'         => [
          'label' => __('Tổng Đơn Code'),
          'color' => 'danger',
          'icon' => 'bi bi-basket-fill',
        ],
        'total_orders_week'    => [
          'label' => __('Đơn Hàng Tuần Này'),
          'color' => 'primary',
        'icon' => 'bi bi-calendar',
        ],
        'total_orders_today'   => [
          'label' => __('Đơn Hàng Hôm Nay'),
          'color' => 'info',
        'icon' => 'bi bi-calendar',
        ],
        'total_orders_month'   => [
          'label' => __('Đơn hàng tháng :month', ['month' => date('m/Y')]),
          'color' => 'info',
        'icon' => 'bi bi-calendar',
        ],
        'total_pay_payment' => [
          'label'  => __('Tổng tiền :day', ['day' => date('d/m/Y')]),
          'color'  => 'success',
          'format' => 'currency',
          'icon' => 'bi bi-basket-fill',
        ],
        'total_pay_full' => [
          'label'  => __('Tổng thanh toán'),
          'color'  => 'success',
          'format' => 'currency',
          'icon' => 'bi bi-basket-fill',
        ],
      ];

      $stats['domain']   = [
        'total_pay_domain'         => DomainOrder::count(),
        'total_pay_full'            => DomainOrder::sum('price'),
        'total_pay_payment' => DomainOrder::whereDate('created_at', date('Y-m-d'))->sum('price'),
        'total_domain_month' => DomainOrder::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count(),
        'total_domain_week'    => DomainOrder::whereBetween('created_at', [date('Y-m-d', strtotime('last monday')), date('Y-m-d', strtotime('next sunday'))])->count(),
        'total_domain_today'   => DomainOrder::whereDate('created_at', date('Y-m-d'))->count(),
      ];
      $stats['t_domain'] = [
        'total_pay_domain'         => [
          'label' => __('Tổng Đơn Domain'),
          'color' => 'danger',
          'icon' => 'bi bi-basket-fill',
        ],
        'total_domain_week'    => [
          'label' => __('Đơn Hàng Tuần Này'),
          'color' => 'primary',
        'icon' => 'bi bi-calendar',
        ],
        'total_domain_today'   => [
          'label' => __('Đơn Hàng Hôm Nay'),
          'color' => 'info',
        'icon' => 'bi bi-calendar',
        ],
        'total_domain_month'   => [
          'label' => __('Đơn hàng tháng :month', ['month' => date('m/Y')]),
          'color' => 'info',
        'icon' => 'bi bi-calendar',
        ],
        'total_pay_payment' => [
          'label'  => __('Tổng tiền :day', ['day' => date('d/m/Y')]),
          'color'  => 'success',
          'format' => 'currency',
          'icon' => 'bi bi-basket-fill',
        ],
        'total_pay_full' => [
          'label'  => __('Tổng thanh toán'),
          'color'  => 'success',
          'format' => 'currency',
          'icon' => 'bi bi-basket-fill',
        ],
      ];
      $stats['cron']   = [
        'total_pay_cron'         => CronOrder::count(),
        'total_pay_full'            => CronOrder::sum('price'),
        'total_pay_payment' => CronOrder::whereDate('created_at', date('Y-m-d'))->sum('price'),
        'total_cron_month' => CronOrder::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('price'),
        'total_cron_week'    => CronOrder::whereBetween('created_at', [date('Y-m-d', strtotime('last monday')), date('Y-m-d', strtotime('next sunday'))])->sum('price'),
        'total_cron_today'   => CronOrder::whereDate('created_at', date('Y-m-d'))->count(),
      ];
      $stats['t_cron'] = [
        'total_pay_cron'         => [
          'label' => __('Tổng Link cron'),
          'color' => 'danger',
          'icon' => 'bi bi-basket-fill',
        ],
        'total_cron_week'    => [
          'label' => __('Tổng tiền Tuần Này'),
          'color' => 'primary',
          'format' => 'currency',
        'icon' => 'bi bi-calendar',
        ],
        'total_cron_today'   => [
          'label' => __('Số link Hôm Nay'),
          'color' => 'info',
        'icon' => 'bi bi-calendar',
        ],
        'total_cron_month'   => [
          'label' => __('Tổng tiền tháng :month', ['month' => date('m/Y')]),
          'format' => 'currency',
          'color' => 'info',
        'icon' => 'bi bi-calendar',
        ],
        'total_pay_payment' => [
          'label'  => __('Tổng tiền :day', ['day' => date('d/m/Y')]),
          'color'  => 'success',
          'format' => 'currency',
          'icon' => 'bi bi-basket-fill',
        ],
        'total_pay_full' => [
          'label'  => __('Tổng thanh toán'),
          'color'  => 'success',
          'format' => 'currency',
          'icon' => 'bi bi-basket-fill',
        ],
      ];
    //
    $chartCategories = [];
    for ($i = 1; $i <= date('d'); $i++) {
      $chartCategories[] = date('Y-m-d', strtotime(date('Y-m') . '-' . $i));
    }
    $chartSpent   = [];
    $chartDeposit = [];

    foreach ($chartCategories as $chartCategory) {
      $chartSpent[]   = Transaction::where('type', '!=', 'deposit')->whereDate('created_at', $chartCategory)->sum('amount');
      $chartDeposit[] = Transaction::where('type', 'deposit')->whereDate('created_at', $chartCategory)->sum('amount');
    }

    return view('admin.dashboard', compact('stats',  'chartCategories', 'chartSpent', 'chartDeposit'));
  }
  public function logs()
  {
    $logs = Logs::get();
    return view('admin.dashboard.logs', compact('logs'));
  }

  public function transactions()
  {
    $transactions = Transaction::where('type', '!=', 'deposit')->get();
    return view('admin.dashboard.transactions', compact('transactions'));
  }
}
