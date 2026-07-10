<head>

  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title') - MuaBanWebsite Admin Panel</title>
  <meta name="Description" content="Admin Control Panel">
  <meta name="Author" content="quocbaodev">
  <meta name="keywords" content="Admin Control Panel">

  <!-- Favicon -->
  <link rel="icon" href="{{ setting_asset('favicon') }}" type="image/x-icon">

  <!-- Choices JS -->
  <script src="/_assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

  <!-- Main Theme Js -->
  <script src="/_assets/js/main.js"></script>

  <!-- Bootstrap Css -->
  <link id="style" href="/_assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Style Css -->
  <link href="/_assets/css/styles.min.css" rel="stylesheet">

  <!-- Icons Css -->
  <link href="/_assets/css/icons.css" rel="stylesheet">

  <link rel="stylesheet" href="/_assets/libs/flatpickr/flatpickr.min.css">

  <!-- Node Waves Css -->
  <link href="/_assets/libs/node-waves/waves.min.css" rel="stylesheet">

  <!-- Simplebar Css -->
  <link href="/_assets/libs/simplebar/simplebar.min.css" rel="stylesheet">

  <!-- Color Picker Css -->
  <link rel="stylesheet" href="/_assets/libs/flatpickr/flatpickr.min.css">
  <link rel="stylesheet" href="/_assets/libs/@simonwep/pickr/themes/nano.min.css">

  <!-- Choices Css -->
  <link rel="stylesheet" href="/_assets/libs/choices.js/public/assets/styles/choices.min.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Extra Plugin -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.27/sweetalert2.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/lelinh014756/fui-toast-js@master/assets/css/toast@1.0.1/fuiToast.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <!-- CoreJS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  @php
    /** @var \App\Models\User|null $user */
    $user = auth()->user();
  @endphp
  <script>
    window.webData = @json([
      'csrfToken' => csrf_token(),
    ]);
    window.userData = @json($user);
    window.access_token = @json($user?->access_token ?? '');

    // Polyfill for missing custom functions
    window.$catchMessage = function(error) {
      if (error && error.response && error.response.data && error.response.data.message) {
        return error.response.data.message;
      }
      return error?.message || "Đã có lỗi xảy ra, vui lòng thử lại.";
    };
    window.$setLoading = function(element) {
      if (element) { $(element).prop('disabled', true).addClass('loading'); }
    };
    window.$removeLoading = function(element) {
      if (element) { $(element).prop('disabled', false).removeClass('loading'); }
    };
    window.$showLoading = function() {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Đang xử lý',
          html: 'Vui lòng chờ...',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });
      }
    };
    window.$truncate = function(data, length) {
      return (data && data.length > length) ? data.substring(0, length) + '...' : (data || '');
    };

    // Setup Axios CSRF Token automatically when Axios loads
    document.addEventListener("DOMContentLoaded", function() {
      if (typeof axios !== 'undefined') {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = window.webData.csrfToken;
      }
    });
  </script>

  <style>
    * {
      font-family: 'Archivo', sans-serif;
    }
  </style>
  @yield('css')
  @yield('styles')

</head>