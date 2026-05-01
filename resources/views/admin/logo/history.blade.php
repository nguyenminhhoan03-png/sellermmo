@php 
     use App\Helpers\Helper;
     use App\Models\Product;
     use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'Các đơn tạo logo')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">Các đơn tạo logo</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('Mã Giao Dịch') }}</th>
              <th>{{ __('Tên yêu cầu') }}</th>
              <th>{{ __('Số Tiền') }}</th>
              <th>{{ __('Trạng Thái') }}</th>
              <th>{{ __('Thao Tác') }}</th>
              <th>{{ __('Ngày đặt đơn') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($hislogo as $hislogos)
            <tr>
              <td>{{ $hislogos->id }}</td>
              <td>{{ $hislogos->trans_id }}</td>
              <td>{{ $hislogos->name}}</td>
              <td>{{ formatCurrency($hislogos->price) }}</td>
              <td>{!! Helper::status_logo_admin($hislogos->status) !!}</td>
              <td>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-update-{{ $hislogos->id }}" class="badge bg-primary-gradient text-white me-2"><i class="fas fa-edit"></i></a>
                <a href="javascript:void(0)" class="badge bg-danger-gradient" onclick="deleteRow({{ $hislogos->id }})"><i class="fas text-white fa-trash"></i></a>
              </td>
              <td>{{ $hislogos->created_at }}</td>
            </tr> 
             @endforeach 
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
  @foreach ($hislogo as $value)
  <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cập nhật đơn hàng #{{ $value->trans_id }}</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.logo.update-logo', ['id' => $value->id]) }}" class="default-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="status" class="form-label">Trạng thái</label>
              <select class="form-control" id="status" name="status">
                <option value="0" @if ($value->status == 0) selected @endif>Chờ duyệt đơn</option>
                <option value="1" @if ($value->status == 1) selected @endif>Hủy đơn tạo logo</option>
                <option value="2" @if ($value->status == 2) selected @endif>Tạo logo thành công</option>
              </select>
            </div>
            <div class="mb-3">
                <label for="link" class="form-label">Link tải logo</label>
                <input class="form-control" type="text" id="link" name="link" value="{{ $value->link }}" required>
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
        } = await axios.post('{{ route('admin.logo.delete-history') }}', {
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