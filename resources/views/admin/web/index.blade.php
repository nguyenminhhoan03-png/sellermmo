@php 
     use App\Helpers\Helper;
     use App\Models\CategoryHosting;
     use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'DANH MỤC TẠO WEB')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="mb-3 text-end">
    <button data-bs-toggle="modal" data-bs-target="#modal-create" class="btn btn-outline-primary me-2"><i class="fas fa-plus"></i> {{ __('Thêm website') }}</button>
  </div>

  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">DANH MỤC TẠO WEB</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
              <th class="text-center">Tên web</th>
              <th class="text-center">Ảnh</th>
              <th class="text-center">Số tiền</th>
              <th class="text-center">Chiết khấu</th>
              <th class="text-center">Trạng thái</th>
              <th class="text-center">Button</th>
              <th class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($web as $webs)
            <tr>
                <td class="text-center">{{ $webs->name }}</td>
                <td class="text-center"><img src="{{ $webs->images }}" width="100px" style="border-radius: 10px;"></td>
                <td class="text-center">{{ number_format($webs->price)  }}đ</td>
                <td class="text-center">{{ $webs->ck }}%</td>
                <td class="text-center">{!! Helper::status_server_cron_admin($webs->status) !!}</td>
                <td class="text-center">
                  <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox"
                    role="switch"
                    id="flexSwitchCheckDefault{{ $webs->id }}"
                    value="{{ $webs->id }}"
                    onchange="updateStatus(this)"
                    @if($webs->status == 1) checked @endif>

                  <label class="form-check-label" for="flexSwitchCheckDefault{{ $webs->id }}"></label>
                   </div>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-update-{{ $webs->id }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <a href="javascript:deleteRow({{ $webs->id }})" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete">
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
  @foreach ($web as $value)
    <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cập nhật danh mục #{{ $value->id }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.web.update', ['id' => $value->id]) }}" class="default-form" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ $value->name }}" required>
              </div>
              <div class="mb-3">
            <label for="images" class="form-label">Hình ảnh</label>
              <input class="form-control" type="file" id="images" name="images" value="">
              <div class="mb-2 mt-2">
                <img src="{{ ($value->images) }}" alt="Logo" class="img-fluid" style="max-height: 100px;">
              </div>
             </div>
             <div class="mb-3">
            <label for="images" class="form-label">List Hình ảnh</label>
              <input class="form-control" type="file" id="list_images" name="list_images[]" multiple>
              <div class="mb-2 mt-2">
                @php
                   $lines = explode("\n", $value->list_images); 
                @endphp   
                @foreach ($lines as $line)
                <img src="{{ $line }}" alt="Logo" class="img-fluid me-2" style="max-height: 100px;">
                @endforeach
              </div>
             </div>
             <div class="mb-3 row">
               <div class="col-md-4">
               <label for="price" class="form-label">Giá gốc</label>
               <input type="number" class="form-control" name="price" id="price" value="{{ old('price', $value->price) }}" required>
              </div>
              <div class="col-md-4">
               <label for="price" class="form-label">Giá gia hạn</label>
               <input type="number" class="form-control" name="extend" id="extend" value="{{ old('extend', $value->extend) }}" required>
              </div>
               <div class="col-md-4">
              <label for="ck" class="form-label">Phần trăm giảm giá (%)</label>
               <input type="number" class="form-control" name="ck" id="ck" value="{{ old('ck', $value->ck) }}" required>
              </div>
             </div>
             <div class="mb-3">
                <label for="description" class="form-label">Ảnh mô tả</label>
              <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $value->description) }}</textarea>
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
          <h5 class="modal-title" id="exampleModalLabel">Thêm website</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.web.store') }}" method="POST" class="default-form" data-reload="1" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Tên web</label>
              <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập thông tin" required>
            </div> 
            <div class="mb-3 row">
              <div class="col-md-4">
                <label for="price" class="form-label">Giá gốc</label>
                <input type="number" class="form-control" name="price" id="price" value="" required="">
              </div>
              <div class="col-md-4">
                <label for="price" class="form-label">Giá gia hạn</label>
                <input type="number" class="form-control" name="extend" id="extend" value="" required="">
              </div>
              <div class="col-md-4">
                <label for="ck" class="form-label">Phần trăm giảm giá (%)</label>
                <input type="number" class="form-control" name="ck" id="ck" value="0" required="">
              </div>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Hình ảnh</label>
              <input class="form-control" type="file" id="images" name="images" value="">
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">List Hình ảnh chi tiết</label>
              <input class="form-control" type="file" id="list_images" name="list_images[]" multiple>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">mô tả</label>
              <textarea name="description" id="description" class="form-control" rows="5"></textarea>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Trạng thái</label>
              <select class="form-control" id="status" name="status">
                <option value="1" @if (old('status') == 0) selected @endif>Hoạt động</option>
                <option value="0" @if (old('status') == 1) selected @endif>Không hoạt động</option>
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
  const updateStatus = (element) => {
    let id = element.value;
    let status = element.checked ? 1 : 0;

    axios.post(`/Cpanel/web/update-status`, {
      id: id,
      status: !!status
    }).then((response) => {
      Swal.fire({
        icon: 'success',
        title: 'Thành công',
        text: response.data.message
      })
     }).catch((error) => {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: $catchMessage(error)
      })
     });
    }
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
        } = await axios.post('{{ route('admin.web.delete') }}', {
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