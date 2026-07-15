@php use App\Helpers\Helper; @endphp 
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <!--begin::Container-->
    <div
        id="kt_toolbar_container"
        class="container-xxl d-flex flex-stack flex-wrap"
    >
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Thông tin tài khoản</h1>
            <!--end::Title-->

            <!--begin::Breadcrumb-->
            <ul
                class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1"
            >
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a
                        href="/"
                        class="text-gray-600 text-hover-primary"
                    >
                        Home
                    </a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">User Profile</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Container-->
    </div>
    <!--end::Container-->
</div>
<div
    id="kt_content_container"
    class="d-flex flex-column-fluid align-items-start container-xxl"
>
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <!--begin: Pic-->
                    <div class="me-7 mb-4">
                        <div
                            class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative"
                        >
                            <img
                                src="{{ asset('assets/media/avatars/user-placeholder.svg') }}"
                                alt="image"
                            />
                            <div
                                class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"
                            ></div>
                        </div>
                    </div>
                    <!--end::Pic-->

                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div
                            class="d-flex justify-content-between align-items-start flex-wrap mb-2"
                        >
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <a
                                        href="#"
                                        class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"
                                        >{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</a
                                    >
                                    <a href="#"
                                        ><i
                                            class="ki-duotone ki-verify fs-1 text-primary"
                                            ><span class="path1"></span
                                            ><span class="path2"></span></i
                                    ></a>
                                </div>
                                <!--end::Name-->

                                <!--begin::Info-->
                                <div
                                    class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2"
                                >
                                @if ($user->level == 1)
                                    <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        Admin
                                    </a>
                                @elseif ($user->level == 2)                                  
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    Người Bán
                                </a>
                                @else 
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    Thành Viên
                                </a>
                                 @endif
                                    <a
                                        href="#"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2"
                                    >
                                        <i
                                            class="ki-duotone ki-geolocation fs-4 me-1"
                                            ><span class="path1"></span
                                            ><span class="path2"></span
                                        ></i>
                                        Việt Nam
                                    </a>
                                    <a
                                        href="#"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary mb-2"
                                    >
                                        <i class="ki-duotone ki-sms fs-4 me-1"
                                            ><span class="path1"></span
                                            ><span class="path2"></span
                                        ></i>
                                        {{ auth()->user()->email ?? 'example@local' }}
                                    </a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Title-->

                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap flex-stack">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <!--begin::Stats-->
                                <div class="d-flex flex-wrap">
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                                    >
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="ki-duotone ki-arrow-up fs-3 text-success me-2"
                                                ><span class="path1"></span
                                                ><span class="path2"></span
                                            ></i>
                                            <div
                                                class="fs-2 fw-bold counted"
                                                data-kt-countup="true"
                                                data-kt-countup-value="4500"
                                                data-kt-countup-prefix="$"
                                                data-kt-initialized="1"
                                            >
                                            <small>{{ number_format($user->balance ?? 0) }}</small>₫
                                            </div>
                                        </div>
                                        <!--end::Number-->

                                        <!--begin::Label-->
                                        <div
                                            class="fw-semibold fs-6 text-gray-500"
                                        >
                                            Số dư
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->

                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                                    >
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="ki-duotone ki-arrow-down fs-3 text-danger me-2"
                                                ><span class="path1"></span
                                                ><span class="path2"></span
                                            ></i>
                                            <div
                                                class="fs-2 fw-bold counted"
                                                data-kt-countup="true"
                                                data-kt-countup-value="80"
                                                data-kt-initialized="1"
                                            >
                                            <small>{{ number_format(($user->total_deposit ?? 0) - ($user->balance ?? 0)) }}</small>₫
                                            </div>
                                        </div>
                                        <!--end::Number-->

                                        <!--begin::Label-->
                                        <div
                                            class="fw-semibold fs-6 text-gray-500"
                                        >
                                            Tổng chi
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->

                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                                    >
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="ki-duotone ki-arrow-up fs-3 text-success me-2"
                                                ><span class="path1"></span
                                                ><span class="path2"></span
                                            ></i>
                                            <div
                                                class="fs-2 fw-bold counted"
                                                data-kt-countup="true"
                                                data-kt-countup-value="60"
                                                data-kt-countup-prefix="%"
                                                data-kt-initialized="1"
                                            >
                                            <small>{{ number_format($user->total_deposit ?? 0) }}</small>₫
                                            </div>
                                        </div>
                                        <!--end::Number-->

                                        <!--begin::Label-->
                                        <div
                                            class="fw-semibold fs-6 text-gray-500"
                                        >
                                            Tổng nạp
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Progress-->

                            <!--end::Progress-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Details-->

                <!--begin::Navs-->
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mt-5">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="/account/profile">
                            Thông tin chi tiết
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/history">
                            Nhật ký hoạt động
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/transactions">
                            Lịch sử dòng tiền
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/orders">
                            Lịch sử mua hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/chat">
                            Tin nhắn
                        </a>
                    </li>
                </ul>
                <!--begin::Navs-->

            </div>
        </div>
        <!--end::Navbar-->
        <!--begin::Row-->
        <div class="row g-5 g-xxl-8">
            <!--begin::Col-->
            <section>
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-6">
                        <div class="card shadow-sm" style="border-radius: 16px; border: none;">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Thông tin tài khoản</span>
                                    <span class="text-muted fw-semibold fs-7">Chi tiết hồ sơ của bạn</span>
                                </h3>
                            </div>
                            <div class="card-body py-5">
                                <div class="row mb-5">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="form-label fw-semibold text-gray-700 fs-7">Tên đăng nhập</label>
                                        <input type="text" class="form-control form-control-solid fw-bold text-gray-600" value="{{ $user->username }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-gray-700 fs-7">Địa chỉ e-mail</label>
                                        <input type="text" class="form-control form-control-solid fw-bold text-gray-600" value="{{ $user->email }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="form-label fw-semibold text-gray-700 fs-7">Ngày đăng ký</label>
                                        <input type="text" class="form-control form-control-solid fw-bold text-gray-600" value="{{ $user->created_at }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-gray-700 fs-7">Ngày cập nhật</label>
                                        <input type="text" class="form-control form-control-solid fw-bold text-gray-600" value="{{ $user->updated_at }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="form-label fw-semibold text-gray-700 fs-7">Số dư khả dụng</label>
                                        <input type="text" class="form-control form-control-solid fw-bold text-success" value="{{ number_format($user->balance) }} ₫" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-gray-700 fs-7">Tổng nạp</label>
                                        <input type="text" class="form-control form-control-solid fw-bold text-primary" value="{{ number_format($user->total_deposit) }} ₫" disabled>
                                    </div>
                                </div>

                                <div class="mt-6 p-4 rounded-3 d-flex align-items-center justify-content-between" style="background: #f8f9fa; border: 1px dashed #e4e6ef;">
                                    <div class="overflow-hidden">
                                        <div class="fs-7 fw-bold text-gray-500 mb-1">Access Token API</div>
                                        <div class="fs-6 fw-bold text-gray-800 text-truncate" id="access_token" style="max-width: 100%;">{{ $user->access_token }}</div>
                                    </div>
                                    <div class="d-flex align-items-center ms-3 flex-shrink-0 gap-2">
                                        <button type="button" class="btn btn-icon btn-light-primary btn-sm" onclick="copy()" data-clipboard-target="#access_token" data-bs-toggle="tooltip" title="Copy Token">
                                            <i class="ki-duotone ki-copy fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-light-success btn-sm" onclick="changeAccessToken()" data-bs-toggle="tooltip" title="Đổi Token mới">
                                            <i class="ki-duotone ki-arrows-circle fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card shadow-sm h-100" style="border-radius: 16px; border: none;">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Đổi mật khẩu</span>
                                    <span class="text-muted fw-semibold fs-7">Bảo mật tài khoản của bạn</span>
                                </h3>
                            </div>
                            <div class="card-body py-5">
                                <form action="{{ route('account.profile.password-update') }}" method="POST">
                                    @csrf
                                    <div class="mb-5">
                                        <label for="old_password" class="form-label fw-semibold text-gray-700 fs-7 required">Mật khẩu hiện tại</label>
                                        <div class="input-group input-group-solid">
                                            <span class="input-group-text"><i class="ki-duotone ki-lock fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                                            <input type="password" class="form-control form-control-solid" id="old_password" name="old_password" placeholder="Nhập mật khẩu cũ" required>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <label for="new_password" class="form-label fw-semibold text-gray-700 fs-7 required">Mật khẩu mới</label>
                                        <div class="input-group input-group-solid">
                                            <span class="input-group-text"><i class="ki-duotone ki-shield-tick fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                                            <input type="password" class="form-control form-control-solid" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới" required>
                                        </div>
                                    </div>
                                    <div class="mb-8">
                                        <label for="confirm_password" class="form-label fw-semibold text-gray-700 fs-7 required">Xác nhận mật khẩu</label>
                                        <div class="input-group input-group-solid">
                                            <span class="input-group-text"><i class="ki-duotone ki-check fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                                            <input type="password" class="form-control form-control-solid" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
                                        </div>
                                    </div>
                                    <div class="text-end mt-auto">
                                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #009ef7, #007bff); border: none; padding: 12px 24px; border-radius: 10px;">
                                            <i class="ki-duotone ki-shield-cross fs-4 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Lưu thay đổi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--end::Col-->
        </div>
        <!--end::Row-->


        <!--end::History Card-->

    </div>
    <!--end::Post-->
</div>
@endsection
@section('scripts')
  <script>
    $("#kt_datatable_zero_configuration").DataTable({
        "order": [[ 0, "asc" ]],
        "language": {
            "lengthMenu": "Hiển thị _MENU_ bản ghi",
            "zeroRecords": "Không tìm thấy dữ liệu",
            "info": "Hiển thị trang _PAGE_ của _PAGES_",
            "infoEmpty": "Không có bản ghi nào",
            "infoFiltered": "(lọc từ _MAX_ bản ghi)",
            "search": "Tìm kiếm:",
            "paginate": {
                "first": "Đầu",
                "last": "Cuối",
                "next": "Sau",
                "previous": "Trước"
            }
        }
    });

    const changeAccessToken = async () => {
  const confirm = await Swal.fire({
    title: 'Bạn chắc chứ?',
    text: 'Bạn sẽ không thể hoàn tác điều này!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Đồng ý',
    cancelButtonText: 'Hủy',
    reverseButtons: true,
  });

  if (!confirm.isConfirmed) return;

  $showLoading();

  try {
    const { data: result } = await axios.post('{{ route('account.profile.token-update') }}');
    $('#access_token').text(result.data.access_token);
    Swal.fire('Success', result.message, 'success');
  } catch (error) {
    const errors = error?.response?.data?.errors || null;

    if (errors !== null) {
      for (const [key, value] of Object.entries(errors)) {
        document.getElementById(`${key}`).classList.add("is-invalid");
        document.getElementById(`${key}-error`).innerHTML = value;
      }
    }
    showMessage(error.response?.data?.message || 'Có lỗi xảy ra. Vui lòng thử lại.', 'error');
  }
};
  </script>
@endsection
