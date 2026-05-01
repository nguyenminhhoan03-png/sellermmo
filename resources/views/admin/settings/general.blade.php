@php use App\Helpers\Helper; @endphp
@extends('admin.layouts.master')
@section('title', 'Cài đặt hệ thống')

@section('css')
  <link rel="stylesheet" href="{{ asset('/plugins/codemirror/codemirror.css') }}" />
  <link rel="stylesheet" href="{{ asset('/plugins/codemirror/theme/monokai.css') }}" />
  <style>
    .settings-nav {
      position: sticky;
      top: 1rem;
    }

    .nav-link {
      color: #495057;
      padding: 1rem;
      border-radius: 0.5rem;
      transition: all 0.2s;
    }

    .nav-link:hover {
      background: rgba(0, 0, 0, 0.05);
    }

    .nav-link.active {
      background: #0d6efd;
      color: #fff;
    }

    .settings-section {
      background: #fff;
      border-radius: 0.5rem;
      box-shadow: 0 0 1rem rgba(0, 0, 0, 0.05);
      margin-bottom: 1.5rem;
    }

    .section-header {
      padding: 1rem;
      border-bottom: 1px solid #dee2e6;
    }

    .section-body {
      padding: 1.5rem;
    }

    .form-label {
      font-weight: 500;
    }

    .preview-image {
      max-height: 100px;
      border: 2px dashed #dee2e6;
      border-radius: 0.5rem;
      padding: 0.25rem;
    }

    .form-hint {
      font-size: 0.875rem;
      color: #6c757d;
      margin-top: 0.25rem;
    }
  </style>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row g-4">
      <!-- Side Navigation -->
      <div class="col-12 col-lg-3">
        <div class="settings-nav">
          <nav class="nav flex-column nav-pills">
            <a class="nav-link active" data-bs-toggle="pill" href="#general">
              <i class="fas fa-cog me-2"></i>Cài đặt chung
            </a>
            <a class="nav-link" data-bs-toggle="pill" href="#themes">
              <i class="fas fa-paint-brush me-2"></i>Giao diện
            </a>
            <a class="nav-link" data-bs-toggle="pill" href="#payments">
              <i class="fas fa-money-bill me-2"></i>Nạp tiền
            </a>
            <a class="nav-link" data-bs-toggle="pill" href="#contact">
              <i class="fas fa-address-book me-2"></i>Liên hệ
            </a>
            <a class="nav-link" data-bs-toggle="pill" href="#scripts">
              <i class="fas fa-code me-2"></i>Scripts
            </a>
          </nav>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-12 col-lg-9">
        <div class="tab-content">
          <!-- General Settings -->
          <div class="tab-pane fade show active" id="general">
            <div class="settings-section">
              <form action="{{ route('admin.settings.general.update', ['type' => 'general']) }}" method="POST" class="default-form" enctype="multipart/form-data">
                @csrf
                <!-- Website Info -->
                <div class="section-header">
                  <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin website</h5>
                </div>
                <div class="section-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', setting('title')) }}" placeholder="Tiêu đề website">
                        <label for="title">Tiêu đề website</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="keywords" name="keywords" value="{{ old('keywords', setting('keywords')) }}" placeholder="Từ khóa tìm kiếm">
                        <label for="keywords">Từ khóa tìm kiếm</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-floating">
                        <textarea class="form-control" id="description" name="description" style="height: 100px" placeholder="Mô tả website">{{ old('description', setting('description')) }}</textarea>
                        <label for="description">Mô tả website</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="section-header">
                  <h5 class="mb-0"><i class="fas fa-images me-2"></i>Logo & Hình ảnh</h5>
                </div>
                <div class="section-body">
                  <div class="row g-4">
                    <div class="col-md-6">
                      <div class="text-center">
                        <label class="form-label">Logo Light</label>
                        <input type="file" class="form-control mb-2" name="logo_light" accept="image/*">
                        <img src="{{ setting_asset('logo_light') }}" alt="Logo Light" class="preview-image">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="text-center">
                        <label class="form-label">Logo Dark</label>
                        <input type="file" class="form-control mb-2" name="logo_dark" accept="image/*">
                        <img src="{{ setting_asset('logo_dark', 'assets/media/logos/custom-3.svg') }}" alt="Logo Dark" class="preview-image">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="text-center">
                        <label class="form-label">Favicon</label>
                        <input type="file" class="form-control mb-2" name="favicon" accept="image/*">
                        <img src="{{ setting_asset('favicon') }}" alt="Favicon" class="preview-image">
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="text-center">
                        <label class="form-label">Thumbnail</label>
                        <input type="file" class="form-control mb-2" name="thumbnail" accept="image/*">
                        <img src="{{ setting_asset('thumbnail', 'assets/images/null.svg') }}" alt="Thumbnail" class="preview-image">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Footer -->
                <div class="section-header">
                  <h5 class="mb-0"><i class="fas fa-window-maximize me-2"></i>Footer</h5>
                </div>
                <div class="section-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="footer_text" name="footer_text" value="{{ old('footer_text', setting('footer_text', 'CMSNT.CO LTD')) }}" placeholder="Footer Text">
                        <label for="footer_text">Footer Text</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="footer_link" name="footer_link" value="{{ old('footer_link', setting('footer_link')) }}" placeholder="Footer Link">
                        <label for="footer_link">Footer Link</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Rút Tiền -->
                <div class="section-header">
                  <h5 class="mb-0"><i class="fas fa-shield me-2"></i>Cấu Hình Rút Tiền CTV</h5>
                </div>
                <div class="section-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <select class="form-select" id="rutctv" name="rutctv">
                          <option value="1" {{ setting('rutctv', 'tay') == 'auto' ? 'selected' : '' }}>Bật</option>
                          <option value="0" {{ setting('rutctv', 'tay') == 'tay' ? 'selected' : '' }}>Tắt</option>
                        </select>
                        <label for="rutctv">Cấu Hình Rút Tiền CTV</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="number" class="form-control" id="minctv" name="minctv" value="{{ old('minctv', setting('minctv', null)) }}" placeholder="Min Rút tiền">
                        <label for="minctv">Min Rút Tiền CTV</label>
                      </div>
                    </div>
                  </div>
                </div>
                 <!-- Rút Tiền -->
                 <div class="section-header">
                  <h5 class="mb-0"><i class="fa-brands fa-cpanel me-2 fs-4"></i>Cấu Hình Bán Hosting</h5>
                </div>
                <div class="section-body">
                  <div class="row g-3">
                    <div class="col-md-12">
                      <div class="form-floating">
                        <select class="form-select" id="hosting" name="hosting">
                          <option value="1" {{ setting('hosting', '1') == '1' ? 'selected' : '' }}>Mua Trực Tiếp</option>
                          <option value="0" {{ setting('hosting', '1') == '0' ? 'selected' : '' }}>Sử Dụng Cron</option>
                        </select>
                        <label for="hosting">Cấu Hình Thanh toán cron</label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label for="link_cron" class="form-label">Link Cron (Tạo hosting)</label>
                        <input type="text" class="form-control" id="link_cron" value="{{ route('hosting.cron') }}" readonly="">
                    </div>
                    </div>
                  </div>
                </div>

                <!-- Captcha -->
                <div class="section-header">
                  <h5 class="mb-0"><i class="fas fa-shield me-2"></i>Cloudflare Captcha</h5>
                </div>
                <div class="section-body">
                  <div class="alert alert-danger">Sử dụng captcha của Cloudflare: <a href="https://dash.cloudflare.com/sign-up?to=/:account/turnstile" target="_blank">Xem tại đây</a>; cấu hình xong kiểm tra ở trang đăng
                    ký ở trang ẩn danh trước khi đăng xuất khỏi admin.</div>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <div class="form-floating">
                        <select class="form-select" id="captcha_status" name="captcha_status">
                          <option value="1" {{ setting('captcha_status', 0) == 1 ? 'selected' : '' }}>Bật</option>
                          <option value="0" {{ setting('captcha_status', 0) == 0 ? 'selected' : '' }}>Tắt</option>
                        </select>
                        <label for="captcha_siteKey">Status</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="captcha_siteKey" name="captcha_siteKey" value="{{ old('captcha_siteKey', setting('captcha_siteKey', null)) }}" placeholder="Footer Text">
                        <label for="captcha_siteKey">Site Key</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="captcha_secretKey" name="captcha_secretKey" value="{{ old('captcha_secretKey', setting('captcha_secretKey')) }}" placeholder="Footer Link">
                        <label for="captcha_secretKey">Secret Key</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="section-header">
                  <h5 class="mb-0"><i class="fas fa-shield me-2"></i>Cấu hình NS</h5>
                </div>
                <div class="section-body">
                  <div class="row g-3">
                    <div class="col-md-4">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="ns1" name="ns1" value="{{ old('ns1', setting('ns1', null)) }}" placeholder="Name Server 1">
                        <label for="ns1">Name Server 1</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="ns2" name="ns2" value="{{ old('ns2', setting('ns2')) }}" placeholder="Name Server 2">
                        <label for="ns2">Name Server 2</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="p-3 text-end">
                  <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i>Lưu thay đổi
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- Themes -->
          <div class="tab-pane fade" id="themes">
            <div class="settings-section">
              @php
                $themes = Helper::getConfig('theme_settings');
                $list_themes = [
                    ['name' => 'none', 'label' => __('Không sử dụng')],
                    ['name' => 'default', 'label' => __('Mặc định')],
                ];
              @endphp

              <form action="{{ route('admin.settings.general.update', ['type' => 'theme_settings']) }}" method="POST" enctype="multipart/form-data" class="default-form">
                @csrf
                <div class="section-header">
                  <h5 class="mb-0"><i class="fas fa-palette me-2"></i>Tùy chỉnh giao diện</h5>
                </div>
                <div class="section-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Mẫu trang giới thiệu</label>
                      <select class="form-select" name="ladi_name">
                        <option value="">Chọn mẫu</option>
                        @foreach ($list_themes as $theme)
                          <option value="{{ $theme['name'] }}" @if (isset($themes['ladi_name']) && $themes['ladi_name'] === $theme['name']) selected @endif>
                            {{ $theme['label'] }}
                          </option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label d-flex justify-content-between align-items-center">
                          Ảnh nền đăng nhập/đăng ký
                          <a href="{{ $themes['auth_bg'] ?? '#!' }}" target="_blank" class="btn btn-sm btn-light">Xem</a>
                        </label>
                        <input type="file" class="form-control" name="auth_bg" accept="image/*">
                        <div class="mt-2 text-center">
                          <img src="{{ asset($themes['auth_bg'] ?? '') }}" class="preview-image" alt="Auth Background">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="p-3 text-end">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Lưu thay đổi
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- Payments -->
          <div class="tab-pane fade" id="payments">
            <div class="row g-4">
              <!-- Deposit Info -->
              <div class="col-md-12">
                <div class="settings-section h-100">
                  @php $deposit_info = Helper::getConfig('deposit_info'); @endphp
                  <form action="{{ route('admin.settings.general.update', ['type' => 'deposit_info']) }}" method="POST" class="axios-form">
                    @csrf
                    <div class="section-header">
                      <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin nạp tiền</h5>
                    </div>
                    <div class="section-body">
                      <div class="mb-3">
                        <label class="form-label">Cú pháp nạp tiền</label>
                        <input type="text" class="form-control" name="prefix" value="{{ $deposit_info['prefix'] ?? 'hello ' }}" required>
                        <div class="form-hint">
                          Nội dung chuyển khoản: <span class="text-danger">{{ ($deposit_info['prefix'] ?? 'hello ') . auth()->id() }}</span>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Cú pháp Chuyển khoản</label>
                        <input type="text" class="form-control" name="transfer" value="{{ $deposit_info['transfer'] ?? 'transfer ' }}" required>
                        <div class="form-hint">
                          Nội dung chuyển khoản: <span class="text-danger">{{ ($deposit_info['transfer'] ?? 'transfer ') . auth()->id() }}</span>
                        </div>
                      </div>
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">Khuyến mãi [+ %]</label>
                          <input type="number" class="form-control" name="discount" value="{{ $deposit_info['discount'] ?? 0 }}" required>
                          <div class="form-hint">% cộng thêm vào số tiền nạp</div>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Số tiền tối thiểu</label>
                          <input type="number" class="form-control" name="min_amount" value="{{ $deposit_info['min_amount'] ?? 0 }}" required>
                          <div class="form-hint">Số tiền tối thiểu để được KM</div>
                        </div>
                      </div>
                    </div>
                    <div class="p-3 text-end">
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                      </button>
                    </div>
                  </form>
                </div>
              </div>

            </div>
          </div>

          <!-- Contact -->
          <div class="tab-pane fade" id="contact">
            <div class="settings-section">
              @php $contact = Helper::getConfig('contact_info'); @endphp
              <form action="{{ route('admin.settings.general.update', ['type' => 'contact_info']) }}" method="POST" class="axios-form">
                @csrf
                <div class="section-header">
                  <h5 class="mb-0"><i class="fas fa-address-book me-2"></i>Thông tin liên hệ</h5>
                </div>
                <div class="section-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" name="facebook" value="{{ $contact['facebook'] ?? '' }}" placeholder="Facebook">
                        <label>Facebook</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" name="telegram" value="{{ $contact['telegram'] ?? '' }}" placeholder="Telegram">
                        <label>Telegram</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="tel" class="form-control" name="sdt" value="{{ $contact['sdt'] ?? '' }}" placeholder="Số điện thoại">
                        <label>Số điện thoại</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="email" class="form-control" name="email" value="{{ $contact['email'] ?? '' }}" placeholder="Email">
                        <label>Email</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="p-3 text-end">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Lưu thay đổi
                  </button>
                </div>
              </form>
            </div>
          </div>
          <!-- Scripts -->
          <div class="tab-pane fade" id="scripts">
            <div class="row g-4">
              <!-- Header Script -->
              <div class="col-md-6">
                <div class="settings-section h-100">
                  <form action="{{ route('admin.settings.general.update', ['type' => 'header_script']) }}" method="POST" class="default-form">
                    @csrf
                    <div class="section-header">
                      <h5 class="mb-0"><i class="fas fa-code me-2"></i>Header Script</h5>
                    </div>
                    <div class="section-body">
                      <textarea id="editor1" name="code" class="form-control" rows="10">{{ base64_decode(Helper::getNotice('header_script')) }}</textarea>
                    </div>
                    <div class="p-3 text-end">
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                      </button>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Footer Script -->
              <div class="col-md-6">
                <div class="settings-section h-100">
                  <form action="{{ route('admin.settings.general.update', ['type' => 'footer_script']) }}" method="POST" class="default-form">
                    @csrf
                    <div class="section-header">
                      <h5 class="mb-0"><i class="fas fa-code me-2"></i>Footer Script</h5>
                    </div>
                    <div class="section-body">
                      <textarea id="editor2" name="code" class="form-control" rows="10">{{ base64_decode(Helper::getNotice('footer_script')) }}</textarea>
                    </div>
                    <div class="p-3 text-end">
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('/plugins/codemirror/codemirror.js') }}"></script>
  <script src="{{ asset('/plugins/codemirror/mode/css/css.js') }}"></script>
  <script src="{{ asset('/plugins/codemirror/mode/xml/xml.js') }}"></script>
  <script src="{{ asset('/plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>

  <script>
    $(document).ready(function() {
      // Initialize CodeMirror editors
      CodeMirror.fromTextArea(document.getElementById("editor1"), {
        mode: "htmlmixed",
        theme: "monokai",
        lineNumbers: true,
        autoCloseTags: true,
        autoCloseBrackets: true,
        matchBrackets: true
      });

      CodeMirror.fromTextArea(document.getElementById("editor2"), {
        mode: "htmlmixed",
        theme: "monokai",
        lineNumbers: true,
        autoCloseTags: true,
        autoCloseBrackets: true,
        matchBrackets: true
      });

      // Image preview
      $('input[type="file"]').change(function(e) {
        let file = e.target.files[0];
        let reader = new FileReader();
        let preview = $(this).closest('.section-body').find('img');

        if (file) {
          reader.onload = function(e) {
            preview.attr('src', e.target.result);
          }
          reader.readAsDataURL(file);
        }
      });

      // Loading state for forms
      $('.default-form, .axios-form').on('submit', function() {
        let button = $(this).find('button[type="submit"]');
        button.prop('disabled', true);
        button.html('<span class="spinner-border spinner-border-sm me-2"></span>Đang lưu...');
      });
    });
  </script>
@endsection
