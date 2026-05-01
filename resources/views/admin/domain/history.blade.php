@php 
     use App\Helpers\Helper;
     use App\Models\Product;
     use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'Lịch Sử Mua Tên Miền')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="mb-3 text-end">
    <a href="{{ route('admin.domain.index') }}" class="btn btn-outline-primary me-2"><i class="fas fa-plus"></i> {{ __('Đăng bán tên miền') }}</a>
  </div>
  <div class="alert alert-danger alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
    <svg class="svg-danger" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000">
        <path d="M0 0h24v24H0z" fill="none"></path>
        <path d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z"></path>
    </svg>
    Vui lòng thực hiện <b>CronJob</b> liên kết: <a class="text-primary" href="{{ route('domain.giahan.auto') }}?type=auto" target="_blank">{{ route('domain.giahan.auto') }}?type=auto</a> 1 phút 1 lần hoặc nhanh hơn để hệ thống xử lý gia hạn tên miền auto.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
</div>
<div class="alert alert-danger alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
  <svg class="svg-danger" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000">
      <path d="M0 0h24v24H0z" fill="none"></path>
      <path d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z"></path>
  </svg>
  Vui lòng thực hiện <b>CronJob</b> liên kết: <a class="text-primary" href="{{ route('domain.giahan.auto') }}?type=tay" target="_blank">{{ route('domain.giahan.auto') }}?type=tay</a> 1 phút 1 lần hoặc nhanh hơn để hệ thống xử lý các tên miền hết hạn.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
</div>
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">Danh sách bán tên miền</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('Người Dùng') }}</th>
              <th>{{ __('Tên Miền') }}</th>
              <th>{{ __('Mã giao dịch') }}</th>
              <th>{{ __('Số tiền') }}</th>
              <th>{{ __('NS') }}</th>
              <th>{{ __('Gia Hạn Auto') }}</th>
              <th>{{ __('Trạng Thái') }}</th>
              <th>{{ __('Thời Gian') }}</th>
              <th>{{ __('Thao Tác') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($history as $historys)
            <tr>
              <td>{{ $historys->id }}</td>
              <td><a class="text-primary" href="/users/edit/{{ $historys->user_id }}"> [{{ $historys->user_id }}] {{ User::getUser($historys->user_id, 'name') }}</a></td>
              <td>{{ $historys->domain_name }}</td>
              <td>{{ $historys->trans_id }}</td>
              <td>{{ formatCurrency($historys->price) }}</td>
              <td>{{ ($historys->ns) }}</td>
              <td>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" 
                           id="flexSwitchCheckDefault{{ $historys->id }}" 
                           value="{{ $historys->id }}" 
                           onchange="updateStatus(this)" 
                           @if ($historys->giahan == 1) checked @endif>
                    <label class="form-check-label" for="flexSwitchCheckDefault{{ $historys->id }}"></label>
                </div>
              </td>
              <td>{!! Helper::status_domain_admin($historys->status) !!}</td>
              <td>
                Ngày mua: <strong data-toggle="tooltip" data-placement="bottom"><small><i class="fa-solid fa-calendar"></i>
                    {{ $historys->created_at }}</small></strong><br>
                Hết hạn: <strong data-toggle="tooltip" data-placement="bottom"><small><i class="fa-solid fa-calendar-days"></i>
                    {{ $historys->expired_date }}</small></strong>
              </td>
              <td>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-update-{{ $historys->id }}" class="badge bg-primary-gradient text-white me-2"><i class="fas fa-edit"></i></a>
                <a href="javascript:void(0)" class="badge bg-danger-gradient" onclick="deleteRow({{ $historys->id }})"><i class="fas text-white fa-trash"></i></a>
              </td>
            </tr> 
             @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
  @foreach ($history as $value)
    <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cập nhật đơn hàng #{{ $value->trans_id }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.domain.update-domain', ['id' => $value->id]) }}" class="default-form" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ $value->domain_name }}" required>
              </div>
              <div class="mb-3">
                <label for="ns" class="form-label">NS</label>
                <textarea name="ns" id="ns" class="form-control" rows="5">{{ $value->ns }}</textarea>
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-control" id="status" name="status">
                  <option value="1" @if ($value->status == 1) selected @endif>Chờ duyệt</option>
                  <option value="2" @if ($value->status == 2) selected @endif>Đã được duyệt</option>
                  <option value="3" @if ($value->status == 3) selected @endif>Không hoạt động</option>
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
        } = await axios.post('{{ route('admin.domain.delete-history') }}', {
          id
        })

        Swal.fire('Thành công', result.message, 'success').then(() => {
          window.location.reload();
        })
      } catch (error) {
        Swal.fire('Thất bại', $catchMessage(error), 'error')
      }
    }
  const updateStatus = (element) => {
    let id = element.value;
    let status = element.checked ? 1 : 0;

    axios.post(`{{ route('admin.domain.update-status-history') }}`, {
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