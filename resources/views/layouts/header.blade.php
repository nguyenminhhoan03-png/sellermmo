@php use App\Helpers\Helper; @endphp
@php
  $seoTitle = setting('title') ?: config('app.name', 'MuaBanWebsite');
  $seoDescription = setting('description') ?: 'Mua bán mã nguồn, website, tài khoản AI, domain và hosting uy tín.';
  $seoKeywords = setting('keywords') ?: 'muabanwebsite, mã nguồn, website, domain, hosting, tài khoản ai';
@endphp
<!DOCTYPE html>
<html lang="vi" >
    <!--begin::Head-->
    <head>
        @hasSection('postTitle')
    <title>@yield('postTitle')</title>
  @endif
  @hasSection('title')
    <title>@yield('title') - {{ $seoTitle }}</title>
  @else
    @hasSection('pageTitle')
      <title>@yield('pageTitle')</title>
    @else
      <title>{{ $seoTitle }}</title>
    @endif
  @endif
        <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  @hasSection('description')
    <meta name="description" content="@yield('description')">
  @else
    <meta name="description" content="{{ $seoDescription }}">
  @endif
  @hasSection('keywords')
    <meta name="keywords" content="@yield('keywords')">
  @else
    <meta name="keywords" content="{{ $seoKeywords }}">
  @endif
  <meta name="author" content="{{ setting('author') ?: 'MuaBanWebsite' }}">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <meta name="googlebot" content="index, follow, max-image-preview:large">
  <meta name="google" content="notranslate">
  <meta name="generator" content="{{ strtoupper($_SERVER['HTTP_HOST']) }}">

  <meta name="application-name" content="{{ $seoTitle }}">
  <meta property="og:image" content="{{ setting_asset('favicon') }}">
  <meta property="og:image:secure_url" content="{{ setting_asset('favicon') }}">
  <meta property="og:image:width" content="128">
  <meta property="og:image:height" content="128">
  <meta property="og:image:alt" content="{{ $seoTitle }}">
  <meta property="og:title" content="{{ $seoTitle }}">
  <meta property="og:site_name" content="{{ $seoTitle }}">
  <meta property="og:description" content="{{ $seoDescription }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:type" content="website">
  <link rel="canonical" href="{{ url()->current() }}">

  <link rel="shortcut icon" href="{{ setting_asset('favicon') }}" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/> 
  <noscript>
    <meta http-equiv="refresh" content="0;url=nojs">
  </noscript>  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
   <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" href="/assets/css/uikit.css?v={{ filemtime(public_path('assets/css/uikit.css')) }}">
   <link rel="stylesheet" href="/assets/plugins/custom/prismjs/prismjs.bundle.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

   @stack('head-styles')

                            <!--NOFICATION MUABANWEBSITE CSS-->
                            <link rel="stylesheet" href="/assets/css/style2.css?v={{ filemtime(public_path('assets/css/style2.css')) }}">
                            <link rel="stylesheet" href="/assets/css/ant2.css?v={{ filemtime(public_path('assets/css/ant2.css')) }}" />

                            <!--NOFICATION MUABANWEBSITE JS-->
                            <script src="/assets/js/jquery.min.js" defer></script>
                            <script src="/assets/js/vue.global.js?v={{ filemtime(public_path('assets/js/vue.global.js')) }}" defer></script>
                            <script src="/assets/js/index.full.js?v={{ filemtime(public_path('assets/js/index.full.js')) }}" defer></script>

                            @stack('head-scripts')

<script async src="https://www.googletagmanager.com/gtag/js?id=G-52YZ3XGZJ6"></script>
<script>
  if (window.moment) {
    moment.locale('vi');
  }

  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);} 
  gtag('js', new Date());
  gtag('config', 'G-52YZ3XGZJ6');

  window.$swal = window.$swal || ((icon, text) => {
    return Swal.fire({
      icon: icon,
      title: icon === "error" ? "Oops..." : "Thông Báo",
      text: text,
    });
  });

  window.$showLoading = window.$showLoading || (() => {
    return Swal.fire({
      title: 'Đang xử lý!',
      text: 'Không được tắt trang này, vui lòng đợi trong giây lát!',
      allowOutsideClick: false,
      showConfirmButton: false,
      didOpen: () => { Swal.showLoading(); }
    });
  });

  window.showMessage = window.showMessage || function(message, type) {
    if (window.ElementPlus) {
      ElementPlus.ElNotification({
        title: 'Thông báo',
        message: message,
        type: type,
      });
    } else {
      console[type === 'error' ? 'error' : 'log'](message);
    }
  };

  window.__lazyScriptQueue = window.__lazyScriptQueue || [];
  window.__runLazyScripts = window.__runLazyScripts || function () {
    while (window.__lazyScriptQueue.length) {
      try {
        window.__lazyScriptQueue.shift()();
      } catch (e) {
        console.error(e);
      }
    }
  };

  if (window.top != window.self) {
    window.top.location.replace(window.self.location.href);
  }
</script>
{!! base64_decode(Helper::getNotice('header_script')) !!}
    </head>
    