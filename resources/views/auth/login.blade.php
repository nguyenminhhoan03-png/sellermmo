@extends('layouts.auth')
@section('title', ('Đăng Nhập Vào Hệ Thống'))
@section('content')
<body
  id="kt_body"
  class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat"
>
  <!--begin::Theme mode setup on page load-->
  <script>
    var defaultThemeMode = "light";
    var themeMode = localStorage.getItem("data-bs-theme") || defaultThemeMode;

    if (themeMode === "system") {
      themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    }

    document.documentElement.setAttribute("data-bs-theme", themeMode);
  </script>
  <!--end::Theme mode setup on page load-->

  <!--begin::Root-->
  <div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>
      body {
        @php $authBg = theme_settings('auth_bg', ''); @endphp
        {{ $authBg ? "background-image: url(\"$authBg\");" : 'background: linear-gradient(135deg, #1d3557 0%, #457b9d 50%, #e63946 100%);' }}
        background-size: cover;
        background-position: center;
      }

      [data-bs-theme="dark"] body {
        {{ $authBg ? "background-image: url(\"$authBg\");" : 'background: linear-gradient(135deg, #0d1b2a 0%, #1b2a41 50%, #6b1e2c 100%);' }}
        background-size: cover;
        background-position: center;
      }
    </style>
    <!--end::Page bg image-->

    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
      <!--begin::Aside-->
      <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
        <div class="d-flex flex-center flex-lg-start flex-column">
          <a href="/" class="mb-7">
            <img alt="Logo" class="h-60px" src="{{ setting_asset('logo_light') }}" />
          </a>
          <h2 class="text-white fw-normal m-0">
          Khám phá thế giới sáng tạo với mã nguồn chất lượng!
          </h2>
        </div>
      </div>
      <!--end::Aside-->

      <!--begin::Body-->
      <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
        <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
          <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
            <div class="text-center mb-11">
              <h1 class="text-gray-900 fw-bolder mb-3">Đăng Nhập</h1>
              <div class="text-gray-500 fw-semibold fs-6">
                Chào mừng bạn đến với dịch vụ của chúng tôi
              </div>
            </div>
            <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework form-login" id="kt_sign_in_form" novalidate="novalidate" action="{{ route('login') }}" method="POST">
            <div class="row g-3 mb-9">
              <div class="col-md-12">
                <a href="{{ route('login.google') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                  <img alt="Logo" src="/assets/media/svg/brand-logos/google-icon.svg" class="h-15px me-3" />
                  Đăng nhập với Google
                </a>
              </div>
            </div>

            <div class="separator separator-content my-14">
              <span class="w-125px text-gray-500 fw-semibold fs-7">Login Or</span>
            </div>
              @csrf
              <div class="fv-row mb-8">
                <input type="text" placeholder="Tên tài khoản hoặc email" name="username" autofocus class="form-control bg-transparent" required />
              </div>

              <div class="fv-row mb-3">
                <input type="password" placeholder="Mật khẩu" name="password" id="password" autocomplete="off" class="form-control bg-transparent" required />
              </div>

              <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <a href="/resetpassword" class="link-primary">Quên mật khẩu?</a>
              </div>

              <div class="d-grid mb-5">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                  <span class="indicator-label">Đăng Nhập</span>
                </button>
              </div>
              <div class="d-grid mb-10">
                <button type="button" class="btn btn-info" onclick="demoSite();">Xem Thử Ngay
                  <span class="text-light xfw-bold fs-7 pb-0 pt-0">(Không Cần Đăng Kí Tài Khoản)</span>
                  </button>
              </div>

              <div class="text-gray-500 text-center fw-semibold fs-6">
                Bạn chưa có tài khoản?
                <a href="/register" class="link-primary">Đăng ký</a>
              </div>
            </form>
          </div>

       
        </div>
      </div>
    </div>
  </div>
  <script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordField = document.getElementById('password');
        var eyeIcon = this.querySelector('.bi-eye');
        var eyeSlashIcon = this.querySelector('.bi-eye-slash');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('d-none');
            eyeSlashIcon.classList.add('d-none');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.add('d-none');
            eyeSlashIcon.classList.remove('d-none');
        }
    });
</script>
  <script>
    const demoSite = () => {
    let countdown = 3;

    Swal.fire({
        icon: "info",
        title: "Thông Báo",
        text: "Bạn chỉ có thể xem dịch vụ và giá hệ thống, không thể thao tác mua bán và giao dịch trên tài khoản trải nghiệm",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: `Tôi đồng ý (${countdown}s)`,
        denyButtonText: `Bỏ qua`,
        didOpen: () => {
            const confirmButton = Swal.getConfirmButton();
            confirmButton.disabled = true;

            const interval = setInterval(() => {
                countdown -= 1;
                confirmButton.innerText = `Tôi đồng ý (${countdown}s)`;

                if (countdown === 0) {
                    clearInterval(interval);
                    confirmButton.innerText = "Tôi đồng ý";
                    confirmButton.disabled = false;
                }
            }, 1000);
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/demo-login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ demo: true })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/';
                } else {
                    Swal.fire('Lỗi', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Lỗi', 'Đã có lỗi xảy ra!', 'error');
            });
        }
    });
}
    var hostUrl = "/assets/";
  </script>
  <script src="/assets/plugins/global/plugins.bundle.js"></script>
  <script src="/assets/js/scripts.bundle.js?v={{ time() }}"></script>
  <script src="/assets/js/custom/authentication/sign-in/general.js?v={{ time() }}"></script>
@endsection

