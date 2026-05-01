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
                <button type="button" id="open-card-config" class="btn btn-primary label-btn mb-3">
                    <i class="ri-settings-4-line label-btn-icon me-2"></i> CẤU HÌNH
                </button>
            </div>
        </div>
        <div class="col-xl-12" id="card-config" style="display: none;">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <h4 class="card-title">Charging Card</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.recharge.card.update', ['type' => 'charging_card']) }}" class="axios-form" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label for="api_url" class="form-label">API Url</label>
                                <input type="text" class="form-control" id="api_url" name="api_url"
                                    value="{{ $charging_card['api_url'] ?? 'https://doithecao5s.vn' }}"
                                    placeholder="https://doithecao5s.vn">
                            </div>
                            <div class="col-md-4">
                                <label for="partner_id" class="form-label">Partner ID</label>
                                <input type="text" class="form-control" id="partner_id" name="partner_id"
                                    value="{{ $charging_card['partner_id'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="partner_key" class="form-label">Partner Key</label>
                                <input type="text" class="form-control" id="partner_key" name="partner_key"
                                    value="{{ $charging_card['partner_key'] ?? '' }}">
                            </div>

                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-3">
                                <label for="fees_viettel" class="form-label">Phí Thẻ Viettel</label>
                                <input type="text" class="form-control" id="fees_viettel" name="fees[VIETTEL]"
                                    value="{{ $charging_card['fees']['VIETTEL'] ?? 20 }}" placeholder="30">
                            </div>
                            <div class="col-md-3">
                                <label for="fees_vinaphone" class="form-label">Phí Thẻ Vinaphone</label>
                                <input type="text" class="form-control" id="fees_vinaphone" name="fees[VINAPHONE]"
                                    value="{{ $charging_card['fees']['VINAPHONE'] ?? 20 }}" placeholder="30">
                            </div>
                            <div class="col-md-3">
                                <label for="fees_mobifone" class="form-label">Phí Thẻ Mobifone</label>
                                <input type="text" class="form-control" id="fees_mobifone" name="fees[MOBIFONE]"
                                    value="{{ $charging_card['fees']['MOBIFONE'] ?? 20 }}" placeholder="30">
                            </div>
                            <div class="col-md-3">
                                <label for="fees_zing" class="form-label">Phí Thẻ Zing</label>
                                <input type="text" class="form-control" id="fees_zing" name="fees[ZING]"
                                    value="{{ $charging_card['fees']['ZING'] ?? 20 }}" placeholder="30">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="link_callback" class="form-label">Link Callback (POST)</label>
                            <input type="text" class="form-control" id="link_callback" name="link_callback"
                                value="{{ route('cron.deposit.card-callback') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="link_cron" class="form-label">Link Cron (manual)</label>
                            <input type="text" class="form-control" id="link_cron" name="link_cron"
                                value="{{ route('cron.deposit.check', ['type' => 'card']) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <small>* Chọn 1 trong 2 loại link trên - không được dùng 1 lần 2 link</small>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="mt-2 btn btn-primary" type="submit">Cập nhật ngay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="row">
                @foreach ($stats['card'] as $key => $value)
                    <div class="col-xl-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-fill">
                                        @if (isset($stats['t_card'][$key]['format']) && $stats['t_card'][$key]['format'] === 'currency')
                                            <p class="mb-1 fs-5 fw-semibold text-default">
                                                {{ formatCurrency($value) }}</p>
                                        @else
                                            <p class="mb-1 fs-5 fw-semibold text-default">
                                                {{ number_format($value) }}</p>
                                        @endif
                                        <p class="mb-0 text-muted">{{ $stats['t_card'][$key]['label'] ?? $key }}</p>
                                    </div>
                                    <div class="ms-2">
                                        <span
                                            class="avatar text-bg-{{ $stats['t_card'][$key]['color'] ?? 'primary' }} rounded-circle fs-20"><i
                                                class="bx bxs-wallet-alt"></i></span>
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
                    <div class="card-title">THỐNG KÊ NẠP THẺ THÁNG {{ date('m') }}</div>
                </div>
                <div class="card-body">
                    <canvas id="chartjs-line" class="chartjs-chart"></canvas>
                    <script>
                        (function() {
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    Chart.defaults.borderColor = "rgba(142, 156, 173,0.1)";
                                    Chart.defaults.color = "#8c9097";

                                    const labels = @json($chartCategories);
                                    const cardauto = @json($chartDeposit);

                                    const data = {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Nạp tiền tự động',
                                            backgroundColor: 'rgb(132, 90, 223)',
                                            borderColor: 'rgb(132, 90, 223)',
                                            data: cardauto,
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
                        LỊCH SỬ NẠP THẺ CÀO
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive theme-scrollbar mb-3">
                        <table class="display table table-bordered table-stripped text-nowrap datatable" id="basic-1">
                            <thead class="table">
                                <tr>
                                    <th>Username</th>
                                    <th class="text-center">Telco</th>
                                    <th class="text-center">Serial</th>
                                    <th class="text-center">Pin</th>
                                    <th class="text-center">Mệnh giá</th>
                                    <th class="text-center">Thực nhận</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Create date</th>
                                    <th class="text-center">Lý do</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rechargecard as $dvr)
                                    @php
                                        $getuser = User::find($dvr->user_id);
                                    @endphp

                                    <tr>
                                        <td><a class="text-primary"
                                                href="/Cpanel/users/{{ $getuser->id }}">{{ $getuser->username }} [ID
                                                {{ $getuser->id }}]</a>
                                        </td>
                                        <td class="text-center">{{ $dvr->type }}</td>
                                        <td class="text-center">{{ $dvr->serial }}</td>
                                        <td class="text-center">{{ $dvr->code }}</td>
                                        <td class="text-center">{{ formatCurrency($dvr->value) }}</td>
                                        <td class="text-center">{{ formatCurrency($dvr->amount) }}</td>
                                        <td class="text-center">
                                            {!! Helper::format_status_admin($dvr->status) !!}
                                        </td>
                                        <td class="text-center"><span
                                                class="badge bg-light text-dark">{{ $dvr->created_at }}</span></td>
                                        <td class="text-center"><span
                                                class="badge bg-light text-dark">{{ $dvr->content }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9">
                                        <div class="float-right">
                                            Tổng nạp: <strong
                                                style="color:red;">{{ formatCurrency($rechargecard->sum('value')) }}</strong>
                                            | Thực nhận: <strong
                                                style="color:blue;">{{ formatCurrency($rechargecard->sum('amount')) }}</strong>
                                        </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            var button = document.getElementById('open-card-config');
            var card = document.getElementById('card-config');

            // Thêm sự kiện click cho nút button
            button.addEventListener('click', function() {
                // Kiểm tra nếu card đang hiển thị thì ẩn đi, ngược lại hiển thị
                if (card.style.display === 'none' || card.style.display === '') {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
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
