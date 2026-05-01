@php 
     use App\Helpers\Helper;
     use App\Models\CategoryHosting;
     use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'DANH MỤC HOSTING')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="mb-3 text-end">
    <button data-bs-toggle="modal" data-bs-target="#modal-create" class="btn btn-outline-primary me-2"><i class="fas fa-plus"></i> {{ __('Thêm Danh Mục') }}</button>
  </div>

  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">DANH MỤC HOSTING</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
              <th class="text-center">Tên Danh Mục</th>
              <th class="text-center">Ảnh</th>
              <th class="text-center">Trạng thái</th>
              <th class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($category_hosting as $category_hostings)
            @php
                
            @endphp
            <tr>
                <td class="text-center">{{ $category_hostings->name }}</td>
                <td class="text-center"><img src="{{ $category_hostings->anh }}" width="100px" style="border-radius: 10px;"></td>
                <td class="text-center">{!! Helper::status_server_cron_admin($category_hostings->status) !!}</td>
                <td class="text-center">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-update-{{ $category_hostings->id }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <a href="javascript:deleteRow({{ $category_hostings->id }})" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete">
                       <i class="fas fa-trash"></i> Delete
                    </a>
                </td>
            </tr>         
             @endforeach 
          </tbody>
        </table>
      </div>
    </div>
  </div> 
  @foreach ($category_hosting as $value)
    <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cập nhật danh mục #{{ $value->id }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.hosting.category.update', ['id' => $value->id]) }}" class="default-form" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ $value->name }}" required>
              </div>
              <div class="mb-3">
                <label for="anh" class="form-label">Ảnh</label>
                <input class="form-control" type="text" id="anh" name="anh" value="{{ $value->anh }}" required>
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-control" id="status" name="status">
                  <option value="1" @if ($value->status == 1) selected @endif>Đang hoạt động</option>
                  <option value="0" @if ($value->status == 0) selected @endif>Không hoạt động</option>
                </select>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary w-100" type="submit">Cập nhật</button>
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
          <h5 class="modal-title" id="exampleModalLabel">Thêm danh mục</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.hosting.category.store') }}" method="POST" class="default-form" data-reload="1" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Tên danh mục</label>
              <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập thông tin" required>
            </div>        
            <div class="mb-3">
                <label for="anh" class="form-label">Ảnh</label>
                <input class="form-control" type="text" id="anh" name="anh" value="{{ old('anh') }}" placeholder="Nhập link ảnh" required>
              </div>  
            <div class="mb-3">
              <label for="status" class="form-label">Trạng thái</label>
              <select class="form-control" id="status" name="status">
                <option value="1" @if (old('status') == 1) selected @endif>Hoạt động</option>
                <option value="0" @if (old('status') == 0) selected @endif>Không hoạt động</option>
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
<script>
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
        } = await axios.post('{{ route('admin.hosting.category.delete') }}', {
          id
        })

        Swal.fire('Thành công', result.message, 'success').then(() => {
          window.location.reload();
        })
      } catch (error) {
        Swal.fire('Thất bại', $catchMessage(error), 'error')
      }
    }
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