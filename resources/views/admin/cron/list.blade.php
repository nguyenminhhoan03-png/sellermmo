@php use App\Helpers\Helper; @endphp
@extends('admin.layouts.master')
@section('title', 'Danh sách thuê cron')
@section('css')
<link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

<link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')


<div class="card custom-card">
  <div class="card-header justify-content-between">
    <div class="card-title">Danh sách tên miền</div>
  </div>
  <div class="card-body">
    <div class="table-responsive theme-scrollbar" style="padding: 10px">
      <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
        <thead>
          <tr>
            <th>#</th>
            <th class="text-center">
              <div class="form-check form-check-md d-flex align-items-center">
                  <input type="checkbox" class="form-check-input" name="check_all" id="check_all_checkbox" value="option1">
              </div>
          </th>
            <th>{{ __('Tên người mua') }}</th>
            <th>{{ __('Link Cron') }}</th>
            <th>{{ __('Cấu hình') }}</th>
            <th>{{ __('Máy chủ') }}</th>
            <th>{{ __('Trạng Thái') }}</th>
            <th>{{ __('Thực hiện lần cuối') }}</th>
            <th>{{ __('Thời Gian') }}</th>
            <th>{{ __('Thao Tác') }}</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
          <tr><td colspan="10" rowspan="1">
                  <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-list">
                          <button type="button" id="btn_pause" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Tạm dừng các link đã chọn">
                              <i class="fa-solid fa-pause"></i> Tạm dừng </button>
                          <button type="button" id="btn_active" data-bs-toggle="tooltip" class="btn btn-info btn-sm" title="Kích hoạt các link đã chọn">
                              <i class="fa-solid fa-play"></i> Kích hoạt </button>
                      </div>
                      <div class="text-right">
                          Doanh thu: <strong style="color:red;">{{number_format($total) }}đ</strong>

                      </div>
                  </div>
              </td></tr>
      </tfoot>
      </table>
    </div>

  </div>
</div>
@foreach ($hethan as $value)
<div class="modal fade" id="modal-giahan-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cập nhật đơn hàng #{{ $value->trans_id }}</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.cron.list.giahan') }}" class="axios-form1" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="url" class="form-label">Link Cron</label>
            <input class="form-control text-danger" value="{{ $value->url }}" name="url" disabled>
          </div>
          <input type="hidden" name="id" id="id" value="{{ $value->id }}">
          <div class="mb-3">
            <label for="month" class="form-label">Thời Gian</label>
            <select class="form-control" id="month" name="month">
              <option value="1" selected>1 Tháng</option>
              <option value="2">2 Tháng</option>
              <option value="3">3 Tháng</option>
              <option value="4">4 Tháng</option>
              <option value="5">5 Tháng</option>
              <option value="6">6 Tháng</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="action" class="form-label">Hành động</label>
            <select class="form-control" id="action" name="action">
              <option value="1" selected>Trừ tiền user</option>
              <option value="0">Không trừ tiền</option>
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
   $("[name=check_all]").change(function(e) {
      if ($(this).is(":checked")) {
        $("[name='checkbox']").prop("checked", true)
      } else {
        $("[name='checkbox']").prop("checked", false)
      }
    })
  $("#btn_active").click(function() {
      var checkboxes = document.querySelectorAll('input[name="checkbox"]:checked');
      if (checkboxes.length === 0) {
          showMessage('Vui lòng tích vào link cần Kích hoạt.', 'error');
          return;
      }
      Swal.fire({
          title: "Bạn có chắc không?",
          text: "Hệ thống Kích hoạt " + checkboxes.length +
              " link bạn chọn khi nhấn Đồng Ý",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Đồng ý",
          cancelButtonText: "Đóng"
      }).then((result) => {
          if (result.isConfirmed) {
              active_records();
          }
      });
  });
  
  function active_records() {
      var checkbox = document.getElementsByName('checkbox');
  
      function postUpdatesSequentially(index) {
          if (index < checkbox.length) {
              if (checkbox[index].checked === true) {
                  post_active(checkbox[index].value);
              }
              setTimeout(function() {
                  postUpdatesSequentially(index + 1);
              }, 100);
          } else {
              Swal.fire({
                  title: "Thành công!",
                  text: "Kích hoạt thành công",
                  icon: "success"
              });
              setTimeout(function() {
                  location.reload();
              }, 100000);
          }
      }
      postUpdatesSequentially(0);
  }
  
  function post_active(id) {
      showLoading();
      $.ajax({
          url: "{{ route('admin.cron.list.action') }}",
          method: "POST",
          dataType: "JSON",
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
          data: {
              id: id,
              action: 'activeCron'
          },
          success: function(result) {
              Swal.close();
              if (result.status == '200') {
                  showMessage(result.msg, result.status);
              } else {
                  showMessage(result.msg, result.status);
              }
          },
          error: function() {
              alert(html(response));
              location.reload();
          }
      });
  }
  
  function activeCron(id) {
      $('#btnActive' + id).html('<span><i class="fa fa-spinner fa-spin"></i></span>')
          .prop('disabled', true);
      post_active(id);
      setTimeout(() => {
          location.reload();
      }, 100);
  }
</script>
<script>
  $("#btn_pause").click(function() {
      var checkboxes = document.querySelectorAll('input[name="checkbox"]:checked');
      if (checkboxes.length === 0) {
          showMessage('Vui lòng tích vào link cần Tạm dừng.', 'error');
          return;
      }
      Swal.fire({
          title: "Bạn có chắc không?",
          text: "Hệ thống tạm dừng " + checkboxes.length +
              " link bạn chọn khi nhấn Đồng Ý",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Đồng ý",
          cancelButtonText: "Đóng"
      }).then((result) => {
          if (result.isConfirmed) {
              pause_records();
          }
      });
  });
  
  function pause_records() {
      var checkbox = document.getElementsByName('checkbox');
  
      function postUpdatesSequentially(index) {
          if (index < checkbox.length) {
              if (checkbox[index].checked === true) {
                  post_pause(checkbox[index].value);
              }
              setTimeout(function() {
                  postUpdatesSequentially(index + 1);
              }, 100);
          } else {
              Swal.fire({
                  title: "Thành công!",
                  text: "Tạm dừng thành công",
                  icon: "success"
              });
              setTimeout(function() {
                  location.reload();
              }, 1000);
          }
      }
      postUpdatesSequentially(0);
  }
  
  function post_pause(id) {
      showLoading();
      $.ajax({
         
        url: "{{ route('admin.cron.list.action') }}",
          method: "POST",
          dataType: "JSON",
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
          data: {
              id: id,
              action: 'pauseCron'
          },
          success: function(result) {
              Swal.close();
              if (result.status == '200') {
                  showMessage(result.msg, result.status);
              } else {
                  showMessage(result.msg, result.status);
              }
          },
          error: function() {
              alert(html(response));
              location.reload();
          }
      });
  }
  
  function pauseCron(id) {
      $('#btnPause' + id).html('<span><i class="fa fa-spinner fa-spin"></i></span>')
          .prop('disabled', true);
      post_pause(id);
      setTimeout(() => {
          location.reload();
      }, 100);
  }
</script>  
<script>
 $(document).on('submit', '.axios-form1', async function(e) {
  e.preventDefault();

  let form = $(this);
  let url = form.attr('action');
  let method = form.attr('method');
  let data = form.serialize();

  pageOverlay.show();

  axios({
    method: method,
    url: url,
    data: data
  }).then(function(response) {
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: response.data.message,
    }).then(() => {
      $tableInstance.draw();
      handleModal(response.data.data.id, $('#modal-giahan-' + response.data.data.id));
    });
  }).catch(function(error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: $catchMessage(error),
    });
  }).finally(() => {
    pageOverlay.hide();
  });
});
  const deleteRow = async (id) => {
    const confirmDelete = await Swal.fire({
      title: '{{ __('Bạn có chắc không?') }}',
      text: "{{ __('Hệ thống sẽ xóa Link CRON này nếu bạn nhấn Xóa') }}",
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
      } = await axios.post('{{ route('admin.cron.list.delete') }}', {
        id
      })

      Swal.fire('Thành công', result.message, 'success').then(() => {
        window.location.reload();
      })
    } catch (error) {
      Swal.fire('Thất bại', $catchMessage(error), 'error')
    }
  }
  function getStatusNotiCronAdmin(khanhdz) {
    let result = '';

    if (khanhdz === 'Đang chạy 200') {
      result = '<span class="badge bg-success" data-bs-toggle="tooltip" title="OK">Success 200</span>';
    } else if (khanhdz === '200') {
      result = '<span class="badge bg-success" data-bs-toggle="tooltip" title="OK">Success 200</span>';
    } else if (khanhdz === 'Đang được đưa vào đơn chạy lại') {
      result = '<span class="badge bg-success" data-bs-toggle="tooltip" title="OK">Đang được đưa vào đơn chạy lại</span>';
    } else if (khanhdz === 'Đang dừng xe') {
      result = '<span class="badge bg-warning" data-bs-toggle="tooltip" title="OK">' + khanhdz + '</span>';
    } else if (khanhdz === 'Ngưng chạy') {
      result = '<span class="badge bg-warning" data-bs-toggle="tooltip" title="OK">' + khanhdz + '</span>';
    } else if (khanhdz === 'Đang Xử Lý') {
      result = '<span class="badge rounded-full bg-primary-gradient" data-bs-toggle="tooltip" title="Đang chờ xử lý"><i class="fa fa-spinner fa-spin"></i> Chờ</span>';
    } else {
      result = '<span class="badge bg-danger" data-bs-toggle="tooltip" title="OK">Error ' + khanhdz + '</span>';
    }

    return result;
  }
  function getStatusCronAdmin(khanhdz) {
    let result = '';

    if (khanhdz === 'hoatdong') {
      result = "<label class='badge bg-success'>Đang chạy</label>";
    } else if (khanhdz === 'tamdung') {
      result = "<label class='badge bg-danger'>Tạm Dừng</label>";
    } else if (khanhdz === 'loi') {
      result = "<label class='badge bg-warning'>Lỗi</label>";
    } else if (khanhdz === 'baotri') {
      result = "<label class='badge bg-warning'>Bảo Trì</label>";
    } else if (khanhdz === 'hethan') {
      result = "<label class='badge rounded-full bg-secondary-gradient'>Hết Hạn</label>";
    }

    return result;
  }


  $(document).ready(function () {
    const $table = $('#datatable');

    const $tableOptions = {
      processing: true,
      serverSide: true,

      ajax: {
        url: '/api/Cpanel/cron',
        type: 'GET',
        headers: {
          Authorization: `Bearer ${access_token}`,
        },
        data: (data) => {
          return {
            page: data.start / data.length + 1,
            limit: data.length,
            search: data.search.value,
            sort_by: data.columns[data.order[0].column].data,
            sort_type: data.order[0].dir,
          };
        },
        beforeSend: function (xhr) {
          $setLoading($('#btn_reload'));
        },
        error: function (xhr) {
          console.error(xhr?.responseJSON);
          Swal.fire('Lỗi', 'Không thể tải dữ liệu, vui lòng thử lại sau.', 'error');
        },
        dataFilter: function (data) {
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
            data: null,
            render: (data, type, row) => {
              return `<input type="checkbox" class="form-check-input checkbox" data-id="${row.id}" name="checkbox" value="${row.id}">`
            },
            sortable: false,
          },
        {
          data: null,
          render: (data) => {
            if (data && data.user_name && data.user_id) {
              return `<a class="text-primary" href="/Cpanel/user-edit/${data.user_id}">${data.user_name} [ID ${data.user_id}]</a>`;
            }
            return '';
          },
          className: 'text-center',
        },
        { data: 'url', render: (data) => `<small><strong>${data}</strong></small>` },
        {
          data: null,
          render: (data) =>
            `Vòng lặp: <strong>${data.second}</strong> giây<br>Method: <strong>GET</strong>`,
        },
        {
          data: null,
          render: (data) =>
            `<a class="text-primary" href="/Cpanel/cron" target="_blank"><i class="fa-solid fa-pen-to-square me-1"></i>${data.server_name}</a>`,
          className: 'text-center',
        },
        {
          data: 'status',
          render: (data) => `${getStatusCronAdmin(data)}`,
          className: 'text-center',
        },
        {
          data: null,
          render: (data) =>
            `<strong data-bs-toggle="tooltip" title="${data.time_his}"><small>${data.time_his_ago}</small></strong><br>
           ${getStatusNotiCronAdmin(data.response)}`,
          className: 'text-center',
        },
        {
          data: null,
          render: (data) =>
            `Ngày tạo: <strong data-bs-toggle="tooltip" title="${data.created_time_ago}"><small><i class="fa-solid fa-calendar"></i>${data.created_at}</small></strong><br>
           Hết hạn: <strong data-bs-toggle="tooltip" title="${data.expired_timestamp_ago}"><small><i class="fa-solid fa-calendar-days"></i>${data.expired_date}</small></strong>`,
          className: 'text-center',
        },
        {
          data: null,
          render: (data) => {
            if (data && data.status === "tamdung") {
              return `
        <button type="button" class="btn btn-info btn-sm" onclick="activeCron(${data.id})">
          <i class="fa-solid fa-play"></i>
        </button>
        <a type="button" href="/Cpanel/cron/list/edit/${data.id}" class="btn btn-primary btn-sm">
          <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(${data.id})">
          <i class="fa-solid fa-trash"></i>
        </button>`;
            } else if (data && data.status === "hoatdong") {
              return `
        <button type="button" class="btn btn-danger btn-sm" onclick="pauseCron(${data.id})">
          <i class="fa-solid fa-pause"></i>
        </button>
        <a type="button" href="/Cpanel/cron/list/edit/${data.id}" class="btn btn-primary btn-sm">
          <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(${data.id})">
          <i class="fa-solid fa-trash"></i>
        </button>`;
            } else if (data && data.status === "hethan") {
              return `
        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-effect="effect-scale" data-bs-target="#modal-giahan-${data.id}"">
          <i class="fa-solid fa-clock-rotate-left"></i>
        </button>
        <a type="button" href="/Cpanel/cron/list/edit/${data.id}" class="btn btn-primary btn-sm">
          <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(${data.id})">
          <i class="fa-solid fa-trash"></i>
        </button>`;
            } else {
              return `
        <button type="button" class="btn btn-danger btn-sm" onclick="pauseCron(${data.id})">
          <i class="fa-solid fa-pause"></i>
        </button>
        <a type="button" href="/Cpanel/cron/list/edit/${data.id}" class="btn btn-primary btn-sm">
          <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(${data.id})">
          <i class="fa-solid fa-trash"></i>
        </button>`;
            }
            return '';
          },
        }

      ],

      order: [[0, 'desc']],
      lengthMenu: [
        [10, 20, 50, 100],
        [10, 20, 50, 100],
      ],
      pageLength: 10,
    };

    const $tableInstance = $table.DataTable($tableOptions);

    $tableInstance.on('draw.dt', function () {
      $removeLoading($('#btn_reload'));
      $('[data-bs-toggle="tooltip"]').tooltip();
    });
  });

</script>
@endsection