@php use App\Helpers\Helper; @endphp
@extends('admin.layouts.master')
@section('title', 'Admin: Dashboard')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
  <style>
    .card-stats h3 {
      color: #9A3B3B;
      font-size: 36px;
    }

    .card-stats h6 {
      color: #9A3B3B;
      font-size: 18px;
    }
  </style>
  <section>
    <div class="mb-3 alert alert-secondary alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
      <h5>PayCode-V1 Version: <strong style="color:blue;">{{ appVersion() }}</strong></h5>
      <small>Hệ thống sẽ tự động cập nhật phiên bản mới khi bạn truy cập trang này</small>
      <br><br>
      <h6>Giấy phép kích hoạt website của bạn là: <strong style="color:red;" id="copyKey">{{ env('PRJ_CLIENT_KEY') }}</strong>
        <button class="btn btn-info btn-sm shadow-sm btn-wave copy waves-effect waves-light" data-clipboard-target="#copyKey" onclick="copy()">Copy</button>
      </h6>
      <small>Vui lòng bảo mật giấy phép của bạn, chỉ cung cấp cho <strong>muabanwebsite</strong> khi cần hỗ trợ.</small>
      <br>
      <hr>
      <p>Thông báo:</p>
      <ul>
        @if (env('PRJ_DEMO_MODE', true) === true)
          <li><strong>Đây là sản phẩm DEMO bạn có thể mua tại muabanwebsite.com</strong></li>
        @else
          <li>Chúng tôi chỉ hỗ trợ khi bạn là người mua mã nguồn chính hãng tại <strong><a href="https://muabanwebsite.io.vn" target="_blank">[muabanwebsite.io.vn]</a></strong></li>
        @endif
      </ul>
      <p class="text-danger">Những thay đổi trong phiên bản này:</p>
      <ul>
        <li class="fw-bold text-blue">404</li>
    </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
    </div>
    <h5>{{ __('Thống Kê Thành Viên') }}</h5>
    <div class="row">
      @foreach ($stats['users'] as $key => $value)
        <div class="col-12 col-md-4 col-lg-2 col-sm-6">
          <div class="card custom-card">
              <div class="card-body">
                  <div class="d-flex flex-wrap align-items-top justify-content-between">
                      <div class="flex-fill">
                          <p class="mb-0 text-muted">{{ $stats['t_users'][$key]['label'] ?? $key }}</p>
                          <div class="d-flex align-items-center"> <span class="fs-5 fw-semibold">
                            @if (isset($stats['t_users'][$key]['format']) && $stats['t_users'][$key]['format'] === 'currency')
                            <h4 class="mb-0 fw-semibold">{{ formatCurrency($value) }}</h4>
                          @else
                            <h4 class="mb-0 fw-semibold">{{ number_format($value) }}</h4>
                          @endif  
                          </span></div>
                      </div>
                      <div> <span class="avatar avatar-md avatar-rounded bg-{{ $stats['t_users'][$key]['color'] ?? 'primary' }}-transparent text-{{ $stats['t_users'][$key]['color'] ?? 'primary' }} fs-18"> <i
                                  class="{{ $stats['t_users'][$key]['icon'] ?? 'bi bi-people-fill' }} fs-16"></i> </span> </div>
                  </div>
              </div>
          </div>
      </div>      
      @endforeach
    </div>
    <h5>{{ __('Thống Kê Mua Mã Nguồn') }}</h5>
    <div class="row">
      @foreach ($stats['product'] as $key => $value)
        <div class="col-12 col-md-4 col-lg-2 col-sm-6">
          <div class="card custom-card">
              <div class="card-body">
                  <div class="d-flex flex-wrap align-items-top justify-content-between">
                      <div class="flex-fill">
                          <p class="mb-0 text-muted">{{ $stats['t_product'][$key]['label'] ?? $key }}</p>
                          <div class="d-flex align-items-center"> <span class="fs-5 fw-semibold">
                            @if (isset($stats['t_product'][$key]['format']) && $stats['t_product'][$key]['format'] === 'currency')
                            <h4 class="mb-0 fw-semibold">{{ formatCurrency($value) }}</h4>
                          @else
                            <h4 class="mb-0 fw-semibold">{{ number_format($value) }}</h4>
                          @endif  
                          </span></div>
                      </div>
                      <div> <span class="avatar avatar-md avatar-rounded bg-{{ $stats['t_product'][$key]['color'] ?? 'primary' }}-transparent text-{{ $stats['t_product'][$key]['color'] ?? 'primary' }} fs-18"> <i
                                  class="{{ $stats['t_product'][$key]['icon'] ?? 'bi bi-people-fill' }} fs-16"></i> </span> </div>
                  </div>
              </div>
          </div>
      </div>
      @endforeach
    </div>
    <h5>{{ __('Thống Kê Mua Tên Miền') }}</h5>
    <div class="row">
      @foreach ($stats['domain'] as $key => $value)
        <div class="col-12 col-md-4 col-lg-2 col-sm-6">
          <div class="card custom-card">
              <div class="card-body">
                  <div class="d-flex flex-wrap align-items-top justify-content-between">
                      <div class="flex-fill">
                          <p class="mb-0 text-muted">{{ $stats['t_domain'][$key]['label'] ?? $key }}</p>
                          <div class="d-flex align-items-center"> <span class="fs-5 fw-semibold">
                            @if (isset($stats['t_domain'][$key]['format']) && $stats['t_domain'][$key]['format'] === 'currency')
                            <h4 class="mb-0 fw-semibold">{{ formatCurrency($value) }}</h4>
                          @else
                            <h4 class="mb-0 fw-semibold">{{ number_format($value) }}</h4>
                          @endif  
                          </span></div>
                      </div>
                      <div> <span class="avatar avatar-md avatar-rounded bg-{{ $stats['t_domain'][$key]['color'] ?? 'primary' }}-transparent text-{{ $stats['t_domain'][$key]['color'] ?? 'primary' }} fs-18"> <i
                                  class="{{ $stats['t_domain'][$key]['icon'] ?? 'bi bi-people-fill' }} fs-16"></i> </span> </div>
                  </div>
              </div>
          </div>
      </div>
      @endforeach
    </div>
    <h5>{{ __('Thống Kê Thuê CRON') }}</h5>
    <div class="row">
      @foreach ($stats['cron'] as $key => $value)
        <div class="col-12 col-md-4 col-lg-2 col-sm-6">
          <div class="card custom-card">
              <div class="card-body">
                  <div class="d-flex flex-wrap align-items-top justify-content-between">
                      <div class="flex-fill">
                          <p class="mb-0 text-muted">{{ $stats['t_cron'][$key]['label'] ?? $key }}</p>
                          <div class="d-flex align-items-center"> <span class="fs-5 fw-semibold">
                            @if (isset($stats['t_cron'][$key]['format']) && $stats['t_cron'][$key]['format'] === 'currency')
                            <h4 class="mb-0 fw-semibold">{{ formatCurrency($value) }}</h4>
                          @else
                            <h4 class="mb-0 fw-semibold">{{ number_format($value) }}</h4>
                          @endif  
                          </span></div>
                      </div>
                      <div> <span class="avatar avatar-md avatar-rounded bg-{{ $stats['t_cron'][$key]['color'] ?? 'primary' }}-transparent text-{{ $stats['t_cron'][$key]['color'] ?? 'primary' }} fs-18"> <i
                                  class="{{ $stats['t_cron'][$key]['icon'] ?? 'bi bi-people-fill' }} fs-16"></i> </span> </div>
                  </div>
              </div>
          </div>
      </div>
      @endforeach
    </div>
    <h5>{{ __('Thống Kê Tài Khoản AI') }}</h5>
    <div class="row">
      @foreach ($stats['ai'] as $key => $value)
        <div class="col-12 col-md-4 col-lg-2 col-sm-6">
          <div class="card custom-card">
              <div class="card-body">
                  <div class="d-flex flex-wrap align-items-top justify-content-between">
                      <div class="flex-fill">
                          <p class="mb-0 text-muted">{{ $stats['t_ai'][$key]['label'] ?? $key }}</p>
                          <div class="d-flex align-items-center"> <span class="fs-5 fw-semibold">
                            @if (isset($stats['t_ai'][$key]['format']) && $stats['t_ai'][$key]['format'] === 'currency')
                            <h4 class="mb-0 fw-semibold">{{ formatCurrency($value) }}</h4>
                          @else
                            <h4 class="mb-0 fw-semibold">{{ number_format($value) }}</h4>
                          @endif  
                          </span></div>
                      </div>
                      <div> <span class="avatar avatar-md avatar-rounded bg-{{ $stats['t_ai'][$key]['color'] ?? 'primary' }}-transparent text-{{ $stats['t_ai'][$key]['color'] ?? 'primary' }} fs-18"> <i
                                  class="{{ $stats['t_ai'][$key]['icon'] ?? 'bi bi-people-fill' }} fs-16"></i> </span> </div>
                  </div>
              </div>
          </div>
      </div>      
      @endforeach
    </div>
    <div class="col-12 col-md-12">
      <div class="card custom-card">
        <div class="card-header">
          <div class="card-title">{{ __('PHÂN TÍCH DÒNG TIỀN') }}</div>
        </div>
        <div class="card-body">
          <div id="column-basic1"></div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')

  <!-- JSVector Maps JS -->
  <script src="/_assets/libs/jsvectormap/js/jsvectormap.min.js"></script>

  <!-- JSVector Maps MapsJS -->
  <script src="/_assets/libs/jsvectormap/maps/world-merc.js"></script>

  <!-- Apex Charts JS -->
  <script src="/_assets/libs/apexcharts/apexcharts.min.js"></script>

  <!-- Chartjs Chart JS -->
  <script src="/_assets/libs/chart.js/chart.min.js"></script>
<script>
  $(document).ready(() => {
    var options = {
      series: [
        {
          name: '{{ __('Tiền nạp') }}',
          data: @json($chartDeposit),
        },
        {
          name: '{{ __('Tiền tiêu') }}',
          data: @json($chartSpent),
        },
      ],
      chart: {
        type: 'bar',
        height: 320,
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '80%',
          endingShape: 'rounded',
        },
      },
      grid: {
        borderColor: '#f2f5f7',
      },
      dataLabels: {
        enabled: false,
      },
      colors: ['#845adf', '#23b7e5'],
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent'],
      },
      xaxis: {
        categories: @json($chartCategories),
        labels: {
          show: true,
          style: {
            colors: '#8c9097',
            fontSize: '11px',
            fontWeight: 600,
            cssClass: 'apexcharts-xaxis-label',
          },
        },
      },
      yaxis: {
        title: {
          text: '{{ __('VNĐ') }}',
          style: {
            color: '#8c9097',
          },
        },
        labels: {
          show: true,
          style: {
            colors: '#8c9097',
            fontSize: '11px',
            fontWeight: 600,
            cssClass: 'apexcharts-xaxis-label',
          },
          formatter: function (val) {
            return val.toLocaleString();
          },
        },
      },
      fill: {
        opacity: 1,
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val.toLocaleString() + ' VNĐ';
          },
        },
      },
    };
    var chart2 = new ApexCharts(document.querySelector('#column-basic1'), options);
    chart2.render();
  });
</script>


@endsection
