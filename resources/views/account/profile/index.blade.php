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
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-2">
            <!--begin::Wrapper-->
            <div class="me-4">
                <!--begin::Menu-->
                <a
                    href="#"
                    class="btn btn-sm btn-flex btn-light btn-active-primary fw-bold"
                    data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end"
                >
                    <i class="ki-duotone ki-filter fs-5 text-gray-500 me-1"
                        ><span class="path1"></span><span class="path2"></span
                    ></i>
                    Filter
                </a>

                <!--begin::Menu 1-->
                <div
                    class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                    data-kt-menu="true"
                    id="kt_menu_67309706460af"
                >
                    <div class="px-7 py-5">
                        <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                        <div class="text-muted fs-7 mt-1">Các bộ lọc mẫu này không còn dùng trực tiếp để giảm DOM/JS nặng.</div>
                    </div>
                </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button
                                type="reset"
                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true"
                            >
                                Reset
                            </button>

                            <button
                                type="submit"
                                class="btn btn-sm btn-primary"
                                data-kt-menu-dismiss="true"
                            >
                                Apply
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Menu 1-->
                <!--end::Menu-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Button-->
            <a
                href="#"
                class="btn btn-sm btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#kt_modal_create_app"
                id="kt_toolbar_primary_button"
            >
                Create
            </a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
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

                            <!--begin::Actions-->
                            <div class="d-flex my-4">
                                <a
                                    href="#"
                                    class="btn btn-sm btn-light me-2"
                                    id="kt_user_follow_button"
                                >
                                    <i
                                        class="ki-duotone ki-check fs-3 d-none"
                                    ></i>
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label"> Follow</span>
                                    <!--end::Indicator label-->

                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">
                                        Please wait...
                                        <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"
                                        ></span>
                                    </span>
                                    <!--end::Indicator progress-->
                                </a>

                                

                                <!--begin::Menu-->

                                <!--end::Menu-->
                            </div>
                            <!--end::Actions-->
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
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="/account/profile">
                            Thông tin chi tiết
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/history">
                            Lịch sử hoạt động
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/transactions">
                           Lịch sử dòng tiền
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
            <section class="space-y-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="card custom-card">
                      <div class="card-header">
                        <h3 class="card-title">Thông tin tài khoản</h3>
                      </div>
                      <div class="card-body">
                        <form class="space-y-3">
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="username" class="form-label">Tên Đăng Nhập</label>
                              <input id="username" name="username" type="text" class="form-control" value="{{ $user->username }}" disabled="">
                            </div>
                            <div class="col-md-6">
                              <label for="email" class="form-label">Địa chỉ e-mail</label>
                              <input id="email" name="email" type="text" class="form-control" value="{{ $user->email }}" disabled="">
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="created_at" class="form-label">Ngày Đăng Ký</label>
                              <input id="created_at" name="created_at" type="text" class="form-control" value="{{ $user->created_at }}" disabled="">
                            </div>
                            <div class="col-md-6">
                              <label for="updated_at" class="form-label">Ngày Cập Nhật</label>
                              <input id="updated_at" name="updated_at" type="text" class="form-control" value="{{ $user->updated_at }}" disabled="">
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="balance" class="form-label">Số Tiền Hiện Có</label>
                              <input id="balance" name="balance" type="text" class="form-control" value="₫{{ $user->balance }}" disabled="">
                            </div>
                            <div class="col-md-6">
                              <label for="total_deposit" class="form-label">Tổng Tiền Đã Nạp</label>
                              <input id="total_deposit" name="total_deposit" type="text" class="form-control" value="₫{{ $user->total_deposit }}" disabled="">
                            </div>
                          </div>
                          <div class="mb-2">
                            <div class="alert alert-danger">
                              Access Token *: <span id="access_token">{{ $user->access_token }}</span>
                              <a href="javascript:void(0)" class="copy" data-clipboard-target="#access_token" onclick="copy()"><i class="fas fa-copy"></i></a>
                              |
                              <a href="javascript:void(0)" class="text-success" onclick="changeAccessToken()"><i class="fas fa-refresh"></i> Đổi token</a>
                            </div>
                          </div>
                          
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card custom-card">
                      <div class="card-header">
                        <h3 class="card-title">Thay đổi mật khẩu</h3>
                      </div>
                      <div class="card-body">
                        <form action="{{ route('account.profile.password-update') }}" method="POST" class="space-y-3">
                            @csrf
                     <div class="mb-3">
                            <label for="old_password" class="form-label">Mật Khẩu Cũ</label>
                            <input type="password" class="form-control  py-2" id="old_password" name="old_password" placeholder="Nhập mật khẩu cũ" required="">
                          </div>
                          <div class="mb-3">
                            <label for="new_password" class="form-label">Mật Khẩu Mới</label>
                            <input type="password" class="form-control  py-2" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới" required="">
                          </div>
                          <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác Nhận Mật Khẩu</label>
                            <input type="password" class="form-control  py-2" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required="">
                          </div>
                          <div class="mb-3 text-end">
                            <button type="submit" class="btn btn-sm btn-primary w-full">Đổi Mật Khẩu</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </section>
            <!--end::Col-->

            <!--begin::Col-->
          
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Post-->
</div>
@endsection
@section('scripts')
  <script>
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
