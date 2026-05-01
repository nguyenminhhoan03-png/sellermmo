@php 
     use App\Helpers\Helper;
     use App\Models\SeverCron;
     use App\Models\CronOrder;
     use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'Máy chủ cho thuê cron')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="mb-3 text-end">
    <button data-bs-toggle="modal" data-bs-target="#modal-create" class="btn btn-outline-primary me-2"><i class="fas fa-plus"></i> {{ __('Thêm Máy Chủ') }}</button>
  </div>

  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">Máy chủ CRONJOBS</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
              <th class="text-center">Server</th>
              <th class="text-center">Giá thuê</th>
              <th class="text-center">% Chiết khấu</th>
              <th class="text-center">Chi tiết</th>
              <th class="text-center">Trạng thái</th>
              <th class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($server as $servers)
            @php
                
            @endphp
            <tr>
                <td class="text-center">{{ $servers->name }}</td>
                <td class="text-center"><strong
                        style="color:red;">{{ number_format($servers->price) }}đ</strong> / 1
                    Tháng</td>
                  <td class="text-center"><strong
                    style="color:red;">{{ ($servers->ck) }}%</strong>
                  </td>
               <td>
                <i class="fa-solid fa-link"></i> Link đang chạy: <strong style="color:blue;">{{ CronOrder::Get_total($servers->id) }}</strong><br>
                <i class="fa-solid fa-link"></i> Link tối đa: <strong style="color:red;">{{ $servers->quantity }}</strong><br>
                <i class="fa-solid fa-clock"></i> Timeloop: <strong style="color:green;">{{ $servers->limit_second }}</strong><br>
                    
                </td>
                <td class="text-center">{!! Helper::status_server_cron_admin($servers->status) !!}</td>
                <td class="text-center">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-update-{{ $servers->id }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <a href="javascript:deleteRow({{ $servers->id }})" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete">
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
  @foreach ($server as $value)
  <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cập nhật đơn hàng #{{ $value->id }}</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.cron.update-cron', ['id' => $value->id]) }}" class="default-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Tên máy chủ cron</label>
              <input class="form-control" type="text" id="name" name="name" value="{{ $value->name }}" required>
            </div>
            <div class="mb-3 row">
                <div class="col-md-3">
                  <label for="price" class="form-label">Giá /1 tháng</label>
                  <input type="number" class="form-control" name="price" id="price" value="{{ old('price', $value->price) }}" required>
                </div>
                <div class="col-md-3">
                  <label for="ck" class="form-label">Phần trăm (%)</label>
                  <input type="number" class="form-control" name="ck" id="ck" value="{{ old('ck', $value->ck) }}" required>
                </div>
                <div class="col-md-3">
                  <label for="quantity" class="form-label">Số lượng</label>
                  <input type="number" class="form-control" name="quantity" id="quantity" value="{{ old('quantity', $value->quantity) }}" required>
                </div>
                <div class="col-md-3">
                  <label for="limit_second" class="form-label">Timeloop</label>
                  <input type="number" class="form-control" name="limit_second" id="limit_second" value="{{ old('limit_second', $value->limit_second) }}" required>
                </div>
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
          <h5 class="modal-title" id="exampleModalLabel">Thêm máy chủ mới</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.cron.upload') }}" method="POST" class="default-form" data-reload="1" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Tên máy chủ</label>
              <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập máy chủ" required>
            </div>
            <div class="mb-3 card bg-secondary mode_form"></div>
            <div class="mb-3 row">
              <div class="col-md-3">
                <label for="price" class="form-label">Giá /1 tháng</label>
                <input type="number" class="form-control" name="price" id="price" value="{{ old('price') }}" required>
              </div>
              <div class="col-md-3">
                <label for="ck" class="form-label">Phần trăm giảm giá (%)</label>
                <input type="number" class="form-control" name="ck" id="ck" value="{{ old('ck', 0) }}" required>
              </div>
              <div class="col-md-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" class="form-control" name="quantity" id="quantity" value="{{ old('quantity', 100) }}" required>
              </div>
              <div class="col-md-3">
                <label for="limit_second" class="form-label">Thời gian tối thiểu</label>
                <input type="number" class="form-control" name="limit_second" id="limit_second" value="{{ old('limit_second') }}" required>
              </div>
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
        } = await axios.post('{{ route('admin.cron.delete') }}', {
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