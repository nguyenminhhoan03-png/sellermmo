@php
use App\Helpers\Helper;
@endphp
@extends('admin.layouts.master')
@section('title', 'DANH SÁCH CHUYÊN MỤC BÀI VIẾT')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="mb-3 text-end">
    <button data-bs-toggle="modal" data-bs-target="#modal-create" class="btn btn-outline-primary me-2"><i class="fas fa-plus"></i> {{ __('Thêm Chuyên Mục') }}</button>
  </div>

  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">DANH SÁCH CHUYÊN MỤC BÀI VIẾT</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
              <th>{{ __('Tên chuyên mục') }}</th>
              <th>{{ __('Đường dẫn') }}</th>
              <th>{{ __('Trạng thái') }}</th>
              <th>{{ __('Thao tác') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($category as $categorys)
            <tr>
                <td>{{ $categorys->name }}</td>
                <td>{{ $categorys->slug }}</td>
                <td>{!! Helper::status_blogs_admin($categorys->status) !!}</td>
                <td>
                    <a type="button" data-bs-toggle="modal" data-bs-target="#modal-update-{{ $categorys->id }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                        <i class="fa fa-pencil-alt"></i>
                    </a>
                    <a type="button" onclick="deleteRow({{ $categorys->id }})" class="btn btn-sm btn-light" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
  @foreach ($category as $value)
  <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cập nhật chuyên mục #{{ $value->id }}</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.blog.category.update', ['id' => $value->id]) }}" method="POST" class="default-form" data-reload="1" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Tên chuyên mục: </label>
              <input class="form-control" type="text" name="name" value="{{ $value->name }}" placeholder="Nhập tên chuyên mục" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Đường dẫn SEO:</label>
                <input class="form-control" type="text" name="slug" value="{{ $value->slug }}" placeholder="Đường dẫn SEO" required>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Trạng thái</label>
              <select class="form-control" id="status" name="status">
                <option value="1" @if ($value->status == 1) selected  @endif>Hoạt động</option>
                <option value="0" @if ($value->status == 0) selected  @endif>Không hoạt động</option>
              </select>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary w-100" type="submit">Thêm mới</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Thêm chuyên mục bài viết mới</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.blog.category.post') }}" method="POST" class="default-form" data-reload="1" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Tên chuyên mục: </label>
              <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập tên chuyên mục" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Đường dẫn SEO:</label>
                <input class="form-control" type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="Đường dẫn SEO" required>
              </div>
            <div class="mb-3">
              <label for="status" class="form-label">Trạng thái</label>
              <select class="form-control" id="status" name="status">
                <option value="1" selected>Hoạt động</option>
                <option value="0">Không hoạt động</option>
              </select>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary w-100" type="submit">Thêm mới</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>  
@endsection
@section('scripts')
<script type="text/javascript">
    const deleteRow = async (id) => {
      const confirmDelete = await Swal.fire({
        title: '{{ __('Bạn chắc chứ?') }}',
        text: "{{ __('Bạn sẽ không thể khôi phục lại dữ liệu này!') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __('Xóa') }}',
        cancelButtonText: '{{ __('Hủy') }}'
      });

      if (!confirmDelete.isConfirmed) return;

      $showLoading();

      try {
        const {
          data: result
        } = await axios.post('{{ route('admin.blog.category.delete') }}', {
          id
        })

        Swal.fire('Thành công', result.message, 'success').then(() => {
          window.location.reload();
        })
      } catch (error) {
        Swal.fire('Thất bại', $catchMessage(error), 'error')
      }
    }
    $(document).ready(function () {

        $('#name').focusout(function () {
            var pname = $(this).val();
            $.ajax({
                url: '{{ route('slug') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                method: "post",
                data: {
                    title: pname,
                },
                success: function (data) {
                    if (data) {
                        $("#slug").attr('value', data);
                        $("#name").attr('value', pname);
                    }
                }

            });

        });
    });
</script>
<script>
  $(document).ready(function() {
    window.pageOverlay = $("#page-overlay");

    // basic datatable
    $('#datatable').DataTable({
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
      },
      response: false,
      order: [
        [0, 'desc']
      ],
      pageLength: 10,
      lengthMenu: [
        [10, 25, 50, 100, 500, 1000, 5000, -1],
        [10, 25, 50, 100, 500, 1000, 5000, 'All']
      ]
    });

  })
</script>
@endsection