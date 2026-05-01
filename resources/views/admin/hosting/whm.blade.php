@php
    use App\Helpers\Helper;
    use App\Models\WhmInfo;
    use App\Models\CategoryHosting;
@endphp
@extends('admin.layouts.master')
@section('title', 'MÁY CHỦ HOSTING')
@section('css')
    <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

    <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
    <div class="mb-3 text-end">
        <button data-bs-toggle="modal" data-bs-target="#modal-create" class="btn btn-outline-primary me-2"><i
                class="fas fa-plus"></i> {{ __('Thêm Máy Chủ') }}</button>
    </div>

    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">MÁY CHỦ HOSTING</div>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar" style="padding: 10px">
                <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
                    <thead>
                        <tr>
                            <th class="text-center">Danh Mục</th>
                            <th class="text-center">Tên máy chủ</th>
                            <th class="text-center">IP máy chủ</th>
                            <th class="text-center">Tài Khoản</th>
                            <th class="text-center">Remote Usage Stats</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Đăng Nhập WHM</th>
                            <th class="text-center">Ngày Đăng</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whm_info as $whm_infos)
                            @php
                                $category_hostingo = CategoryHosting::find($whm_infos->category);
                            @endphp
                            <tr>
                                <td class="text-center">{{ $category_hostingo->name ?? 'Không Rõ' }}</td>
                                <td class="text-center">{{ $whm_infos->whm_host }}</td>
                                <td class="text-center">{{ $whm_infos->ip }}</td>
                                <td class="text-center">{{ $whm_infos->whm_user }}</td>
                                <td class="text-center" id="account-{{ $whm_infos->id }}">Đang tải dữ liệu...</td>
                                <td class="text-center">{!! Helper::status_server_cron_admin($whm_infos->status) !!}</td>
                                <td class="text-center">
                                    <a href="javascript:LoginRow({{ $whm_infos->id }})"
                                        class="btn btn-outline-danger btn-sm btn-wave waves-effect waves-light"
                                        data-bs-toggle="tooltip" title="Login">
                                        Login To WHM
                                    </a>
                                </td>
                                <td class="text-center">{{ $whm_infos->created_at }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#modal-update-{{ $whm_infos->id }}" class="btn btn-sm btn-primary"
                                        data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="javascript:deleteRow({{ $whm_infos->id }})" class="btn btn-sm btn-danger"
                                        data-bs-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm Máy Chủ WHM</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
                        Lưu ý : Mỗi danh mục chỉ sài 1 máy chủ whm <br>
                        Những danh mục không ấn được là nó đã có tài khoản whm <br>
                        Bạn có thể ấn kiểm tra kết nối để xem đã đúng tài khoản mật khẩu hãy chưa nhé
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
                    </div>
                    <form action="{{ route('admin.hosting.whm.store') }}" method="POST" class="axios-dvr" data-reload="1"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="category" class="form-label">Chọn Danh Mục</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">-- Chọn Danh Mục --</option>
                                @foreach ($category_hosting as $category_hostingz)
                                @php 
                                  $whm = WhmInfo::where('category', $category_hostingz->id)->count();
                                @endphp
                                    <option value="{{ $category_hostingz->id }}" @if ($whm >0) disabled @endif >{{ $category_hostingz->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="whm_host" class="form-label">Tên máy chủ hoặc Địa chỉ IP</label>
                            <input class="form-control" type="text" id="whm_host" name="whm_host"
                                value="{{ old('whm_host') }}" placeholder="vn.muabanwebsite.io.vn | 1.1.1.1" required>
                        </div>
                        <div class="mb-3 card bg-secondary mode_form"></div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="whm_user" class="form-label">Tên người dùng</label>
                                <input type="text" class="form-control" name="whm_user" id="whm_user"
                                    value="{{ old('whm_user') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="whm_pass" class="form-label">Mật khẩu</label>
                                <input type="text" class="form-control" name="whm_pass" id="whm_pass"
                                    value="{{ old('whm_pass') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" @if (old('status') == 1) selected @endif>Hoạt động</option>
                                <option value="0" @if (old('status') == 0) selected @endif>Không hoạt động
                                </option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button type="button" id="WhmLogin"
                                        class="btn btn-outline-danger btn-wave waves-effect waves-light w-100">
                                        Kiểm tra kết nối »</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button class="btn btn-primary w-100" type="submit">Thêm mới</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach ($whm_info as $value)
        <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật máy chủ #{{ $value->id }}</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.hosting.whm.update', ['id' => $value->id]) }}" class="default-dvr"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="category" class="form-label">Chọn Danh Mục</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">-- Chọn Danh Mục --</option>
                                    @foreach ($category_hosting as $category_hostingk)
                                        <option value="{{ $category_hostingk->id }}"
                                            @if ($value->category == $category_hostingk->id) selected @endif>
                                            {{ $category_hostingk->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="whm_host" class="form-label">Tên máy chủ hoặc Địa chỉ IP</label>
                                <input class="form-control" type="text" id="whm_host-{{ $value->id }}"
                                    name="whm_host" value="{{ $value->whm_host }}" placeholder="vn.muabanwebsite.io.vn"
                                    required>
                            </div>
                            <div class="mb-3 card bg-secondary mode_form"></div>
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label for="whm_user" class="form-label">Tên người dùng</label>
                                    <input type="text" class="form-control" name="whm_user"
                                        id="whm_user-{{ $value->id }}" value="{{ $value->whm_user }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="whm_pass" class="form-label">Mật khẩu</label>
                                    <input type="text" class="form-control" name="whm_pass"
                                        id="whm_pass-{{ $value->id }}" value="{{ $value->whm_pass }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1" @if ($value->status == 1) selected @endif>Đang hoạt động
                                    </option>
                                    <option value="0" @if ($value->status == 0) selected @endif>Không hoạt
                                        động</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <button type="button" onclick="LoginWhm({{ $value->id }})"
                                            class="btn btn-outline-danger btn-wave waves-effect waves-light w-100">
                                            Kiểm tra kết nối »</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100" type="submit">Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('scripts')
    <script type="text/javascript">
        function LoginWhm(id) {
            var whm_host = $("#whm_host-" + id).val();
            var whm_user = $("#whm_user-" + id).val();
            var whm_pass = $("#whm_pass-" + id).val();
            pageOverlay.show()
            $.ajax({
                url: "{{ route('admin.hosting.whm.login') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    whm_host: whm_host,
                    whm_user: whm_user,
                    whm_pass: whm_pass,
                    _token: "{{ csrf_token() }}",
                },
                success: function(result) {
                    pageOverlay.hide()
                    if (result.status == '200') {
                        showMessage(result.message, 'success');
                    } else {
                        showMessage(result.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    pageOverlay.hide()
                    var responseMessage = xhr.responseJSON ? xhr.responseJSON.message :
                        'Vui lòng liên hệ Developer';
                    showMessage(responseMessage, 'error');
                }
            });
        }
        $("#WhmLogin").on("click", function() {
            var whm_host = $("#whm_host").val();
            var whm_user = $("#whm_user").val();
            var whm_pass = $("#whm_pass").val();
            $('#WhmLogin').html('Đang xử lý...').prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.hosting.whm.login') }}",
                dataType: "JSON",
                method: "POST",
                data: {
                    whm_host: whm_host,
                    whm_user: whm_user,
                    whm_pass: whm_pass,
                    _token: "{{ csrf_token() }}",
                },
                success: function(result) {
                    if (result.status == '200') {
                        showMessage(result.message, 'success');
                    } else {
                        showMessage(result.message, 'error');
                    }
                    $('#WhmLogin').html(
                            'Kiểm tra kết nối »')
                        .prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    var responseMessage = xhr.responseJSON ? xhr.responseJSON.message :
                        'Vui lòng liên hệ Developer';
                    showMessage(responseMessage, 'error');
                    $('#WhmLogin').html(
                            'Kiểm tra kết nối »')
                        .prop('disabled', false);
                }
            });
        });
        const LoginRow = async (id) => {
            const confirmDelete = await Swal.fire({
                title: '{{ __('Bạn chắc chứ?') }}',
                text: "{{ __('Bạn đã chắc sẽ login vào whm với tài khoản này!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('Đồng ý') }}',
                cancelButtonText: '{{ __('Hủy') }}'
            });

            if (!confirmDelete.isConfirmed) return;

            $showLoading();

            try {
                const {
                    data: result
                } = await axios.post('{{ route('admin.hosting.whm.link.login') }}', {
                    id
                })

                if (result.success) {
                    Swal.fire('Thành công', 'Đang chuyển hướng tới WHM', 'success');
                    window.open(result.redirectTo, '_blank');
                } else {
                    Swal.fire('Thất bại', result.errorMsg, 'error');
                }

            } catch (error) {
                Swal.fire('Thất bại', $catchMessage(error), 'error')
            }
        }
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
                } = await axios.post('{{ route('admin.hosting.whm.delete') }}', {
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
        document.addEventListener('DOMContentLoaded', function() {
            const whmIds = [
                @foreach ($whm_info as $whm_infos)
                    {{ $whm_infos->id }},
                @endforeach
            ];

            whmIds.forEach(id => {
                fetch(`/api/get-account-count?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const cell = document.getElementById(`account-${id}`);
                        if (data.totalAccounts !== undefined && data.totalAccounts !== null) {
                            cell.textContent = `Accounts: ${data.totalAccounts}`;
                        } else {
                            cell.textContent = 'Không thể lấy dữ liệu';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching account count:', error);
                        const cell = document.getElementById(`account-${id}`);
                        cell.textContent = 'Error loading';
                    });
            });
        });
    </script>
@endsection
