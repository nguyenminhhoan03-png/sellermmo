@php
    use App\Helpers\Helper;
    use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'Ngân hàng')
@section('css')
    <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

    <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="text-right">
            <a class="btn btn-primary label-btn mb-3" href="{{ route('admin.recharge.bank.config') }}">
                <i class="ri-settings-4-line label-btn-icon me-2"></i> CẤU HÌNH
            </a>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="row">
            @foreach ($stats['bank'] as $key => $value)
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-fill">
                                @if (isset($stats['t_bank'][$key]['format']) && $stats['t_bank'][$key]['format'] === 'currency')
                                <p class="mb-1 fs-5 fw-semibold text-default">
                                    {{ formatCurrency($value) }}</p>
                              @else
                              <p class="mb-1 fs-5 fw-semibold text-default">
                                {{ number_format($value) }}</p>
                              @endif  
                                <p class="mb-0 text-muted">{{ $stats['t_bank'][$key]['label'] ?? $key }}</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar text-bg-{{ $stats['t_bank'][$key]['color'] ?? 'primary' }} rounded-circle fs-20"><i class="bx bxs-wallet-alt"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
           
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">THỐNG KÊ NẠP TIỀN THÁNG {{ date('m') }}</div>
            </div>
            <div class="card-body">
                <canvas id="chartjs-line" class="chartjs-chart" width="354" height="177" style="display: block; box-sizing: border-box; height: 177px; width: 354px;"></canvas>
                <script>
                (function() {
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            Chart.defaults.borderColor = "rgba(142, 156, 173,0.1)";
                            Chart.defaults.color = "#8c9097";
                    
                                    const labels = @json($chartCategories);
                                    const bankauto = @json($chartDeposit);

                                    const data = {
                            labels: labels,
                            datasets: [{
                                label: 'Nạp tiền tự động',
                                backgroundColor: 'rgb(132, 90, 223)',
                                borderColor: 'rgb(132, 90, 223)',
                                data: bankauto,
                            }]
                        };
                                    const config = {
                                        type: 'bar',
                                        data: data,
                                        options: {}
                                    };

                                    const myChart = new Chart(
                                        document.getElementById(
                                            'chartjs-line'),
                                        config
                                    );
                                
                           
                        }, 5);
                    });
                })();
                </script>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    LỊCH SỬ NẠP TIỀN TỰ ĐỘNG
                </div>
            </div>
            <div class="card-body">
                
                <div class="table-responsive theme-scrollbar mb-3">
                    <table class="display table table-bordered table-stripped text-nowrap datatable" id="basic-1">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Thời gian</th>
                                <th class="text-right">Số tiền nạp</th>
                                <th class="text-right">Thực nhận</th>
                                <th class="text-center">Ngân hàng</th>
                                <th class="text-center">Mã giao dịch</th>
                                <th>Nội dung chuyển khoản</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($rechargebank as $bank)
                          @php
                            $getuser = User::find($bank->user_id);
   
                          @endphp
                            <tr>
                            <td><a class="text-primary" href="/Cpanel/users/{{ $getuser->id }}">{{ $getuser->username }} [ID {{ $getuser->id }}]</a>
                                <td class="text-center"><span class="badge bg-light text-dark"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ Helper::formatTimeAgo( $bank->created_at) }}">{{ $bank->created_at }}</span></td>
                                <td class="text-right">{{ formatCurrency($bank->amount) }}đ</td>
                                <td class="text-right">{{ formatCurrency($bank->real_amount) }}đ</td>
                                <td class="text-center">{{ $bank->extras['bank'] }}</td>
                                <td class="text-center">{{ $bank->extras['transactionID'] }}</td>
                                <td class="text-center"><small>{{ $bank->extras['description'] }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="float-right">
                                        Đã thanh toán: <strong style="color:red;">{{ formatCurrency($rechargebank->sum('amount')) }}</strong>
                                        |

                                        Thực nhận: <strong style="color:blue;">{{ formatCurrency($rechargebank->sum('real_amount')) }}</strong></div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 <!-- JSVector Maps JS -->
 <script src="/_assets/libs/jsvectormap/js/jsvectormap.min.js"></script>

 <!-- JSVector Maps MapsJS -->
 <script src="/_assets/libs/jsvectormap/maps/world-merc.js"></script>

 <!-- Apex Charts JS -->
 <script src="/_assets/libs/apexcharts/apexcharts.min.js"></script>

 <!-- Chartjs Chart JS -->
 <script src="/_assets/libs/chart.js/chart.min.js"></script>
@section('scripts')
    <script>
        const deleteRow = async (id) => {
            const confirmDelete = await Swal.fire({
                title: '{{ __('Bạn chắc chứ?') }}',
                text: "{{ __('Bạn sẽ không thể khôi phục lại dữ liệu này!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('Xóa') }}',
                cancelButtonText: '{{ __('Hủy') }}'
            });

            if (!confirmDelete.isConfirmed) return;

            $showLoading();

            try {
                const {
                    data: result
                } = await axios.post('{{ route('admin.transfer.delete') }}', {
                    id
                })

                Swal.fire('Thành công', result.message, 'success').then(() => {
                    window.location.reload();
                })
            } catch (error) {
                Swal.fire('Thất bại', $catchMessage(error), 'error')
            }
        }
        $(document).ready(function() {
            window.pageOverlay = $("#page-overlay");

            // basic datatable
            $('#datatable').DataTable({
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                response: false,
                order: [
                    [0, 'desc']
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, 5000, -1],
                    [10, 25, 50, 100, 500, 1000, 5000, 'All']
                ]
            });

        })
    </script>
@endsection
