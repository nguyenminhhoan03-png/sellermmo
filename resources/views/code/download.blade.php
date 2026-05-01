@extends('layouts.app')
@section('title', 'Tải xuống – ' . $product->name)
@section('content')
<style>
/* ═══ WRAPPER ═══ */
.dl-page {
  min-height: 70vh;
  display: flex; align-items: center; justify-content: center;
  padding: 40px 16px;
}
.dl-box {
  background: #fff;
  border-radius: 24px;
  border: 1px solid #edf1f5;
  box-shadow: 0 8px 40px rgba(0,0,0,.1);
  padding: 40px 36px;
  max-width: 520px;
  width: 100%;
  text-align: center;
}
@media(max-width:576px){ .dl-box{ padding: 28px 20px; } }

/* Product thumb */
.dl-product-img {
  width: 80px; height: 80px; border-radius: 16px;
  object-fit: cover; margin: 0 auto 16px;
  border: 1px solid #edf1f5;
  box-shadow: 0 2px 10px rgba(0,0,0,.08);
}
.dl-product-img-placeholder {
  width: 80px; height: 80px; border-radius: 16px;
  background: linear-gradient(135deg,#f0f0ff,#e0d4ff);
  display: flex; align-items: center; justify-content: center;
  font-size: 2.2rem; margin: 0 auto 16px;
}
.dl-product-name {
  font-size: 1.15rem; font-weight: 800; color: #1e1e2d;
  margin-bottom: 6px; line-height: 1.35;
}
.dl-product-back {
  font-size: .8rem; color: #a1a5b7; text-decoration: none;
  display: inline-block; margin-bottom: 24px;
}
.dl-product-back:hover { color: #e94560; }

/* ═══ STEPS ═══ */
.dl-steps {
  display: flex; align-items: center; justify-content: center;
  gap: 0; margin-bottom: 28px;
}
.dl-step {
  display: flex; flex-direction: column; align-items: center;
  gap: 5px; flex: 1;
}
.dl-step-circle {
  width: 36px; height: 36px; border-radius: 50%;
  background: #f0f0f0; color: #a1a5b7;
  display: flex; align-items: center; justify-content: center;
  font-size: .85rem; font-weight: 700;
  transition: all .3s;
}
.dl-step.done .dl-step-circle   { background: #e8f9f4; color: #17a589; }
.dl-step.active .dl-step-circle { background: #e94560; color: #fff; box-shadow: 0 3px 12px rgba(233,69,96,.35); }
.dl-step-label { font-size: .7rem; color: #a1a5b7; font-weight: 600; }
.dl-step.active .dl-step-label { color: #e94560; }
.dl-step.done .dl-step-label   { color: #17a589; }
.dl-step-line {
  flex: 0 0 32px; height: 2px;
  background: #edf1f5; margin-bottom: 18px;
  transition: background .5s;
}
.dl-step-line.filled { background: #17a589; }

/* ═══ COUNTDOWN ═══ */
.dl-timer-wrap { margin-bottom: 24px; }
.dl-timer-circle {
  width: 90px; height: 90px; border-radius: 50%;
  border: 4px solid #edf1f5; margin: 0 auto 10px;
  display: flex; align-items: center; justify-content: center;
  position: relative;
}
.dl-timer-circle svg {
  position: absolute; top: -4px; left: -4px;
  width: 98px; height: 98px; transform: rotate(-90deg);
}
.dl-timer-circle svg circle {
  fill: none; stroke: #e94560; stroke-width: 4;
  stroke-dasharray: 283; stroke-dashoffset: 283;
  stroke-linecap: round; transition: stroke-dashoffset .9s linear;
}
.dl-timer-num { font-size: 1.8rem; font-weight: 800; color: #1e1e2d; position: relative; z-index: 1; }
.dl-timer-label { font-size: .8rem; color: #a1a5b7; }

/* ═══ AD NOTICE ═══ */
.dl-ad-notice {
  background: #fff9e6; border: 1px solid #ffe4a0; border-radius: 12px;
  padding: 10px 14px; font-size: .8rem; color: #856404;
  margin-bottom: 20px; text-align: left;
}

/* ═══ BUTTONS ═══ */
.btn-dl-linkvertise {
  display: inline-flex; align-items: center; justify-content: center; gap: 10px;
  width: 100%; padding: 15px 24px;
  background: linear-gradient(135deg, #e94560, #c73652);
  color: #fff; font-size: 1rem; font-weight: 800;
  border-radius: 14px; border: none; text-decoration: none;
  box-shadow: 0 6px 20px rgba(233,69,96,.35);
  transition: transform .15s, box-shadow .15s;
  cursor: pointer;
}
.btn-dl-linkvertise:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(233,69,96,.45); color:#fff; }
.btn-dl-linkvertise.disabled {
  background: #e4e6ef; color: #a1a5b7;
  box-shadow: none; pointer-events: none;
}
.btn-dl-direct {
  display: inline-flex; align-items: center; justify-content: center; gap: 8px;
  width: 100%; padding: 12px 24px; margin-top: 10px;
  background: #f5f5f5; color: #1e1e2d; font-size: .9rem; font-weight: 700;
  border-radius: 12px; border: 1px solid #edf1f5; text-decoration: none;
  transition: background .15s;
}
.btn-dl-direct:hover { background: #edf1f5; color: #1e1e2d; }

/* ═══ WARN ═══ */
.dl-warn {
  font-size: .75rem; color: #a1a5b7; margin-top: 16px; line-height: 1.6;
}
</style>

{{-- ══ ADSTERRA: POPUNDER (kích hoạt ngay khi vào trang) ══ --}}
<script src="https://pl29185068.profitablecpmratenetwork.com/55/e8/26/55e826ce1e422334693b249b9893e1d8.js"></script>

{{-- ══ LINKVERTISE: Full Script API – tự động wrap tất cả external link ══ --}}
<script src="https://publisher.linkvertise.com/cdn/linkvertise.js"></script>
<script>linkvertise(5174388, {whitelist: [], blacklist: [""]});</script>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
  <div class="content flex-row-fluid" id="kt_content">

    {{-- ══ BANNER 468x60 (top) ══ --}}
    <div style="display:flex;justify-content:center;margin:12px 0;">
      <script>
        atOptions = {
          'key' : '8e0590ae1d91be1338da3dd5ae92fa30',
          'format' : 'iframe',
          'height' : 60,
          'width' : 468,
          'params' : {}
        };
      </script>
      <script src="https://www.highperformanceformat.com/8e0590ae1d91be1338da3dd5ae92fa30/invoke.js"></script>
    </div>

    <div class="dl-page">
      {{-- ══ BANNER 160x300 (sidebar trái) ══ --}}
      <div class="d-none d-xl-flex flex-column align-items-center justify-content-center" style="margin-right:24px;">
        <script>
          atOptions = {
            'key' : 'ac112409fa4da9e86592a0fd8b02de40',
            'format' : 'iframe',
            'height' : 300,
            'width' : 160,
            'params' : {}
          };
        </script>
        <script src="https://www.highperformanceformat.com/ac112409fa4da9e86592a0fd8b02de40/invoke.js"></script>
      </div>

      <div class="dl-box">

        {{-- Product thumb + name --}}
        @if($product->images)
          <img src="{{ $product->images }}" class="dl-product-img" alt="{{ $product->name }}">
        @else
          <div class="dl-product-img-placeholder">💻</div>
        @endif

        <div class="dl-product-name">{{ $product->name }}</div>
        <a href="{{ route('code.index', $productSlug) }}" class="dl-product-back">← Quay lại trang sản phẩm</a>

        {{-- Steps --}}
        <div class="dl-steps">
          <div class="dl-step done" id="step1">
            <div class="dl-step-circle">✓</div>
            <div class="dl-step-label">Xác nhận</div>
          </div>
          <div class="dl-step-line" id="line1"></div>
          <div class="dl-step active" id="step2">
            <div class="dl-step-circle">2</div>
            <div class="dl-step-label">Chờ đợi</div>
          </div>
          <div class="dl-step-line" id="line2"></div>
          <div class="dl-step" id="step3">
            <div class="dl-step-circle">3</div>
            <div class="dl-step-label">Tải xuống</div>
          </div>
        </div>

        {{-- Countdown --}}
        <div class="dl-timer-wrap" id="timer-wrap">
          <div class="dl-timer-circle">
            <svg viewBox="0 0 98 98">
              <circle cx="49" cy="49" r="45" id="timer-ring"/>
            </svg>
            <span class="dl-timer-num" id="timer-num">15</span>
          </div>
          <div class="dl-timer-label">giây để tải xuống</div>
        </div>

        {{-- Ad notice --}}
        <div class="dl-ad-notice">
          ⚠️ Trang có thể mở thêm 1 tab quảng cáo để duy trì dịch vụ miễn phí. Vui lòng không tắt ngay.
        </div>

        {{-- Buttons (ẩn, hiện sau countdown) --}}
        <div id="btn-group" class="d-none">
          {{-- Linkvertise Full Script tự wrap link này thành bypass page --}}
          <a
            href="{{ $realLink }}"
            class="btn-dl-linkvertise"
            id="btn-linkvertise"
            target="_blank"
            rel="noopener"
          >
            <span style="font-size:1.3rem;">⬇️</span>
            Tải xuống ngay
          </a>

          {{-- Hướng dẫn bypass Linkvertise --}}
          <div style="background:#fff9e6;border:1px solid #ffe4a0;border-radius:14px;padding:14px 16px;margin:14px 0;text-align:left;">
            <div style="font-weight:800;font-size:.88rem;color:#856404;margin-bottom:10px;">📋 Hướng dẫn lấy link tải (3 bước)</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
              <div style="display:flex;align-items:flex-start;gap:10px;font-size:.82rem;color:#5e6278;">
                <span style="background:#e94560;color:#fff;border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.72rem;flex-shrink:0;">1</span>
                <span>Trang Linkvertise mở ra → có popup "<strong>Complete your order</strong>" hiện lên → bấm <strong style="color:#e94560;">X</strong> để đóng popup đó lại</span>
              </div>
              <div style="display:flex;align-items:flex-start;gap:10px;font-size:.82rem;color:#5e6278;">
                <span style="background:#e94560;color:#fff;border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.72rem;flex-shrink:0;">2</span>
                <span>Chọn <strong style="color:#17a589;">"Watch Ads"</strong> (xem quảng cáo ~3 phút, hoàn toàn miễn phí) → <strong>KHÔNG</strong> chọn "1 Month" hay "1 Year" vì phải trả tiền</span>
              </div>
              <div style="display:flex;align-items:flex-start;gap:10px;font-size:.82rem;color:#5e6278;">
                <span style="background:#e94560;color:#fff;border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.72rem;flex-shrink:0;">3</span>
                <span>Xem xong quảng cáo → bấm <strong>"Get Link"</strong> → nhận link tải về máy</span>
              </div>
            </div>
            <div style="margin-top:10px;padding-top:10px;border-top:1px dashed #ffe4a0;font-size:.75rem;color:#a1a5b7;">
              💡 Nếu không muốn xem quảng cáo → dùng nút <strong>"Hoặc tải thẳng"</strong> bên dưới sau vài giây
            </div>
          </div>

          {{-- ══ BANNER 320x50 (dưới nút tải) ══ --}}
          <div style="display:flex;justify-content:center;margin:14px 0 6px;">
            <script>
              atOptions = {
                'key' : '77553296a9cb444cb2448a8cf820b909',
                'format' : 'iframe',
                'height' : 50,
                'width' : 320,
                'params' : {}
              };
            </script>
            <script src="https://www.highperformanceformat.com/77553296a9cb444cb2448a8cf820b909/invoke.js"></script>
          </div>

          {{-- Nút tải thẳng (backup, hiện sau 8 giây bấm Linkvertise) --}}
          <a href="{{ $realLink }}" class="btn-dl-direct d-none" id="btn-direct" target="_blank" rel="noopener">
            🔗 Hoặc tải thẳng (không qua quảng cáo)
          </a>

          <p class="dl-warn">
            Bằng cách tải xuống bạn đồng ý với <a href="#">điều khoản sử dụng</a>.<br>
            Link tải được mã hóa – chỉ dùng 1 lần, không chia sẻ.
          </p>
        </div>

        {{-- Skeleton placeholder trong lúc đếm --}}
        <div id="btn-placeholder">
          <div class="btn-dl-linkvertise disabled">
            <span style="font-size:1.3rem;">⏳</span>
            Đang chuẩn bị link tải...
          </div>
        </div>

      </div>{{-- /.dl-box --}}

      {{-- ══ BANNER 160x300 (sidebar phải, mobile ẩn) ══ --}}
      <div class="d-none d-xl-flex flex-column align-items-center justify-content-center" style="margin-left:24px;">
        <script>
          atOptions = {
            'key' : 'ac112409fa4da9e86592a0fd8b02de40',
            'format' : 'iframe',
            'height' : 300,
            'width' : 160,
            'params' : {}
          };
        </script>
        <script src="https://www.highperformanceformat.com/ac112409fa4da9e86592a0fd8b02de40/invoke.js"></script>
      </div>

    </div>{{-- /.dl-page --}}

    {{-- ══ BANNER 468x60 (bottom) ══ --}}
    <div style="display:flex;justify-content:center;margin:12px 0 24px;">
      <script>
        atOptions = {
          'key' : '8e0590ae1d91be1338da3dd5ae92fa30',
          'format' : 'iframe',
          'height' : 60,
          'width' : 468,
          'params' : {}
        };
      </script>
      <script src="https://www.highperformanceformat.com/8e0590ae1d91be1338da3dd5ae92fa30/invoke.js"></script>
    </div>

  </div>
</div>

@endsection
@section('scripts')
<script>
(function () {
  var TOTAL    = 15;
  var current  = TOTAL;
  var ring     = document.getElementById('timer-ring');
  var numEl    = document.getElementById('timer-num');
  var btnGroup = document.getElementById('btn-group');
  var btnPh    = document.getElementById('btn-placeholder');
  var step2    = document.getElementById('step2');
  var step3    = document.getElementById('step3');
  var line2    = document.getElementById('line2');
  var line1    = document.getElementById('line1');
  var CIRC     = 2 * Math.PI * 45; // ≈ 283

  // Điền đường tròn ngay
  ring.style.strokeDasharray  = CIRC;
  ring.style.strokeDashoffset = CIRC;
  line1.classList.add('filled');

  function tick() {
    current--;
    numEl.textContent = current;

    // Cập nhật vòng tròn
    var progress = (TOTAL - current) / TOTAL;
    ring.style.strokeDashoffset = CIRC - progress * CIRC;

    if (current <= 0) {
      clearInterval(timer);
      showButtons();
    }
  }

  function showButtons() {
    // Cập nhật step
    step2.classList.remove('active');
    step2.classList.add('done');
    step2.querySelector('.dl-step-circle').textContent = '✓';
    step3.classList.add('active');
    line2.classList.add('filled');

    // Ẩn timer, hiện button
    document.getElementById('timer-wrap').style.display = 'none';
    btnPh.style.display = 'none';
    btnGroup.classList.remove('d-none');

    // Hiện nút direct sau 8 giây (sau khi bấm Linkvertise)
    document.getElementById('btn-linkvertise').addEventListener('click', function () {
      setTimeout(function () {
        document.getElementById('btn-direct').classList.remove('d-none');
      }, 8000);
    });
  }

  var timer = setInterval(tick, 1000);
})();
</script>
@endsection
