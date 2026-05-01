@php use App\Helpers\Helper; @endphp 
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Thuê Cron
            </h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">{{ $user->name }}</li>
                <li class="breadcrumb-item text-gray-500">Thuê Cron</li>
            </ul>
        </div>
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
            <div class="row">
                <div class="col-lg-6 mb-5">
                     <div class="card w-100">
                       <div class="card-header">
                         <h4 class="mb-0 card-title">Cấu hình & Server</h4>
                       </div>
                       <div class="card-body">
                        <form id="formCron" action="{{ route('cronjob.index.post') }}" method="POST">
                          @csrf
                          <div class="mb-4 row align-items-center">
                              <label for="url" class="required form-label">Link Cron</label>
                              <div class="input-group">
                                  <input type="text" id="url" name="url" class="form-control form-control-solid" value="" placeholder="Nhập link cron"/>
                              </div>
                          </div>
                          <div class="mb-4 row align-items-center">
                              <label for="sogiay" class="required form-label">Vòng lặp</label>
                              <div class="input-group">
                                  <input type="number" id="sogiay" name="sogiay" class="form-control" placeholder="60" aria-label="60" aria-describedby="basic-addon2"/>
                                  <span class="input-group-text" id="basic-addon2">giây</span>
                              </div>
                          </div>
                          <div class="mb-4 row align-items-center">
                              <label for="server" class="required form-label">Máy chủ</label>
                              <div class="input-group">
                                  <select class="form-select form-select-solid" id="server" name="server" onchange="updatePrice()" data-control="select2" data-dropdown-css-class="w-200px" data-placeholder="Vui lòng chọn máy chủ" data-hide-search="true">
                                      <option></option>
                                      @foreach ($server as $value)
                                          <option value="{{ $value->id }}">{{ $value->name }} tối thiểu {{ $value->limit_second }} giây</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="mb-4 row align-items-center">
                              <label for="thoigiangiahan" class="required form-label col-sm-3 col-form-label">Thời Gian</label>
                              <div class="input-group">
                                  <div class="input-group flex-nowrap">
                                      <span class="input-group-text">
                                          <i class="ki-duotone ki-notepad-bookmark fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
                                      </span>
                                      <div class="overflow-hidden flex-grow-1">
                                          <select class="form-select rounded-start-0" id="thoigiangiahan" name="thoigiangiahan" onchange="updatePrice()" data-control="select2" data-placeholder="Chọn thời gian sử dụng">
                                              <option></option>
                                              <option value="1" selected>1 Tháng</option>
                                              <option value="2">2 Tháng</option>
                                              <option value="3">3 Tháng</option>
                                              <option value="4">4 Tháng</option>
                                              <option value="5">5 Tháng</option>
                                              <option value="6">6 Tháng</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      
                          <div class="mb-3"><p>Giá <span class="text-info" id="selected-months">1 tháng</span> : <span class="text-danger" id="price">0₫</span></p> </div>
                          <button id="btnThueCron" type="submit" class="btn btn-danger w-100">Thanh Toán</button>
                      </form>
                      
                       </div>
                     </div>
                   </div>
                   <div class="col-lg-6">
                     <div class="card w-100">
                       <div class="card-header text-bg-danger">
                         <h4 class="mb-0 text-white card-title">Lưu Ý</h4>
                       </div>
                      <div class="card-body">
                         <h3 class="card-title">Hướng Dẫn Sử Dụng CRON</h3>
                         <p>Để đảm bảo hệ thống CRON hoạt động ổn định và đúng mục đích, vui lòng tuân thủ các hướng dẫn dưới đây:</p>

                         <h2>1. Không kích hoạt Firewall cho các liên kết CRON</h2>
                         <p>Việc bật Firewall có thể gây gián đoạn hoạt động của hệ thống và ngăn cản CRON thực hiện các nhiệm vụ được chỉ định. Hãy đảm bảo Firewall được cấu hình phù hợp hoặc vô hiệu hóa đối với các liên kết CRON.</p>
                     
                         <h2>2. Sử dụng hệ thống CRON đúng mục đích</h2>
                         <p>Hệ thống CRON chỉ được sử dụng cho các mục đích hợp lệ và đúng quy định. Chúng tôi có quyền tạm ngừng hoặc hủy vĩnh viễn các liên kết CRON vi phạm chính sách.</p>
                     
                         <h2>3. Cung cấp chính xác liên kết CRON</h2>
                         <p>Để hệ thống hoạt động hiệu quả, vui lòng đảm bảo đường dẫn liên kết CRON được nhập đầy đủ và chính xác.</p>
                     
                         <h2>4. Câu hỏi thường gặp (FAQ)</h2>
                         <p>Nếu gặp lỗi hoặc cần hỗ trợ trong quá trình sử dụng, vui lòng tham khảo <a href="#" target="_blank">tài liệu hướng dẫn chi tiết tại đây</a>.</p>
                     
                       </div>
                     </div>
                   </div>
                   </div>
    </div>
</div> 
<script>
 function updatePrice() {
    const serverId = document.getElementById('server') ? document.getElementById('server').value : null;
    const months = document.getElementById('thoigiangiahan') ? document.getElementById('thoigiangiahan').value : null;
    if (!serverId || !months) {
        return; 
    }
    const packages = [
      @foreach($server as $servers)
        { id: {{ $servers->id }}, price: {{ $servers->price - ($servers->price * ($servers->ck / 100)) }} },
      @endforeach  
    ];
    const selectedPackage = packages.find(pkg => pkg.id === Number(serverId));
    const pricePerMonth = selectedPackage ? selectedPackage.price : 0;
    const totalPrice = pricePerMonth * months;
    const priceElement = document.getElementById('price');
    const selectedMonthsElement = document.getElementById('selected-months');
    if (selectedMonthsElement) {
        selectedMonthsElement.textContent = months + " tháng";
    }

    if (priceElement) {
        priceElement.textContent = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(totalPrice);
    }
}
  </script>
<script src="/assets/plugins/global/plugins.bundle.js"></script>
  <script src="/assets/js/scripts.bundle.js?v={{ time() }}"></script>
<script src="/assets/js/custom/cron/cron.js?v={{ time() }}"></script>
@endsection