@php 
     use App\Helpers\Helper;
     use App\Models\Product;
     use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'Các đơn rút tiền của CTV')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="alert alert-danger alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
    <svg class="svg-danger" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000">
        <path d="M0 0h24v24H0z" fill="none"></path>
        <path d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z"></path>
    </svg>
    Vui lòng thực hiện <b>CronJob</b> liên kết: <a class="text-primary" href="{{ route('cron.deposit.withdraw') }}" target="_blank">{{ route('cron.deposit.withdraw') }}</a> 1 phút 1 lần hoặc nhanh hơn để hệ thống xử lý các đơn rút tiền.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
  </div>
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">Các đơn rút tiền của CTV</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('Mã Giao Dịch') }}</th>
              <th>{{ __('Thông Tin') }}</th>
              <th>{{ __('Số Tiền') }}</th>
              <th>{{ __('Trạng Thái') }}</th>
              <th>{{ __('Thao Tác') }}</th>
              <th>{{ __('Ngày Rút') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pay as $pays)
            <tr>
              <td>{{ $pays->id }}</td>
              <td>{{ $pays->trans_id }}</td>
              <td>{{ $pays->bank}} | {{ $pays->stk}} | {{ $pays->ctk}}</td>
              <td>{{ formatCurrency($pays->price) }}</td>
              <td>{!! Helper::status_withdraw_admin($pays->status) !!}</td>
              <td>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-update-{{ $pays->id }}" class="badge bg-primary-gradient text-white me-2"><i class="fas fa-edit"></i></a>
                <a href="javascript:void(0)" class="badge bg-danger-gradient" onclick="deleteRow({{ $pays->id }})"><i class="fas text-white fa-trash"></i></a>
              </td>
              <td>{{ $pays->created_at }}</td>
            </tr> 
             @endforeach 
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
  @foreach ($pay as $value)
  <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cập nhật đơn hàng #{{ $value->trans_id }}</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.manguon.update-pay', ['id' => $value->id]) }}" class="default-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="status" class="form-label">Trạng thái</label>
              <select class="form-control" id="status" name="status">
                <option value="0" @if ($value->status == 0) selected @endif>Chờ chuyển tiền</option>
                <option value="1" @if ($value->status == 1) selected @endif>Đang Chuyển tiền</option>
                <option value="2" @if ($value->status == 2) selected @endif>Chuyển tiền thành công</option>
                <option value="3" @if ($value->status == 3) selected @endif>Chuyển Thất Bại</option>
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
        } = await axios.post('{{ route('admin.manguon.delete-pay') }}', {
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