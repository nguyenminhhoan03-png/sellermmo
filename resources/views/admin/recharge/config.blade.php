@php
    use App\Helpers\Helper;
    use App\Models\ApiLogo;
@endphp
@extends('admin.layouts.master')
@section('title', 'DANH SÁCH NGÂN HÀNG')
@section('css')
    <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

    <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection
@section('content')
<style>
.select2-container {
    z-index: 1050 !important;
}

</style>
<div class="row">
    <div class="col-xl-12">
        <div class="text-right">
            <a class="btn btn-danger label-btn mb-3" href="{{ route('admin.recharge.bank') }}">
                <i class="ri-arrow-go-back-line label-btn-icon me-2"></i> QUAY LẠI
            </a>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    DANH SÁCH NGÂN HÀNG
                </div>
                <div class="d-flex">
                <button type="button" data-bs-toggle="modal" data-bs-target="#modal-create"
                    class="btn btn-sm btn-primary shadow-primary"><i
                        class="ri-add-line fw-semibold align-middle"></i> Thêm ngân hàng</button>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive theme-scrollbar mb-3">
                    <table class="tdisplay table table-bordered table-stripped text-nowrap datatable" id="basic-1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="text-center">Logo</th>
                                <th class="text-center">Ngân Hàng</th>
                                <th class="text-center">Chủ tài khoản</th>
                                <th class="text-center">Số tài khoản</th>
                                <th class="text-center">Trạng Thái</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($bankaccount as $row)
                             
                            
                                                                <tr>
                                <td><b class="text-primary">[ {{ $row->id }} ]</b>
                                </td>
                                 <td class="text-center"><img src="{{ ApiLogo::GetApiBank($row->name, 'shortName', 'logo') }}" height="50">
                                </td>
                                <td><span style="font-size: 15px;"
                                        class="badge bg-outline-danger">{{ ApiLogo::GetApiBank($row->name, 'shortName', 'name') }} ({{$row->name}})</span>
                                </td>
                                 <td class="text-center">{{$row->owner}}
                                </td>
                                 <td>{{$row->number}}
                                </td>
                                <td>
                                    <div class="form-check form-switch text-center">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault{{ $row->id }}" value="{{ $row->id }}" onchange="updateStatus(this)" {{ $row->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check label" for="flexSwitchCheckDefault{{ $row->id }}"></label>
                                  </div>
                                </td>
                                <td class="text-center">
                                    <a type="button" onclick="deleteRow({{ $row->id }})"
                                        class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                        title="Delete">
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
    </div>
</div>
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Thêm thông tin mới</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.recharge.bank.store') }}" method="POST" enctype="multipart/form-data" class="default-form">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Ngân Hàng</label>
                <select class="js-example-basic-single w-full" id="name" name="name">
                    @foreach ($logo as $logos)
                    <option value="{{ $logos->shortName }}">{{ $logos->name }} ({{ $logos->shortName }})</option>
                    @endforeach
                </select>
              </div>
            <div class="mb-3">
              <label for="number" class="form-label">Số tài khoản</label>
              <input class="form-control" type="text" id="number" name="number" required>
            </div>
            <div class="mb-3">
              <label for="owner" class="form-label">Chủ tài khoản</label>
              <input class="form-control" type="text" id="owner" name="owner" required>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Trạng thái</label>
              <select class="form-control" id="status" name="status">
                <option value="1">Hoạt động</option>
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
    <script>
        $(document).ready(function () {
      $('#name').select2({
         dropdownParent: $('#modal-create'),
          width: '100%' 
       });
    });
    const updateStatus = (element) => {
    let id = element.value;
    let status = element.checked ? 1 : 0;

    axios.post(`{{ route('admin.recharge.bank.config.update') }}`, {
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
                } = await axios.post('{{ route('admin.recharge.bank.delete') }}', {
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
