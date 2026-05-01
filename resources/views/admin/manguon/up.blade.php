@php use App\Helpers\Helper; @endphp
@extends('admin.layouts.master')
@section('title', 'Danh Sách Mã Nguồn')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="mb-3 text-end">
    <a href="/Cpanel/code" class="btn btn-outline-primary me-2"><i class="fas fa-plus"></i> {{ __('Danh Sách') }}</a>
  </div>

  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">Thêm Sản Phẩm</div></div>
    </div>
    <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.manguon.upcode') }}" method="POST" class="default-form" data-reload="1" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Tên Sản Phẩm</label>
              <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập tên mã nguồn" required>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Hình ảnh</label>
              <input class="form-control" type="file" id="images" name="images" value="{{ old('image') }}">
            </div>
            <div class="mb-3">
              <label for="list_images" class="form-label">Ảnh mô tả</label>
              <input class="form-control" type="file" id="list_images" name="list_images[]" multiple>
            </div>
            <div class="mb-3 card bg-secondary mode_form"></div>
            <div class="mb-3 row">
              <div class="col-md-6">
                <label for="price" class="form-label">Giá gốc</label>
                <input type="number" class="form-control" name="price" id="price" value="{{ old('price') }}" required>
              </div>
              <div class="col-md-6">
                <label for="ck" class="form-label">Phần trăm giảm giá (%)</label>
                <input type="number" class="form-control" name="ck" id="ck" value="{{ old('ck', 0) }}" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="intro" class="form-label">Mô tả chi tiết</label>
              <textarea name="intro" id="intro" class="form-control" rows="5">{{ old('intro') }}</textarea>
            </div>
            <div class="mb-3">
              <label for="link_down" class="form-label">Link tải code</label>
              <input class="form-control" type="text" id="link_down" name="link_down" value="{{ old('link_down') }}" placeholder="Nhập link tải code" required>
            </div>
            <div class="mb-3">
              <label for="link_demo" class="form-label">Link demo</label>
              <input class="form-control" type="text" id="link_demo" name="link_demo" value="{{ old('link_demo') }}" placeholder="Nhập link demo" required>
            </div>
            <div class="mb-3 row">
              <div class="col-md-6">
                <label for="category" class="form-label">Danh mục</label>
                <select class="form-control" id="category" name="category">
                  @foreach(\App\Models\Product::CATEGORIES as $key => $cat)
                  <option value="{{ $key }}" @if(old('category', 'website') === $key) selected @endif>
                    {{ $cat['icon'] }} {{ $cat['label'] }}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-control" id="status" name="status">
                  <option value="1" @if (old('status') == 1) selected @endif>Hoạt động</option>
                  <option value="0" @if (old('status') == 0) selected @endif>Không hoạt động</option>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary w-100" type="submit">Thêm mới</button>
            </div>
          </form>
    </div>
    </div>
  </div>

@endsection
@section('scripts')
<script src="/plugins/ckeditor/ckeditor.js"></script>

  <script>
    $(function() {
      const editors = document.querySelectorAll('[id=intro]');

      console.log(editors);
      for (const editor of editors) {
        const inde = CKEDITOR.replace(editor, {
          extraPlugins: 'notification',
          clipboard_handleImages: false,
          filebrowserImageUploadUrl: '/api/Cpanel/tools/upload?form=ckeditor'
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