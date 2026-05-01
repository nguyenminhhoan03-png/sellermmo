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
    background-image: url('');
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
                Tiện ích lấy UID FB 
            </h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">UID FB</li>
                <li class="breadcrumb-item text-gray-500">Lấy UID FB</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="card">
            <div class="card-body pt-6">
                <form id="uid-form">
                    <div class="d-flex flex-column align-items-center justify-content-center min-vh-25 bg-danger dvr mb-5">
                        <h1 class="text-white font-weight-bold mb-3">Tìm kiếm UID FB</h1>
                        <p class="text-white mb-4">Bạn có thể lấy uid fb của bạn bằng cách nhập link</p>
                        <div class="input-group w-75 rounded">
                            <input type="text" id="uid-input"  class="form-control" placeholder="Nhập nhập link fb của bạn vào đây" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-warning font-weight-bold">KIỂM TRA</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
           <div class="card-body p-5 px-lg-19 py-lg-16">
                <div class="mb-14 ">  
                    <div class="mb-5">
                        <h1 class="fs-2x text-gray-900 mb-6">Thông tin FB</h1>
                        <div class="fs-5 fw-semibold text-danger">Công cụ lấy uid fb bằng link fb nhanh chóng</div>   
                    </div>  
                <div class="mb-14"> 
                    <div class="table-responsive">
                        <table id="muabanwebsite" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <tbody id="results-body" class="border-bottom border-dashed">
                             <tr>
                                <th>Link FB</th>
                                <td>-</td>
                             </tr>
                             <tr>
                                <th>UID:</th>
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
document.getElementById('uid-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const uidInput = document.getElementById('uid-input').value.trim();

    const resultsBody = document.getElementById('results-body');

    resultsBody.innerHTML = `
        <tr>
            <td colspan="2" class="text-start ps-6 fs-4">
                <span class="loading-spinner"></span> Đang kiểm tra...
            </td>
        </tr>
    `;
    fetch(`/api/infofb?uidfb=${encodeURIComponent(uidInput)}`)
        .then(response => response.json())
        .then(data => {
            resultsBody.innerHTML = '';
            if (data.status === 200) {
            const newRow = `<tr>
                                <th>Link FB</th>
                                <td class="text-primary">${uidInput}</td>
                             </tr>
                             <tr>
                                <th>UID:</th>
                                <td id="copyuid" class="text-danger">${data.data.id} <button type="button" data-clipboard-target="#copyuid" class="copy btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light" onclick="copy()">
                                            <i class="ki-duotone ki-copy fs-2"></i>
                                        </button></td>
                             </tr>
                             `;
                resultsBody.innerHTML = newRow;
          } else {
            const newRow = `<tr>
                                <th>Link FB</th>
                                <td><span class="badge badge-danger text-center">không tìm thấy UID</span></td>
                             </tr>
                             <tr>
                                <th>UID:</th>
                                <td><span class="badge badge-danger text-center">không tìm thấy UID</span></td>
                             </tr>
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
