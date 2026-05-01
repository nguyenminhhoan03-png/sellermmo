@extends('admin.layouts.master')
@section('title', 'Admin: Notices Settings')
@section('content')
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">{{ __('Thông báo') }} | Nổi ở trang chủ</div>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.settings.notices.update', ['type' => 'modal_dashboard']) }}" method="POST" class="default-form">
        @csrf
        <div class="mb-3">
          <textarea class="form-control" id="content" name="content" rows="5">{{ base64_decode($modal_dashboard ?? '') }}</textarea>
        </div>
        <div class="mb-3 text-center">
          <button class="btn btn-primary" type="submit">Cập Nhật</button>
        </div>
      </form>
    </div>
  </div>
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">{{ __('Thông báo') }} | Trang nạp tiền</div>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.settings.notices.update', ['type' => 'page_deposit']) }}" method="POST" class="default-form">
        @csrf
        <div class="mb-3">
          <textarea class="form-control" id="content" name="content" rows="5">{{ base64_decode($page_deposit ?? '') }}</textarea>
        </div>
        <div class="mb-3 text-center">
          <button class="btn btn-primary" type="submit">Cập Nhật</button>
        </div>
      </form>
    </div>
  </div>
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">{{ __('Thông báo') }} | Rút Tiền Ctv</div>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.settings.notices.update', ['type' => 'notectv']) }}" method="POST" class="default-form">
        @csrf
        <div class="mb-3">
          <textarea class="form-control" id="content" name="content" rows="5">{{ base64_decode($notectv ?? '') }}</textarea>
        </div>
        <div class="mb-3 text-center">
          <button class="btn btn-primary" type="submit">Cập Nhật</button>
        </div>
      </form>
    </div>
  </div>
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">{{ __('Thông báo') }} | Trang nạp tiền qua thẻ cào</div>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.settings.notices.update', ['type' => 'page_deposit_card']) }}" method="POST" class="default-form">
        @csrf
        <div class="mb-3">
          <textarea class="form-control" id="content" name="content" rows="5">{{ base64_decode($page_deposit_card ?? '') }}</textarea>
        </div>
        <div class="mb-3 text-center">
          <button class="btn btn-primary" type="submit">Cập Nhật</button>
        </div>
      </form>
    </div>
  </div>
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">{{ __('Thông báo') }} | Điều Khoản Sử Dụng</div>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.settings.notices.update', ['type' => 'page_privacy_policy']) }}" method="POST" class="default-form">
        @csrf
        <div class="mb-3">
          <textarea class="form-control" id="content" name="content" rows="5">{{ base64_decode($page_privacy_policy ?? '') }}</textarea>
        </div>
        <div class="mb-3 text-center">
          <button class="btn btn-primary" type="submit">Cập Nhật</button>
        </div>
      </form>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="/plugins/ckeditor/ckeditor.js"></script>

  <script>
    $(function() {
      const editors = document.querySelectorAll('[id=content]');

      console.log(editors);
      for (const editor of editors) {
        const inde = CKEDITOR.replace(editor, {
          extraPlugins: 'notification',
          clipboard_handleImages: false,
          filebrowserImageUploadUrl: '/api/admin/tools/upload?form=ckeditor'
        });

        inde.on('fileUploadRequest', function(evt) {
          var xhr = evt.data.fileLoader.xhr;

          xhr.setRequestHeader('Cache-Control', 'no-cache');
          xhr.setRequestHeader('Authorization', 'Bearer ' + userData.access_token);
        })
      }
    })
  </script>
@endsection
