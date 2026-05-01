@php
    use App\Helpers\Helper;
    use App\Models\User;
    use App\Models\CategoryHosting;
    use App\Models\HostingPackages;
@endphp
@extends('admin.layouts.master')
@section('title', 'Quản lý Hosting')
@section('css')
    <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

    <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
    <div class="alert alert-danger alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
        <svg class="svg-danger" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem"
            fill="#000000">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path
                d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z">
            </path>
        </svg>
        Vui lòng thực hiện <b>CronJob</b> liên kết: <a class="text-primary" href="{{ route('hosting.cron.auto') }}"
            target="_blank">{{ route('hosting.cron.auto') }}</a> 1 phút 1 lần hoặc nhanh hơn để hệ thống xử lý
        gia hạn hosting auto và xử lý các hosting hết hạn.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
    </div>
    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">Quản lý Hosting</div>
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
                        @foreach ($host as $hosts)
                            @php
                                $user = User::find($hosts->user_id);
                                $category = CategoryHosting::find($hosts->info_package['category']);
                            @endphp

                            <tr>
                                <td class="sorting_1">{{ $hosts->id }}</td>
                                <td class="text-center">
                                    <a href="javascript:;" data-bs-toggle="modal"
                                    data-bs-target="#modal-lock-{{ $hosts->id }}" class="text-danger order__action me-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Khóa hosting">
                                        <i class="fa-solid fa-lock"></i>
                                      </a>
                                      <a href="javascript:;" class="text-info order__action me-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                      data-bs-title="Mở khóa hosting" onclick="Unlock({{ $hosts->id }})">
                                        <i class="fa-solid fa-lock-open"></i>
                                      </a>
                                    <a href="javascript:;" data-bs-toggle="modal"
                                        data-bs-target="#modal-changePackage-{{ $hosts->id }}"
                                        class="text-primary order__action me-2" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Cập nhật đơn hàng"><i class="fa-solid fa-arrow-up"></i>
                                    <a href="javascript:;" class="text-danger order__action me-2" data-action="view"
                                        data-order-id="3" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Xóa đơn hàng" onclick="deleteRow({{ $hosts->id }})"><i
                                            class="fas fa-trash"></i></a>
                                </td>
                                <td>
                                    <div><span>Danh mục: </span><span
                                            class="text-danger">{{ $category->name ?? 'Không xác định' }}</span></div>
                                    <div><span>Link Whm: </span><span class="text-primary">{{ $hosts->server_whm['whm_host'] }}</span>
                                            </div>
                                    <div><span>Username: </span><span class="text-primary">{{ $user->username }}</span>
                                    </div>
                                    <div><span>Created At: </span><span class="text-success">{{ $hosts->created_at }}</span>
                                    </div>
                                    <div><span>Updated At: </span><span class="text-warning">{{ $hosts->updated_at }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div><span class="mb-2">Domain: </span><span
                                        class="text-primary">{{ $hosts->domain_name ?? 'null' }}</span>
                                </div>
                                    <div><span>Tài Khoản: </span><span class="text-muted"><b
                                                class="text-primary">{{ $hosts->username }}</b></span>
                                    </div>
                                    <div><span>Mật Khẩu: </span><span class="text-muted">{{ $hosts->password }}</span>
                                    </div>
                                    <div><span>Tổng tiền: </span><span
                                            class="text-primary">{{ formatCurrency($hosts->total) }}</span>
                                    </div>
                                    <div><span>Chu Kỳ: </span><span
                                            class="text-muted">{{ checkYearOrMonth($hosts->month) }}</span></div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mb-1">Login Cpanel: </span>
                                        <a href="javascript:LoginRow({{ $hosts->id }})" class=" btn btn-outline-danger btn-sm btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-original-title="Login">
                                            <i class="fa-solid fa-right-to-bracket"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="mb-1">Gia Hạn: </span>
                                        <div class="form-check form-switch ms-2 mb-2">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="flexSwitchCheckDefault{{ $hosts->id }}" value="{{ $hosts->id }}"
                                                onchange="updateStatus(this)" {{ $hosts->giahan == 1 ? 'checked' : '' }}>
                                            <label class="form-check label"
                                                for="flexSwitchCheckDefault{{ $hosts->id }}"></label>
                                        </div>
                                    </div>
                                    <div><span class="mb-2">Gói: </span><span
                                            class="text-primary">{{ $hosts->server_whm['whm_user'] ?? 'null' }}_{{ $hosts->info_package['package_name'] ?? 'null' }}</span>
                                    </div>
                                    <div><span class="mb-2">Status: </span>{!! Helper::status_hosting_admin($hosts->status) !!}</div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    @foreach ($host as $value)
    <div class="modal fade" id="modal-changePackage-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Thay đổi gói hosting #{{ $value->id }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.hosting.list.changepackage', ['id' => $value->id]) }}" class="axios-form" method="POST" data-reload="true" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="money_user" class="form-label">Trừ tiền User</label>
                <select class="form-control" id="money_user" name="money_user">
                    <option value="1">Có trừ tiền</option>
                    <option value="0">Không trừ tiền</option>
                </select>
            </div>
              <div class="mb-3">
                <label for="category" class="form-label">Chọn Gói Hosting</label>
                <select class="form-control" id="category" name="category">
                    <option value="">-- Chọn Gói Hosting --</option>
                    @php
                    $pack = HostingPackages::where('category', $value->info_package['category'])->get();
                    @endphp
                    @foreach ($pack as $packs)
                        <option value="{{ $packs->id }}" @if ($packs->id == $value->info_package['id']) disabled @endif @if ($packs->id < $value->info_package['id']) disabled @endif >{{ $packs->package_name }} @if ($packs->id < $value->info_package['id']) (Gói này bé hơn gói hiện tại) @endif</option>
                    @endforeach
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
    @foreach ($host as $value)
    <div class="modal fade" id="modal-lock-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Khóa hosting #{{ $value->id }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.hosting.list.lock', ['id' => $value->id]) }}" class="axios-form" data-reload="true" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Lý do</label>
                <textarea name="suspendreason" id="suspendreason" class="form-control" rows="4">{{ old('suspendreason') }}</textarea>
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
        const LoginRow = async (id) => {
            const confirmDelete = await Swal.fire({
                title: '{{ __('Bạn chắc chứ?') }}',
                text: "{{ __('Bạn đã chắc sẽ login vào cpanel với tài khoản này!') }}",
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
                } = await axios.post('{{ route('admin.hosting.list.login') }}', {
                    id
                })

                if (result.success) {
                    Swal.fire('Thành công', 'Đang chuyển hướng tới Cpanel', 'success');
                    window.open(result.redirectTo, '_blank');
                } else {
                    Swal.fire('Thất bại', result.errorMsg, 'error');
                }

            } catch (error) {
                Swal.fire('Thất bại', $catchMessage(error), 'error')
            }
        }
        const Unlock = async (id) => {
            const confirmDelete = await Swal.fire({
                title: '{{ __('Bạn chắc chứ?') }}',
                text: "{{ __('Bạn sẽ mở khóa hosting này!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('Đúng rùi') }}',
                cancelButtonText: '{{ __('Hủy') }}'
            });

            if (!confirmDelete.isConfirmed) return;

            $showLoading();

            try {
                const {
                    data: result
                } = await axios.post('{{ route('admin.hosting.list.unlock') }}', {
                    id
                })

                Swal.fire('Thành công', result.message, 'success').then(() => {
                    window.location.reload();
                })
            } catch (error) {
                Swal.fire('Thất bại', $catchMessage(error), 'error')
            }
        }
        const updateStatus = (element) => {
            let id = element.value;
            let status = element.checked ? 1 : 0;

            axios.post(`{{ route('admin.hosting.list.giahan.auto') }}`, {
                id: id,
                status: !!status
            }).then((response) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: response.data.message
                })
            }).catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: $catchMessage(error)
                })
            });
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
                } = await axios.post('{{ route('admin.hosting.list.delete') }}', {
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
