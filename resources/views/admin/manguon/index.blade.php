@php use App\Helpers\Helper; @endphp
@extends('admin.layouts.master')
@section('title', 'Danh Sách Mã Nguồn')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="mb-3 text-end">
    <a href="/Cpanel/code/upload" class="btn btn-outline-primary me-2"><i class="fas fa-plus"></i> {{ __('Thêm mới') }}</a>
  </div>

  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">Danh sách Mã Nguồn</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('Tên Sản Phẩm') }}</th>
              <th>{{ __('Giá Sản Phẩm') }}</th>
              <th>{{ __('Ảnh Sản Phẩm') }}</th>
              <th>{{ __('View') }}</th>
              <th>{{ __('Đã Bán') }}</th>
              <th>{{ __('Kích Hoạt') }}</th>
              <th>{{ __('Giảm Giá') }}</th>
              <th>{{ __('Người Bán') }}</th>
              <th>{{ __('Ngày Đăng') }}</th>
              <th>{{ __('Trạng Thái') }}</th>
              <th>{{ __('Thao Tác') }}</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </div>
      
    </div>
  </div>

@endsection
@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        } = await axios.post('{{ route('admin.manguon.delete') }}', {
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

    axios.post(`/Cpanel/code/update-status`, {
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
      const $table = $('#datatable');
    
      const $tableOptions = {
        processing: true,
        serverSide: true,
        
        ajax: {
          url: '/api/Cpanel/code',
          type: 'GET',
          headers: {
            Authorization: `Bearer ${access_token}`,
          },
          data: (data) => {
            let payload = {};
            payload.page = data.start / data.length + 1;
            payload.limit = data.length;
            payload.search = data.search.value;
            payload.sort_by = data.columns[data.order[0].column].data;
            payload.sort_type = data.order[0].dir;
            return payload;
          },
          beforeSend: function(xhr) {
            $setLoading($('#btn_reload'));
          },
          error: function(xhr) {
            console.log(xhr?.responseJSON);
          },
          dataFilter: function(data) {
            let json = JSON.parse(data);
            if (json.status) {
              json.recordsTotal = json.data.meta.total;
              json.recordsFiltered = json.data.meta.total;
              json.data = json.data.data;
              return JSON.stringify(json);
            } else {
              Swal.fire('Thất bại', json.message, 'error');
              return JSON.stringify({
                recordsTotal: 0,
                recordsFiltered: 0,
                data: [],
              });
            }
          },
        },
        columns: [
            {
            data: 'id'
          },
            {
            data: 'name',
            render: (data) => {
              return $truncate(data, 60)
            }
          },
          { data: 'price', render: (data) => (data) },
          { data: 'images', render: (data) => `<img src="${data}" alt="image" style="max-width: 70px; border-radius: 10px;">` },
          { data: 'view'},
          { data: 'sold' },
          {
            data: 'status',
            render: (data, type, row) => {
              return `<div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault${row.id}" value="${row.id}" onchange="updateStatus(this)" ${data?'checked':''}>
                  <label class="form-check label" for="flexSwitchCheckDefault${row.id}"></label>
                </div>`
            }
          },
          { data: 'ck', render: (data) => (data)},
          { data: 'username', render: (data) => `<span class="badge bg-purple-gradient">${data}</span>`},
          { data: 'status', render: (data) =>  (data == 1 ? '<span class="badge bg-success">Đang hoạt động</span>' : '<span class="badge bg-danger">Không hoạt động</span>')},
          { data: 'created_at', render: (data) => (data) },
          {
            data: null,
            render: (data) => {
              return `<a href="/Cpanel/code/edit/${data.id}" class="badge bg-primary-gradient"><i class="fas fa-edit"></i></a>
              <a href="javascript:deleteRow(${data.id})" class="shadow text-white badge bg-danger-gradient"><i class="fa fa-trash"></i></a>`
            },
          },
        ],
        order: [
          [11, 'desc']
        ],
        lengthMenu: [
          [10, 20, 50, 100],
          [10, 20, 50, 100],
        ],
        pageLength: 10,
      };
    
      const $tableInstance = $table.DataTable($tableOptions);
    
      $tableInstance.on('draw.dt', function() {
        $removeLoading($('#btn_reload'));
        $('[data-bs-toggle="tooltip"]').tooltip();
      });
    });
  </script>
@endsection


