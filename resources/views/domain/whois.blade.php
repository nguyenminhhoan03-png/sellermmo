@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@php use App\Models\Domain; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<style>
.min-vh-25 {
    min-height: 25vh !important;
}
.dvr {
    border-radius: 15px;
}    
    .bg-primary {
    background-color: #0056b3;
}

.input-group .form-control {
    border-radius: 15px;
    height: 50px;
}

.input-group .btn {
    height: 50px;
    border-radius: 0 15px 15px 0;
}

.bg-primary {
    background-image: url('https://inet.vn/public/img/svg/whois-domain-bg.svg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
.loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
.table-responsive {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    th, td {
        white-space: nowrap;
    }
   
</style>
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Kiểm tra trạng thái tên miền
            </h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">Domain</li>
                <li class="breadcrumb-item text-gray-500">Kiểm tra tên miền</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="card">
            <div class="card-body pt-6">
                <form id="domain-form">
                    <div class="d-flex flex-column align-items-center justify-content-center min-vh-25 bg-primary dvr mb-5">
                        <h1 class="text-white font-weight-bold mb-3">Kiểm tra tên miền</h1>
                        <p class="text-white mb-4">Bảo vệ thương hiệu của bạn trên Internet</p>
                        <div class="input-group w-75 rounded">
                            <input type="text" id="domain-input"  class="form-control" placeholder="Nhập tên miền hoặc từ khóa bạn muốn kiểm tra" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-warning font-weight-bold">KIỂM TRA</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
           <div class="card-body p-5 px-lg-19 py-lg-16">
                <div class="mb-14 ">  
                    <div class="mb-5">
                        <h1 class="fs-2x text-gray-900 mb-6">Thông tin WHOIS tên miền</h1>
                        <div class="fs-5 fw-semibold text-danger">Công cụ whois, kiểm tra, tra cứu thông tin tên miền</div>   
                    </div>  
                <div class="mb-14"> 
                    <div class="table-responsive">
                        <table id="muabanwebsite" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <tbody id="results-body" class="border-bottom border-dashed">
                             <tr>
                                <th>Tên miền</th>
                                <td>-</td>
                             </tr>
                             <tr>
                                <th>Ngày đăng ký:</th>
                                <td>-</td>
                             </tr>
                             <tr>
                                <th>Ngày hết hạn:</th>
                                <td>-</td>
                             </tr>
                             <tr>
                                <th>Chủ sở hữu tên miền:</th>
                                <td>-</td>
                             </tr>
                             <tr>
                                <th>Cờ trạng thái:</th>
                                <td>-</td>
                             </tr>
                             <tr>
                                <th>Quản lý tại Nhà đăng ký:</th>
                                <td>-</td>
                             </tr>
                             <tr>
                                <th>Nameservers:</th>
                                <td>-</td>
                             </tr>
                             <tr>
                                <th>DNSSEC:</th>
                                <td>-</td>
                             </tr>
                        </tbody>
                        </table>
                    </div> 
                </div>
                </div>
               
                     </div>
                </div>
            </div>
        </div>
</div>
<script>
document.getElementById('domain-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const domainInput = document.getElementById('domain-input').value.trim();

    if (domainInput.startsWith('http://') || domainInput.startsWith('https://') || domainInput.endsWith('/')) {
        showMessage('Vui lòng loại bỏ "http://", "https://", và "/" ở cuối URL.', 'error');
        return;
    }

    const resultsBody = document.getElementById('results-body');

    resultsBody.innerHTML = `
        <tr>
            <td colspan="2" class="text-start ps-6 fs-4">
                <span class="loading-spinner"></span> Đang kiểm tra...
            </td>
        </tr>
    `;
    fetch(`/api/whois?domain=${encodeURIComponent(domainInput)}`)
        .then(response => response.json())
        .then(data => {
            resultsBody.innerHTML = '';
            if (data.code === "0") {
            const newRow = `<tr>
                                <th>Tên miền</th>
                                <td>${data.domainName}</td>
                             </tr>
                             <tr>
                                <th>Ngày đăng ký:</th>
                                <td>${data.creationDate}</td>
                             </tr>
                             <tr>
                                <th>Ngày hết hạn:</th>
                                <td>${data.expirationDate}</td>
                             </tr>
                             <tr>
                                <th>Chủ sở hữu tên miền:</th>
                                <td>${data.registrantName || '-'}</td>
                             </tr>
                             <tr>
                                <th>Cờ trạng thái:</th>
                                <td>${Array.isArray(data.status) ? data.status.join('<br>') : '-'}</td>
                             </tr>
                             <tr>
                                <th>Quản lý tại Nhà đăng ký:</th>
                                <td>${data.registrar || '-'}</td>
                             </tr>
                             <tr>
                                <th>Nameservers:</th>
                               <td>${Array.isArray(data.nameServer) ? data.nameServer.join('<br>') : '-'}</td>
                             </tr>
                             <tr>
                                <th>DNSSEC:</th>
                                <td>${data.DNSSEC || '-'}</td></td>
                             </tr>`;
                resultsBody.innerHTML = newRow;
          } else {
            const newRow = `<tr>
                                <th>Tên miền</th>
                                <td>${data.domainName}</td>
                             </tr>
                             <tr>
                                <th>Trang thái:</th>
                                <td class="text-success">Có thể đăng ký</td>
                             </tr>
                             <tr>
                                <th>Hành động:</th>
                                <td><a type="button" href="/domain/pay/${data.domainName}" class="btn btn-sm btn-danger rounded-6 hover-scale"><span id="button1" class="indicator-label">Mua ngay</span></a></td>
                             </tr>
                             <tr>
                            `;
                resultsBody.innerHTML = newRow;
          }
       })
        .catch(() => {
            resultsBody.innerHTML = `
                <tr>
                    <td class="text-danger" colspan="2">Lỗi kết nối, vui lòng thử lại sau.</td>
                </tr>
            `;
        });
});

</script>
@endsection
