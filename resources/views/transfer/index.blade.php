@php use App\Helpers\Helper; @endphp 
@php use App\Models\ApiLogo; @endphp

@extends('layouts.qr') 
@section('title', $pageTitle) 
@section('content')
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Scan Qr</title>
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap"
        rel="stylesheet"
      />

      <link rel="stylesheet" href="/qr/asset/style_v2.css?v={{ time() }}" />
      <!--NOFICATION MUABANWEBSITE CSS-->
      <link rel="stylesheet" href="/assets/css/style2.css?v={{ time() }}">
      <link rel="stylesheet" href="/assets/css/ant2.css?v={{ time() }}" />

      <!--NOFICATION MUABANWEBSITE JS-->
      <script src="/assets/js/jquery.min.js"></script>
      <script src="/assets/js/vue.global.js?v={{ time() }}"></script>
      <script src="/assets/js/index.full.js?v={{ time() }}"></script>
      <script>

          function showMessage(message, type) {
              ElementPlus.ElNotification({
                  title: "Thông báo",
                  message: message,
                  type: type,
              });
          }
          app.use(ElementPlus);
          app.mount('#kt_body');

        </script>
        <style>
          .layui-m-layer {
    position:relative;
    z-index:19891014;
  }
  .gigs-grid {
      background: #fff;
      box-shadow: 0 4.4px 12px -1px rgb(222 222 222 / 82%);
      border: 1px solid #f8f8f8;
      border-radius: 10px;
      margin-bottom: 24px;
  }
  .layui-m-layer * {
    -webkit-box-sizing:content-box;
    -moz-box-sizing:content-box;
    box-sizing:content-box;
  }

  .layui-m-layermain,
  .layui-m-layershade {
    position:fixed;
    left:0;
    top:0;
    width:100%;
    height:100%;
  }

  .layui-m-layershade {
    background-color:rgba(0,0,0,.7);
    pointer-events:auto;
  }

  .layui-m-layermain {
    display:table;
    font-family:Helvetica,arial,sans-serif;
    pointer-events:none;
  }

  .layui-m-layermain .layui-m-layersection {
    display:table-cell;
    vertical-align:middle;
    text-align:center;
  }

  .layui-m-layerchild {
    position:relative;
    display:inline-block;
    text-align:left;
    background-color:#fff;
    font-size:14px;
    border-radius:5px;
    box-shadow:0 0 8px rgba(0,0,0,.1);
    pointer-events:auto;
    -webkit-overflow-scrolling:touch;
    -webkit-animation-fill-mode:both;
    animation-fill-mode:both;
    -webkit-animation-duration:.2s;
    animation-duration:.2s;
  }

  @-webkit-keyframes layui-m-anim-scale {
    0% {
      opacity:0;
      -webkit-transform:scale(.5);
      transform:scale(.5);
    }
    100% {
      opacity:1;
      -webkit-transform:scale(1);
      transform:scale(1);
    }
  }

  @keyframes layui-m-anim-scale {
    0% {
      opacity:0;
      -webkit-transform:scale(.5);
      transform:scale(.5);
    }
    100% {
      opacity:1;
      -webkit-transform:scale(1);
      transform:scale(1);
    }
  }

  .layui-m-anim-scale {
    animation-name:layui-m-anim-scale;
    -webkit-animation-name:layui-m-anim-scale;
  }

  @-webkit-keyframes layui-m-anim-down {
    0% {
      opacity:0;
      -webkit-transform:translateY(-800px); /* Đưa thông báo từ trên */
      transform:translateY(-800px); /* Đưa thông báo từ trên */
    }
    100% {
      opacity:1;
      -webkit-transform:translateY(0);
      transform:translateY(0);
    }
  }

  @keyframes layui-m-anim-down {
    0% {
      opacity:0;
      -webkit-transform:translateY(-800px); /* Đưa thông báo từ trên */
      transform:translateY(-800px); /* Đưa thông báo từ trên */
    }
    100% {
      opacity:1;
      -webkit-transform:translateY(0);
      transform:translateY(0);
    }
  }

  .layui-m-anim-down {
    animation-name: layui-m-anim-down;
    -webkit-animation-name: layui-m-anim-down;
  }

  .layui-m-layer0 .layui-m-layerchild {
    width:90%;
    max-width:640px;
  }

  .layui-m-layer1 .layui-m-layerchild {
    border:none;
    border-radius:0;
  }

  .layui-m-layer2 .layui-m-layerchild {
    width:auto;
    max-width:260px;
    min-width:40px;
    border:none;
    background:0 0;
    box-shadow:none;
    color:#fff;
  }

  .layui-m-layerchild h3 {
    padding:0 10px;
    height:60px;
    line-height:60px;
    font-size:16px;
    font-weight:400;
    border-radius:5px 5px 0 0;
    text-align:center;
  }

  .layui-m-layerbtn span,
  .layui-m-layerchild h3 {
    text-overflow:ellipsis;
    overflow:hidden;
    white-space:nowrap;
  }

  .layui-m-layercont {
    padding:50px 30px;
    line-height:22px;
    text-align:center;
  }

  .layui-m-layer1 .layui-m-layercont {
    padding:0;
    text-align:left;
  }

  .layui-m-layer2 .layui-m-layercont {
    text-align:center;
    padding:0;
    line-height:0;
  }

  .layui-m-layer2 .layui-m-layercont i {
    width:25px;
    height:25px;
    margin-left:8px;
    display:inline-block;
    background-color:#fff;
    border-radius:100%;
    -webkit-animation:layui-m-anim-loading 1.4s infinite ease-in-out;
    animation:layui-m-anim-loading 1.4s infinite ease-in-out;
    -webkit-animation-fill-mode:both;
    animation-fill-mode:both;
  }

  .layui-m-layerbtn,
  .layui-m-layerbtn span {
    position:relative;
    text-align:center;
    border-radius:0 0 5px 5px;
  }

  .layui-m-layer2 .layui-m-layercont p {
    margin-top:20px;
  }

  @-webkit-keyframes layui-m-anim-loading {
    0%,
    100%,
    80% {
      transform:scale(0);
      -webkit-transform:scale(0);
    }
    40% {
      transform:scale(1);
      -webkit-transform:scale(1);
    }
  }

  @keyframes layui-m-anim-loading {
    0%,
    100%,
    80% {
      transform:scale(0);
      -webkit-transform:scale(0);
    }
    40% {
      transform:scale(1);
      -webkit-transform:scale(1);
    }
  }

  .layui-m-layer2 .layui-m-layercont i:first-child {
    margin-left:0;
    -webkit-animation-delay:-.32s;
    animation-delay:-.32s;
  }

  .layui-m-layer2 .layui-m-layercont i.layui-m-layerload {
    -webkit-animation-delay:-.16s;
    animation-delay:-.16s;
  }

  .layui-m-layer2 .layui-m-layercont>div {
    line-height:22px;
    padding-top:7px;
    margin-bottom:20px;
    font-size:14px;
  }

  .layui-m-layerbtn {
    display:box;
    display:-moz-box;
    display:-webkit-box;
    width:100%;
    height:50px;
    line-height:50px;
    font-size:0;
    border-top:1px solid #D0D0D0;
    background-color:#F2F2F2;
  }

  .layui-m-layerbtn span {
    display:block;
    -moz-box-flex:1;
    box-flex:1;
    -webkit-box-flex:1;
    font-size:14px;
    cursor:pointer;
  }

  .layui-m-layerbtn span[yes] {
    color:#40AFFE;
  }

  .layui-m-layerbtn span[no] {
    border-right:1px solid #D0D0D0;
    border-radius:0 0 0 5px;
  }

  .layui-m-layerbtn span:active {
    background-color:#F6F6F6;
  }

  .layui-m-layerend {
    position:absolute;
    right:7px;
    top:10px;
    width:30px;
    height:30px;
    border:0;
    font-weight:400;
    background:0 0;
    cursor:pointer;
    -webkit-appearance:none;
    font-size:30px;
  }

  .layui-m-layerend::after,
  .layui-m-layerend::before {
    position:absolute;
    left:5px;
    top:15px;
    content:'';
    width:18px;
    height:1px;
    background-color:#999;
    transform:rotate(45deg);
    -webkit-transform:rotate(45deg);
    border-radius:3px;
  }

  .layui-m-layerend::after {
    transform:rotate(-45deg);
    -webkit-transform:rotate(-45deg);
  }

  body .layui-m-layer .layui-m-layer-footer {
    position:fixed;
    width:95%;
    max-width:100%;
    margin:0 auto;
    left:0;
    right:0;
    bottom:10px;
    background:0 0;
  }

  .layui-m-layer-footer .layui-m-layercont {
    padding:20px;
    border-radius:5px 5px 0 0;
    background-color:rgba(255,255,255,.8);
  }

  .layui-m-layer-footer .layui-m-layerbtn {
    display:block;
    height:auto;
    background:0 0;
    border-top:none;
  }

  .layui-m-layer-footer .layui-m-layerbtn span {
    background-color:rgba(255,255,255,.8);
  }

  .layui-m-layer-footer .layui-m-layerbtn span[no] {
    color:#FD482C;
    border-top:1px solid #c2c2c2;
    border-radius:0 0 5px 5px;
  }

  .layui-m-layer-footer .layui-m-layerbtn span[yes] {
    margin-top:10px;
    border-radius:5px;
  }

  body .layui-m-layer .layui-m-layer-msg {
    width:auto;
    max-width:90%;
    margin:0 auto;
    bottom:250px;
    background-color:rgba(0,0,0,.7);
    color:#fff;
  }

  .layui-m-layer-msg .layui-m-layercont {
    padding:10px 20px;
  }

          </style>
    </head>
    <body>
      <section class="scan-payment">
        <div class="scan-payment-inner">
          <div class="scan-payment-info">
            <div class="timeout">
              <p>Đơn hàng sẽ hết hạn sau</p>
              <strong id="expiredAt">06:00</strong>
            </div>
            <div class="info">
              <h5 class="info-title">Thông tin thanh toán</h5>
              <div class="info-bank">
                <div class="info-bank-header">

                  <p class="name">Ngân hàng: {{ $bank->name }}</p>
                  <p class="thumbnail">
                    <img src="{{ ApiLogo::GetApiBank($bank->name, 'shortName', 'logo') }}" alt="bank" />
                  </p>
                </div>
                <div class="info-bank-body">
                  <div class="item">
                    <p class="title">Chủ tài khoản:</p>
                    <p class="value"><strong>{{ $bank->owner }}</strong></p>
                  </div>
                  <div class="item">
                    <p class="title">Số tài khoản:</p>
                    <p class="value">
                      <strong id='copy_stk' data-text='{{ $bank->number }}'>{{ $bank->number }}</strong
                      ><span onclick="copyText('copy_stk')"
                        ><img src="/qr/asset/images/copy.svg" alt="copy" /> Sao
                        chép</span
                      >
                    </p>
                  </div>
                  <div class="item">
                    <p class="title">Số tiền:</p>
                    <p class="value">
                      <strong id='copy_amount' data-text='{{ $transfer->price }}'>{{ number_format($transfer->price) }}đ</strong>
                      <span onclick="copyText('copy_amount')"
                        ><img src="/qr/asset/images/copy.svg" alt="copy" /> Sao
                        chép</span
                      >
                    </p>
                  </div>
                  <div class="item">
                    <p class="title">Nội dung đơn hàng:</p>
                    <p class="value">
                      <strong id='copy_memo' data-text='{{ $transfer->noidung }}'>{{ $transfer->noidung }}</strong>
                      <span onclick="copyText('copy_memo')"
                        ><img src="/qr/asset/images/copy.svg" alt="copy" /> Sao
                        chép</span
                      >
                    </p>
                  </div>
                </div>
                <div class="info-bank-footer">
                  <p>
                    <img
                      src="/qr/asset/images/info-circle.svg"
                      alt="info-circle"
                    />Nhập chính xác nội dung chuyển tiền:
                    <strong>{{ $transfer->noidung }}</strong>
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="scan-payment-qr">
            <h5 class="title">Chuyển khoản hoặc mở App để quét mã thanh toán</h5>
            <div class="thumbnail">
              <div class="thumbnail-border">
                <img src="/qr/asset/images/border-qr.svg" alt="border" />
                <img src="/qr/asset/images/border-qr.svg" alt="border" />
                <img src="/qr/asset/images/border-qr.svg" alt="border" />
                <img src="/qr/asset/images/border-qr.svg" alt="border" />
              </div>
              <div class="thumbnail-qr">

              @if ($bank->name == 'Thesieure')
                <img class="qr-code" src="{{ setting('thesieure_qr') ?: asset('assets/media/payments/border-qrcode.svg') }}">

              @elseif ($bank->name == 'MOMOPAY')
                <img class="qr-code"
                  src="https://img.vietqr.io/image/momo-{{ $bank->number }}-compact.jpg?amount={{ $transfer->price }}&addInfo={{ urlencode($transfer->noidung) }}">

              @else
                <img class="qr-code"
                  src="https://qr.sepay.vn/img?bank={{ $bank->name }}&acc={{ $bank->number }}&template=compact&amount={{ $transfer->price }}&des={{ $transfer->noidung }}">
              @endif
                <img
                  src="/qr/asset/images/scanner.svg"
                  alt="Scanner"
                  class="scanner"
                />
              </div>
            </div>
            <p class="desc">
              <img src="/qr/asset/images/scan.svg" alt="scan" />Sử dụng
              <strong> app ngân hàng</strong>
              để quét mã
            </p>
            <!--<button>-->
            <!--  <img src="/qr/asset/images/download.svg" alt="scan" />Tải QR code-->
            <!--</button>-->
            <p class="note">
              <span
                >Sau khi chuyển tiền, Quý khách vui lòng không tắt trình duyệt cho
                đến khi xác nhận thành công!</span
              >
            </p>
            <div class="loading">
              <div class="spinner"></div>
              <p id="status_payment">Đang chờ bạn quét...</p>
            </div>
          </div>
        </div>
        <a href="ccc" class="scan-payment-cancel">Huỷ giao dịch</a>
      </section>

          <!-- Javascript files-->
          <script src="/assets/js/layesr.js"></script>
          <script src="/qr/asset/jquery.min.js"></script>
          <script src="/qr/asset/tether.min.js"></script>
          <script src="/qr/asset/bootstrap.min.js"></script>
          <script type="text/javascript" src="/qr/asset/momo.js"></script>
          <script src="/qr/asset/jquery.lazyload.min.js"></script>
          <link rel='stylesheet' href='https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css'>
          <script src='https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js'></script>
          <script>
            window.onload = function() {

                var loadingLayer = layer.open({
                    type: 2,
                    content: '<div>Đang tải...</div>',
                    shade: [0.7, '#000'],
                    shadeClose: false, 
                    time: 0 
                });

                setTimeout(function() {
                    layer.close(loadingLayer);
                }, 4000);
            };
        </script>
        <script type="text/javascript">
          function getStatusInvoice() {
              $.ajax({
                  url: "/transfer/transfer-status",
                  type: "GET",
                  dataType: "JSON",
                  data: {
                      id: "{{ $transfer->id }}"
                  },
                  success: function(result) {
                      if (result.status == "2") {
                        swal({
                          title: "Thông Báo",
                          text: "Bạn đã thực hiện thanh toán thành công!",
                          type: "success",
                          showCloseButton: true,
                          focusConfirm: false,
                      });
                         setTimeout(function() {
                     location.href = '{{ route('transfer.view') }}';
                    }, 1000);

                      }
                      $('#status_payment').html(result.message);
                  }
              });
          }
          setInterval(function() {
              $('#status_payment').load(getStatusInvoice());
          }, 5000);
       </script>
        <script type="text/javascript">
          var retry = parseInt(300.0);
          var offset = 360000;
          var second = offset / 1000;
          var countdown = parseInt(second);

          var timeoutInterval = setInterval(function() {
              if (countdown > 0) {
                  var m = parseInt(second / 60);
                  var s = parseInt(second - m * 60);
                  second--;
                  countdown--;
                  if (m < 10) {
                      m = "0" + m;
                  }
                  if (s < 10) {
                      s = "0" + s;
                  }
                  if ((s == 1) && (m == 0)) {

                      var id = '{{ $transfer->id }}'; // Thay thế bằng giá trị id thích hợp                 
                      var data = {
                          id: id,
                          status: 3,                     
                      };

                      $.ajax({
                          url: '/transfer/transfer-status',
                          type: 'POST',
                          headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          },
                          data: data,
                          success: function(response) {
                            swal({
                          title: "Thanh toán không thành công!",
                          text: "Vui lòng thanh toán lại hoặc liên hệ với Quản trị viên!",
                          type: "error",
                          showCloseButton: true,
                          focusConfirm: false,
                      });
                              window.location = '{{ route('transfer.view') }}';
                          },
                          error: function(xhr, status, error) {
                              console.log('Có lỗi xảy ra khi gửi dữ liệu');
                          }
                      });
                  }
                  $("#expiredAt").html(m + ":" + s);
              };
          }, 1000);

          function redirect(data) {
              if (data.return_url) {
                  window.location.replace(data.return_url);
              } else if (data.returnUrl) {
                  window.location.replace(data.returnUrl);
              }
          }

          function executeXML() {
              var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      // Typical action to be performed when the document is ready:
                      var data = JSON.parse(xhttp.responseText);
                      if (data.code == '400') {
                          setTimeout(executeXML, 2000);
                          retry--;
                      } else if (data.code == '200') {
                          window.location = '';
                      }
                  }
              };
              xhttp.open("POST", '' + '&_=' + new Date().getTime(), true);
              xhttp.send();
          }

          $(document).ready(function() {
              $.ajaxSetup({
                  cache: false
              });
              setTimeout(executeXML, 2000);
          });

          $("#signUp").click(function(e) {
              fbTrack(EV.CLICK_SIGN_UP_ON_QR_PAGE, pCode, requestId);
          });
          $("#cancelOrder").click(function(e) {
              fbTrack(EV.CANCEL_ORDER_ON_QR_PAGE, pCode, requestId);
          });
          $("#login").click(function(e) {
              fbTrack(EV.CLICK_LOGIN_ON_QR_PAGE, pCode, requestId);
          });
          window.addEventListener("beforeunload", function(e) {
              try {
                  fbTrack(EV.CLICK_CLOSE_BROWSER_QR_PAGE, pCode, requestId);
              } catch (e) {
                  console.log(e);
              } //Webkit, Safari, Chrome
          });

          function copyText(element) {
              var element = document.getElementById(element);

              // Get the text from the custom attribute
              var textToCopy = element.getAttribute('data-text');
              navigator.clipboard.writeText(textToCopy).then(function() {
                  // Success feedback
                  showMessage("Copied the text: " + textToCopy, 'success');
              })
          }
      </script>

  </body>
  </html>
@endsection
@section('scripts')

@endsection
