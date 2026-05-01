@php use App\Helpers\Helper; @endphp
@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')
@php
  $decodedMota = base64_decode((string) $row->mota, true);
  $decodedContent = base64_decode((string) $row->content, true);
  $motaValue = $decodedMota !== false ? $decodedMota : (string) $row->mota;
  $contentValue = $decodedContent !== false ? $decodedContent : (string) $row->content;
@endphp
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    CHỈNH SỬA BÀI VIẾT
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blog.edit.post', ['id' => $row->id]) }}" method="POST" enctype="multipart/form-data" class="default-form">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <div class="mb-4">
                                <label class="form-label" for="name">Tiêu đề bài viết:</label>
                                <input type="text" class="form-control" value="{{ $row->title }}" name="title" id="title" required="">
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label" for="example-hf-email">Slug:
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-text">{{ route('home') }}/blog/</span>
                                        <input type="text" class="form-control" value="{{ $row->slug }}" id="slug" name="slug" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="symbol_left">Mô Tả Ngắn:</label>
                                <textarea id="mota" name="mota" class="form-control" rows="5">{{ $motaValue }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="code">Ảnh nổi bật:</label>
                                <input type="file" class="form-control mb-2" name="image" id="featured-image-input" accept="image/*">
                                <img id="featured-image-preview" src="{{ img_url($row->image, '/assets/images/null.svg') }}" width="200" style="border-radius:8px;" onerror="this.src='/assets/images/null.svg'">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="symbol_left">Nội dung bài viết:</label>
                                <textarea id="content" name="content" class="form-control" rows="5">{{ $contentValue }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="symbol_right">Chuyên Mục:</label>
                                <select class="form-select" name="category_id" required="">
                                    <option value="">-- Chọn chuyên mục --</option>
                                    @foreach ($category as $categorys)
                                     <option value="{{ $categorys->id }}" @if ($row->category_id == $categorys->id) selected @endif>{{ $categorys->name }}</option>
                                    @endforeach
                                     </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="symbol_right">Status:</label>
                                <select class="form-control" name="status" required="">
                                    <option value="1" @if ($row->status == 1) @endif >ON</option>
                                    <option value="0" @if ($row->status == 0) @endif>OFF</option>
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
  </script>
@endsection