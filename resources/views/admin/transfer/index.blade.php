@php
    use App\Helpers\Helper;
    use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'Quản lý hoá đơn')
@section('css')
    <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

    <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
    <div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
        <svg class="svg-warning" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem"
            fill="#000000">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path
                d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z">
            </path>
        </svg>
        Bạn vui lòng truy cập liên kết: <a class="text-primary" href="{{ route('admin.recharge.apibank') }}"
            target="_blank">{{ route('admin.recharge.apibank') }}</a> để có thể biết link cron cho các đơn hàng theo hình thức thanh toán chuyển khoản.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
    </div>
    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">Quản lý hoá đơn</div>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar" style="padding: 10px">
                <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="sorting sorting_desc" tabindex="0" aria-controls="datatable" rowspan="1"
                                colspan="1" aria-sort="descending" aria-label="ID: activate to sort column ascending"
                                style="width: 35px;">ID</th>
                            <th class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="Thao tác"
                                style="width: 85px;">Thao tác</th>
                            <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Order ID"
                                style="width: 258px;">Order ID</th>
                            <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Thông tin"
                                style="width: 470px;">Thông tin</th>
                            <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Trạng thái"
                                style="width: 256px;">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transfer as $transfers)
                        @php  $user = User::find($transfers->user_id); @endphp
                            <tr>
                                <td class="sorting_1">{{ $transfers->id }}</td>
                                <td class="text-center">
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal-update-{{ $transfers->id }}" class="text-primary order__action me-2"
                                         data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Cập nhật đơn hàng"><i class="fas fa-edit"></i></a>
                                <a href="javascript:;"
                                        class="text-danger order__action me-2" data-action="view" data-order-id="3"
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa đơn hàng" onclick="deleteRow({{ $transfers->id }})"><i class="fas fa-trash"></i></a></td>
                                <td>
                                    <div><span>transactionCode: </span><span class="text-danger">{{ $transfers->trans_id }}</span></div>
                                    <div><span>Username: </span><span class="text-primary">{{ $user->username }}</span></div>
                                    <div><span>Created At: </span><span class="text-success">{{ $transfers->created_at }}</span></div>
                                    <div><span>Updated At: </span><span class="text-warning">{{ $transfers->updated_at }}</span></div>
                                </td>
                                <td>
                                    <div><span>Ngân Hàng: </span><span class="text-muted"><b class="text-primary">{{ $transfers->bank }}</b></span>
                                    </div>
                                    <div><span>Nội Dung: </span><span class="text-muted">{{ $transfers->noidung }}</span></div>
                                    <div><span>Tổng tiền: </span><span
                                            class="text-primary">{{ formatCurrency($transfers->price) }}</span> -
                                    </div>
                                    <div><span>transactionID: </span><span class="text-muted">{{ $transfers->transactionID }}</span></div>
                                </td>
                                <td>
                                    <div><span class="mb-2">Status: </span>{!! Helper::status_tranfer_admin($transfers->status) !!}</div>
                                    <div><span>---------</span></div>
                                    <div><span>Dịch vụ: </span><span class="text-muted">{!! Helper::type_tranfer_admin($transfers->content['type']) !!}</span></div>
                                    </div>
                                    <div><span>Response: </span><span class="text-danger">
                                        {{ \Illuminate\Support\Str::limit(json_encode($transfers->content), 35) }}
                                    </span></div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    @foreach ($transfer as $value)
        <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật đơn hàng #{{ $value->trans_id }}</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.transfer.update', ['id' => $value->id]) }}" class="default-form"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1" @if ($value->status == 1) selected @endif>Chờ thanh toán</option>
                                    <option value="2" @if ($value->status == 2) selected @endif>Đã thanh toán</option>
                                    <option value="3" @if ($value->status == 3) selected @endif>Hủy thanh toán</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary w-100" type="submit">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
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
