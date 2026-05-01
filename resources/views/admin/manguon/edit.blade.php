@php use App\Helpers\Helper; @endphp
@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')
  <div class="card custom-card">
    <div class="card-body">
      <form action="{{ route('admin.manguon.update', ['id' => $product->id]) }}" method="POST" data-reload="1" enctype="multipart/form-data" class="default-form">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Tên mã nguồn</label>
          <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">Hình ảnh</label>
            <input class="form-control" type="file" id="images" name="images" value="">
            <div class="mb-2 mt-2">
                <img src="{{ ($product->images) }}" alt="Logo" class="img-fluid" style="max-height: 100px;">
              </div>
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">List Hình ảnh</label>
              <input class="form-control" type="file" id="list_images" name="list_images[]" multiple>
              <div class="mb-2 mt-2">
                @php
                   $lines = !empty($product->list_images) ? explode("\n", $product->list_images) : []; 
                @endphp   
                @foreach ($lines as $line)
                  @if(!empty(trim($line)))
                    <img src="{{ $line }}" alt="Logo" class="img-fluid me-2" style="max-height: 100px;">
                  @endif
                @endforeach
              </div>
             </div>
        <div class="mb-3 card bg-secondary mode_form"></div>
        <div class="mb-3 row">
          <div class="col-md-6">
            <label for="price" class="form-label">Giá gốc</label>
            <input type="number" class="form-control" name="price" id="price" value="{{ old('price', $product->price) }}" required>
          </div>
          <div class="col-md-6">
            <label for="ck" class="form-label">Phần trăm giảm giá (%)</label>
            <input type="number" class="form-control" name="ck" id="ck" value="{{ old('ck', $product->ck) }}" required>
          </div>
        </div>
        <div class="mb-3">
            <label for="link_down" class="form-label">Link tải code</label>
            <input class="form-control" type="text" id="link_down" name="link_down" value="{{ Helper::muabanwebsite_dec(old('link_down', $product->link_down)) }}" placeholder="Nhập link tải code" required>
          </div>
          <div class="mb-3">
            <label for="link_demo" class="form-label">Link demo</label>
            <input class="form-control" type="text" id="link_demo" name="link_demo" value="{{ old('link_demo', $product->link_demo) }}" placeholder="Nhập link demo" required>
          </div>
        <div class="mb-3 row">
          <div class="col-md-6">
            <label for="category" class="form-label">Danh mục</label>
            <select class="form-control" id="category" name="category">
              @foreach(\App\Models\Product::CATEGORIES as $key => $cat)
              <option value="{{ $key }}" @if(old('category', $product->category ?? 'website') === $key) selected @endif>
                {{ $cat['icon'] }} {{ $cat['label'] }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label for="status" class="form-label">Trạng thái</label>
            <select class="form-control" id="status" name="status">
              <option value="1" @if (old('status', $product->status) == 1) selected @endif>Hoạt động</option>
              <option value="0" @if (old('status', $product->status) == 0) selected @endif>Không hoạt động</option>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label for="intro" class="form-label">Mô tả chi tiết</label>
          <textarea name="intro" id="intro" class="form-control" rows="5">{{ old('intro', $product->intro) }}</textarea>
        </div>
        <div class="mb-3">
          <button class="btn btn-primary w-100" type="submit">Cập nhật</button>
        </div>
      </form>
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
