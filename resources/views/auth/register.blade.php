@extends('layouts.auth')
@section('title', ('Đăng Ký Tài Khoản'))
@section('content')
<body
  id="kt_body"
  class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center"
>
  <!--begin::Theme mode setup on page load-->
  <script>
    var defaultThemeMode = "light";
    var themeMode;

    if (document.documentElement) {
      if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
        themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
      } else {
        if (localStorage.getItem("data-bs-theme") !== null) {
          themeMode = localStorage.getItem("data-bs-theme");
        } else {
          themeMode = defaultThemeMode;
        }
      }

      if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches
          ? "dark"
          : "light";
      }

      document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
  </script>
  <!--end::Theme mode setup on page load-->

  <!--begin::Main-->
  <!--begin::Root-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Page bg image-->
    <style>
      body {
        background-image: url("/assets/media/auth/bg10.jpeg");
      }

      [data-bs-theme="dark"] body {
        background-image: url("/assets/media/auth/bg10-dark.jpeg");
      }
    </style>
    <!--end::Page bg image-->

    <!--begin::Authentication - Sign-up -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Aside-->
      <div class="d-flex flex-lg-row-fluid">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
          <!--begin::Image-->
          <img
            class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
            src="/assets/media/auth/agency.png"
            alt=""
          />
          <img
            class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
            src="/assets/media/auth/agency-dark.png"
            alt=""
          />
          <!--end::Image-->

          <!--begin::Title-->
          <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
            Tham gia Cộng Đồng Lập Trình Đẳng Cấp - Mở Rộng Khả Năng Sáng Tạo của Bạn!
          </h1>
          <!--end::Title-->

          <!--begin::Text-->
          <div class="text-gray-600 fs-base text-center fw-semibold">
            Đăng ký ngay hôm nay để nhận những ưu đãi đặc biệt và cùng {{ config('app.name') }} đưa ý tưởng của bạn thành hiện thực!.
          </div>
          <!--end::Text-->
        </div>
        <!--end::Content-->
      </div>
      <!--begin::Aside-->

      <!--begin::Body-->
      <div
        class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12"
      >
        <!--begin::Wrapper-->
        <div
          class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10"
        >
          <!--begin::Content-->
          <div
            class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px"
          >
            <!--begin::Wrapper-->
            <div
              class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20"
            >
              <!--begin::Form-->
              
              <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework form-register" novalidate="novalidate" action="{{ route('register') }}" method="POST">
                <!--begin::Heading-->
                <div class="text-center mb-11">
                  <!--begin::Title-->
                  <h1 class="text-gray-900 fw-bolder mb-3">Đăng Ký</h1>
                  <!--end::Title-->

                  <!--begin::Subtitle-->
                  <div class="text-gray-500 fw-semibold fs-6">
                    Chào mừng bạn đã đến với chúng tôi
                  </div>
                  <!--end::Subtitle--->
                </div>
                <!--begin::Heading-->

                <!--begin::Login options-->
                <div class="row g-3 mb-9">
                  <!--begin::Col-->
                  <div class="col-md-12">
                    <!--begin::Google link--->
                    <a
                      href="{{ route('login.google') }}"
                      class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100"
                    >
                      <img
                        alt="Logo"
                        src="/assets/media/svg/brand-logos/google-icon.svg"
                        class="h-15px me-3"
                      />
                    Đăng nhập bằng Google
                    </a>
                    <!--end::Google link--->
                  </div>
                  <!--end::Col-->

                  <!--begin::Col-->
                  
                </div>
                <!--end::Login options-->

                <!--begin::Separator-->
                <div class="separator separator-content my-14">
                  <span class="w-125px text-gray-500 fw-semibold fs-7"
                    >Or email</span
                  >
                </div>
                <!--end::Separator-->
                @include('layouts.include.alert')
                
                @csrf
                <!--begin::Input group--->
                <div class="fv-row mb-8 fv-plugins-icon-container">
                    <!--begin::Email-->
                    <input
                      type="text"
                      placeholder="Tên Tài Khoản"
                      name="username"
                      autocomplete="off"
                      class="form-control bg-transparent"
                    />
                    <!--end::Email-->
                    <div
                      class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                    ></div>
                  </div>

                <div class="fv-row mb-8 fv-plugins-icon-container">
                  <!--begin::Email-->
                  <input
                    type="text"
                    placeholder="Email"
                    name="email"
                    autocomplete="off"
                    class="form-control bg-transparent"
                  />
                  <!--end::Email-->
                  <div
                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                  ></div>
                </div>

                <!--begin::Input group-->
                <div
                  class="fv-row mb-8 fv-plugins-icon-container"
                  data-kt-password-meter="true"
                >
                  <!--begin::Wrapper-->
                  <div class="mb-1">
                    <!--begin::Input wrapper-->
                    <div class="position-relative mb-3">
                      <input class="form-control bg-transparent" type="password"  placeholder="Password" name="password" autocomplete="off"/>
                   
                    </div>
                    <!--end::Input wrapper-->

                    <!--begin::Meter-->
                    <div
                      class="d-flex align-items-center mb-3"
                      data-kt-password-meter-control="highlight"
                    >
                      <div
                        class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"
                      ></div>
                      <div
                        class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"
                      ></div>
                      <div
                        class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"
                      ></div>
                      <div
                        class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"
                      ></div>
                    </div>
                    <!--end::Meter-->
                  </div>
                  <!--end::Wrapper-->

                  <!--begin::Hint-->
                  <div class="text-muted">
                    Sử dụng 6 ký tự trở lên kết hợp chữ cái, số và ký hiệu.
                  </div>
                  <!--end::Hint-->
                  <div
                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                  ></div>
                </div>
                <!--end::Input group--->

                <!--end::Input group--->
                <div class="fv-row mb-8 fv-plugins-icon-container">
                  <!--begin::Repeat Password-->
                  <input
                    type="password"
                    placeholder="Repeat Password"
                    name="password_confirmation"
                    autocomplete="off"
                    class="form-control bg-transparent"
                  />
                  <!--end::Repeat Password-->
                  <div
                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                  ></div>
                </div>
                <!--end::Input group--->

                <!--begin::Accept-->
                <div class="fv-row mb-8 fv-plugins-icon-container">
                  <label class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="agree" id="checkboxNoLabel" aria-label="...">
                    <span
                      class="form-check-label fw-semibold text-gray-700 fs-base ms-1"
                    >
                      Chấp nhận
                      <a href="#" class="ms-1 link-primary">Điều khoản</a>
                    </span>
                  </label>
                  <div
                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                  ></div>
                </div>
                <!--end::Accept-->

                <!--begin::Submit button-->
                <div class="d-grid mb-10">
                  <button
                    type="submit"
                    id="kt_sign_up_submit"
                    class="btn btn-primary"
                  >
                    <!--begin::Indicator label-->
                    <span class="indicator-label"> Đăng Ký</span>
                    <!--end::Indicator label-->

                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">
                      Please wait...
                      <span
                        class="spinner-border spinner-border-sm align-middle ms-2"
                      ></span>
                    </span>
                    <!--end::Indicator progress-->
                  </button>
                </div>
                <!--end::Submit button-->

                <!--begin::Sign up-->
                <div class="text-gray-500 text-center fw-semibold fs-6">
                  Bạn đã có tài khoản?

                  <a
                    href="/login"
                    class="link-primary fw-semibold"
                  >
                    Đăng nhập
                  </a>
                </div>
                <!--end::Sign up-->
              </form>
              <!--end::Form-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Footer-->
           
            <!--end::Footer-->
          </div>
          <!--end::Content-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-up-->
  </div>
  <!--begin::Javascript-->
  <script>
    var hostUrl = "/assets/";
  </script>

  <!--begin::Global Javascript Bundle(mandatory for all pages)-->
  <script src="/assets/plugins/global/plugins.bundle.js"></script>
  <script src="/assets/js/scripts.bundle.js"></script>
  <!--end::Global Javascript Bundle-->

  <!--begin::Custom Javascript(used for this page only)-->
  <script src="/assets/js/custom/authentication/sign-up/general.js"></script>
  <!--end::Custom Javascript-->
  <!--end::Javascript-->

  <svg
    id="SvgjsSvg1001"
    width="2"
    height="0"
    xmlns="http://www.w3.org/2000/svg"
    version="1.1"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    xmlns:svgjs="http://svgjs.dev"
    style="
      overflow: hidden;
      top: -100%;
      left: -100%;
      position: absolute;
      opacity: 0;
    "
  >
    <defs id="SvgjsDefs1002"></defs>
    <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
    <path id="SvgjsPath1004" d="M0 0 "></path>
  </svg>
  <div
    id="lbdictex_ask_mark"
    class="hidden"
    style="position: absolute; top: 0px; left: 0px"
  >
    <a class="lbdictex_ask_select" href="#">&nbsp;</a>
  </div>
</body>

@endsection

@section('scripts')
<script>
    function $formDataToPayload(formData) {
      const payload = {};
      formData.forEach((value, key) => {
        payload[key] = value;
      });
      return payload;
    }

    $(document).ready(function() {
      $(".form-register").submit(async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target),
          action = e.target.action,
          method = e.target.method,
          button = $(e.target).find('button[type="submit"]');
        const payload = $formDataToPayload(formData);

        payload.agree = payload.agree === "on" ? true : false;

        if (payload.agree !== true) {
          $swal("error", "Bạn phải đồng ý với các điều khoản dịch vụ");
          return;
        }

        const loadingSwal = Swal.fire({
    title: 'Đang xử lý...',
    text: 'Vui lòng chờ',
    allowOutsideClick: false,
    showConfirmButton: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

        try {
          const {
            data: result
          } = await axios.post(action, payload);
          const message = result?.message || 'Can\'t not process your request';

          Swal.fire({
            title: '{{ ('Thành công') }}',
            text: result.message,
            icon: 'success',
            showConfirmButton: false,
            timer: 10000,
            allowOutsideClick: false,
          })

          setTimeout(() => {
            window.location.href = result.data.redirect;
          }, 1000);
        } catch (error) {
          const errors = error?.response?.data?.errors || null;

          if (errors !== null) {
            for (const [key, value] of Object.entries(errors)) {
              $(`#${key}`).addClass("is-invalid");
              $(`#${key}-error`).html(value);
            }
          }
          loadingSwal.close();
          Swal.fire({
        title: 'Error',
        text: error.response?.data?.message || 'Có lỗi xảy ra. Vui lòng thử lại.',
        icon: 'error',
        confirmButtonText: 'OK',
      });

        } finally {}
      });
    });
</script>
@endsection