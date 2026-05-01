@php use App\Helpers\Helper; @endphp 
@php use App\Models\ApiLogo; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<style>
    .custom-card {
      margin-bottom: 50px;
    }
    .wid-90 {
    width: 90px;
    }
  </style>
<div class="toolbar d-flex flex-stack py-3 py-lg-5 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Cổng Nạp Tiền
            </h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">Recharge</li>
                <li class="breadcrumb-item text-gray-500">Thẻ Cào</li>
            </ul>
        </div>
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="col-xl-12 mb-5">
            <div class="alert alert-primary d-flex align-items-center p-5">
                <i class="bi bi-megaphone-fill fs-2x me-5 text-primary"></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-dark">Thông Báo:</h4>
                    {!! base64_decode(Helper::getNotice('page_deposit_card')) !!}
                </div>
            </div>
          </div>
          <div class="row mb-5">
            <div class="col-sm-12 mb-5">
                <div class="row g-3">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card shadow">
                            <div class="ribbon-box">
                                <div class="card-body">
                                    <button type="button" class="btn btn-sm btn-primary float-end mb-5" data-bs-toggle="modal" data-bs-target="#kt_modal_scrollable_2">
                                        Xem hướng dẫn
                                    </button>
                                    <form id="form-sendcard" action="{{ route('recharge-card') }}" method="POST">
                                    @csrf
                                    <input type="hidden" id="telco" name="telco" value="">
                                    <div class="col-12 my-3">
                                        
                                        <h5 class="mb-3 mt-4">Mệnh giá</h5>
                                        <select class="form-select" data-control="select2" data-placeholder="Select an option" id="amount" name="amount">
                                            <option class="d-block h6 mb-0" disabled="" selected="">-- Chọn mệnh giá --</option>
                                            <option value="10000">10,000đ</option>
                                            <option value="20000">20,000đ</option>
                                            <option value="30000">30,000đ</option>
                                            <option value="50000">50,000đ</option>
                                            <option value="100000">100,000đ</option>
                                            <option value="200000">200,000đ</option>
                                            <option value="300000">300,000đ</option>
                                            <option value="500000">500,000đ</option>
                                            <option value="1000000">1,000,000đ</option>
                                        </select>
                                    </div>

                                    <h5 class="mb-3 mt-4">Chọn loại thẻ</h5>
                                    <div class="row">
                                        <div class="mb-3 col-6 col-md-3 col-xxl-2">
                                            <div class="recharge-type__item shadow-sm">
                                                <div class="recharge-type__img">
                                                    <input type="radio" name="card_type" hidden="" value="VIETTEL">
                                                    <img alt="img" class="img-fluid ms-1 wid-90" src="/assets/media/thecao/viettel.svg">
                                                </div>
                                                <div class="recharge-type__arrow"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6 col-md-3 col-xxl-2">
                                            <div class="recharge-type__item shadow-sm">
                                                <div class="recharge-type__img">
                                                    <input type="radio" name="card_type" hidden="" value="VINAPHONE">
                                                    <img alt="img" class="img-fluid ms-1 wid-90" src="/assets/media/thecao/vinaphone.svg">
                                                </div>
                                                <div class="recharge-type__arrow"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6 col-md-3 col-xxl-2">
                                            <div class="recharge-type__item shadow-sm">
                                                <div class="recharge-type__img">
                                                    <input type="radio" name="card_type" hidden="" value="MOBIFONE">
                                                    <img alt="img" class="img-fluid ms-1 wid-90" src="/assets/media/thecao/mobifone.svg">
                                                </div>
                                                <div class="recharge-type__arrow"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6 col-md-3 col-xxl-2">
                                            <div class="recharge-type__item shadow-sm">
                                                <div class="recharge-type__img">
                                                    <input type="radio" name="card_type" hidden="" value="VNMOBI">
                                                    <img alt="img" class="img-fluid ms-1 wid-90" src="/assets/media/thecao/vietnamobile.svg">
                                                </div>
                                                <div class="recharge-type__arrow"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6 col-md-3 col-xxl-2">
                                            <div class="recharge-type__item shadow-sm">
                                                <div class="recharge-type__img">
                                                    <input type="radio" name="card_type" hidden="" value="GARENA">
                                                    <img alt="img" class="img-fluid ms-1 wid-90" src="/assets/media/thecao/garena.svg">
                                                </div>
                                                <div class="recharge-type__arrow"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6 col-md-3 col-xxl-2">
                                            <div class="recharge-type__item shadow-sm">
                                                <div class="recharge-type__img">
                                                    <input type="radio" name="card_type" hidden="" value="ZING">
                                                    <img alt="img" class="img-fluid ms-1 wid-90" src="/assets/media/thecao/zing.svg">
                                                </div>
                                                <div class="recharge-type__arrow"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <h5 class="mb-3 mt-4">Số Serial</h5>
                                            <div class="input-left mb-3">
                                                <input name="serial" id="serial" type="number" class="form-control" placeholder="Nhập số serial thẻ cào vào đây..." autocomplete="off" autocapitalize="none">
                                                
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <h5 class="mb-3 mt-4">Mã thẻ cào</h5>
                                            <div class="input-left mb-3">
                                                <input name="code" id="code"  type="number" class="form-control" placeholder="Nhập mã thẻ cào vào đây..." autocomplete="off" autocapitalize="none">
                                                
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid gap-2 mt-2">
                                                <button class="btn btn-primary btn-shadow" type="submit" id="btnNapThe">
                                                    <svg class="feather feather-shopping-cart" height="24" width="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="9" cy="21" r="1"></circle>
                                                        <circle cx="20" cy="21" r="1"></circle>
                                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                                    </svg>  NẠP NGAY</button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input
                                    type="text"
                                    data-kt-customer-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-12"
                                    placeholder="Tìm kiếm giao dịch"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    
                                    <th class="min-w-125px">
                                        Nhà mạng
                                    </th>
                                    <th class="min-w-125px">
                                        Serial
                                    </th>
                                    <th class="min-w-125px">
                                        Pin
                                    </th>
                                    <th class="min-w-125px">
                                        Mệnh giá
                                    </th>
                                    <th class="min-w-125px"> 
                                        Thực nhận
                                    </th>
                                    <th class="min-w-125px">
                                        Trạng thái
                                    </th>
                                    <th class="min-w-125px">
                                        Ngày nạp
                                    </th>
                                    <th class="min-w-125px">
                                        Ghi chú
                                    </th>
                                </tr>
                                
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach($hiscard as $hiscards)
                                <tr>
                                    
                                    <td>
                                        {{ $hiscards->type }}
                                    </td>
                                    <td>
                                        {{ $hiscards->serial }}
                                    </td>
                                    <td data-filter="mb">
                                        {{ $hiscards->code }}
                                    </td>
                                    <td>
                                       {{ number_format($hiscards->value) }}đ
                                    </td>
                                    <td>
                                       {{ number_format($hiscards->amount) }}đ
                                    </td>
                                    <td>
                                       {!! Helper::statuscard($hiscards->status) !!}
                                    </td>
                                    <td>
                                       {{ $hiscards->created_at}}
                                    </td>
                                    <td>
                                       {{ $hiscards->sys_note}}
                                    </td>
                                   
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="kt_modal_scrollable_2">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hướng dẫn cách nạp thẻ</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <p><b>Bước 1:</b> Các bạn hãy lựa chọn <strong>Mệnh Giá</strong> mà mình cần nạp và nhập đầy đủ thông tin thẻ cào như: <strong>Loại thẻ cào, Số Serial</strong>. Sau đó ấn vào nút <a class="badge badge-danger">NẠP NGAY</a>
                    <p><b>Lưu ý: </b>Mệnh giá thẻ phải khớp với mệnh giá được chúng tôi đưa ra. (Ví dụ: Bạn chọn <strong>100.000đ</strong> mệnh giá của chúng tôi đưa ra là <strong>100.000đ</strong> bạn phải dùng thẻ cào có <strong>MỆNH GIÁ 100.000đ</strong> để nạp)
                        <hr><mark style=display:block><strong>Sau khi nạp xong bạn có thể vô lịch sử để kiểm trang trạng thái của thẻ</strong></mark>
                        <hr>
                    <div class="carousel slide" id=carouselExampleIndicators data-bs-ride=carousel>
                        <ol class=carousel-indicators>
                            <li class=active data-bs-slide-to=0 data-bs-target=#carouselExampleIndicators>
                        </ol>
                        <div class=carousel-inner>
                            <div class="active carousel-item"><img alt="First slide" class="d-block img-fluid w-100" src="/assets/media/thecao/thecao.png"></div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng thông báo</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const rechargeItems = document.querySelectorAll('.recharge-type__item');

    rechargeItems.forEach(item => {
        item.addEventListener('click', () => {
            rechargeItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            const cardType = item.querySelector('input[name="card_type"]').value;
            document.getElementById('telco').value = cardType;
        });
    });

    $(document).ready(function() {
        $('#row-callback').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function() {

      $("#form-sendcard").submit(function(e) {
        e.preventDefault();
        onSubmit();
      });

      $("#amount").change();
    });

    const onSubmit = async () => {

      let form = document.getElementById('form-sendcard');

      const payload = {

        telco: $("#telco").val(),
        amount: $("#amount").val(),
        serial: $("#serial").val(),
        code: $("#code").val(),
      };

      if (!payload.serial || !payload.code) {
        return Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '{{ ('Vui lòng nhập đầy đủ thông tin') }}',
        });
      }

      Swal.fire({
        icon: 'info',
        title: 'Processing...',
        text: '{{ ('Vui lòng đợi xử lý, không được tắt trang!') }}',
        padding: '2em',
        customClass: 'sweet-alerts',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading()
        },
      })

      try {
        const {
          data: result
        } = await axios.post(form.action, payload);

        Swal.fire({
          icon: 'success',
          title: 'Great!',
          text: result.message,
        }).then(() => {
          window.location.reload()
        })
      } catch (error) {

        const errors = error?.response?.data?.errors || null;

        Swal.fire({
        title: 'Error',
        text: error.response?.data?.message || 'Có lỗi xảy ra. Vui lòng thử lại.',
        icon: 'error',
        confirmButtonText: 'OK',
      });

        }
    }
  </script>
@endsection
