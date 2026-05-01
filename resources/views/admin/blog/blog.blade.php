@php
use App\Helpers\Helper;
@endphp
@extends('admin.layouts.master')
@section('title', 'THÊM BÀI VIẾT MỚI')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Viết bài mới
                </div>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.blog.add.post') }}" method="POST" enctype="multipart/form-data" class="default-form">
                    @csrf
                    <div class="row mb-4">
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Tiêu đề bài viết:
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input name="title" id="title" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Slug:
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-text">{{route('home') }}/blog</span>
                                    <input type="text" class="form-control" name="slug" id="slug" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Mô Tả Ngắn:</label>
                            <div class="col-sm-12">
                                <textarea name="mota" id="mota" class="form-control" rows="5"></textarea>
                               </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Ảnh nổi bật:
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="image" id="featured-image-input" accept="image/*">
                                <img id="featured-image-preview" src="/assets/images/null.svg" alt="preview" width="200" class="mt-2" style="border-radius:8px;object-fit:cover;">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Chuyên mục<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-select" name="category_id" required="">
                                    <option value="">-- Chọn chuyên mục --</option>
                                    @foreach ($category as $categorys)
                                     <option value="{{ $categorys->id }}">{{ $categorys->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Nội dung chi tiết:</label>
                            <div class="col-sm-12">
                                <textarea name="content" id="content" class="form-control" rows="5"></textarea>
                               </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Trạng thái: <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="status" required="">
                                    <option value="1">ON</option>
                                    <option value="0">OFF</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <a type="button" class="btn btn-danger" href="{{ route('admin.blog.index') }}"><i class="fa fa-fw fa-undo me-1"></i> Back</a>
                    <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-fw fa-save me-1"></i> Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="/plugins/ckeditor/ckeditor.js"></script>

  <script>
    $(document).ready(function () {
      $('#title').focusout(function () {
        var pname = $(this).val();
        $.ajax({
            url: "{{ route('slug') }}",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method: "post",
            data: {
                title: pname,
            },
            success: function (data) {
                if (data) {
                    $("#slug").attr('value', data);
                    $("#title").attr('value', pname);
                }
            }
        });
      });

      const imageInput = document.getElementById('featured-image-input');
      const imagePreview = document.getElementById('featured-image-preview');
      if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function (e) {
          const file = e.target.files && e.target.files[0];
          if (!file) return;
          imagePreview.src = URL.createObjectURL(file);
        });
      }
    });

    $(function() {
      const editor = document.getElementById('content');
      if (!editor) return;

      const uploadUrl = "{{ route('admin.blog.ckeditor-upload') }}?_token={{ csrf_token() }}";
      const inde = CKEDITOR.replace('content', {
        extraPlugins: 'notification',
        clipboard_handleImages: false,
        filebrowserUploadMethod: 'form',
        filebrowserUploadUrl: uploadUrl,
        filebrowserImageUploadUrl: uploadUrl,
        height: 380
      });

      inde.on('fileUploadRequest', function(evt) {
        var xhr = evt.data.fileLoader.xhr;
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.setRequestHeader('Cache-Control', 'no-cache');
      });
    });
  </script>
@endsection