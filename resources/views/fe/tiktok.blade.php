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
.loading-indicator {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}
.loading-indicator.show {
    opacity: 1;
    visibility: visible;
}
.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #e41212;
    border-top-color: #fff1e7;
    border-radius: 50%;
    animation: spin 0.5s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
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
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl pt-10">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="row justify-content-center">
            <div class="col-lg-12 mb-5">
                <div class="card">
                    <div class="card-body text-center">
                        <p>TIKTOK</p>
                        <img src="{{ asset('assets/media/svg/brand-logos/tvit.svg') }}" alt="muabanwebsite" class="img-fluid mb-4" width="150">
                        <h5 class="fw-semibold fs-5 mb-2">Tải Video Tik Tok</h5>
                        <p class="mb-3 px-xl-5">Không logo, hình mờ, watermark.</p>
                        <form id="tiktok-form" class="mt-3 mb-2 col-lg-6 mx-auto">
                            <input type="text" class="form-control is-valid mb-3" id="link-input"  placeholder="Dán Link TikTok">
                            <button id="down" class="btn btn-primary">DOWNLOAD</button>
                        </form>             
                    </div>
                </div>
            </div>
    <div class="col-lg-12 mb-5" id="results-body">
            </div>
        </div>
    </div>
</div>
<script>
function downloadFile(url, filename) {
  fetch(url)
    .then(response => response.blob())
    .then(blob => {
      const link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = filename;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    })
    .catch(error => console.error('Lỗi tải xuống tệp:', error));
}
function formatNumberCompact(number) {
    return Intl.NumberFormat('en-US', {
        notation: "compact",
        maximumFractionDigits: 1
    }).format(number);
}
function convertTimestampToDate(timestamp) {
    var date = new Date(timestamp * 1000);
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    var formattedDate = day + '/' + month + '/' + year;
    return formattedDate;
}
document.getElementById('tiktok-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const uidInput = document.getElementById('link-input').value.trim();

    const resultsBody = document.getElementById('results-body');

    resultsBody.innerHTML = `<div id="loading-indicator" class="loading-indicator show">
            <div class="spinner">
            </div>
        </div>`;
    fetch(`/api/tiktok?link=${encodeURIComponent(uidInput)}`)
        .then(response => response.json())
        .then(data => {
            console.log('API response:', data);
            resultsBody.innerHTML = '';
            if (data.code === 0) {
                const playLink = data.data.play || '#';
                const musicLink = data.data.music || '#';
                const nickname = data.data.author.nickname || 'N/A';
                const unique_id = data.data.author.unique_id || 'N/A';
                const playCount = formatNumberCompact(data.data.play_count || 0);
                const diggCount = formatNumberCompact(data.data.digg_count || 0);
                const downloadCount = formatNumberCompact(data.data.download_count || 0);
                const createTime = convertTimestampToDate(data.data.create_time || 0);
            const newRow = `
            <div class="alert customize-alert alert-dismissible border-danger border-dashed text-success fade show remove-close-icon" role="alert">
                <div class="row d-flex justify-content-center align-items-center h-100">  
                  <div class="col-lg-3 mb-5">
                      <div class="card mb-lg-0">
                        <div class="card-body">
                          <h5 class="card-title mb-4">Phương Thức Tải</h5>
                           <li id="mp4" class="flex space-x-3 rtl:space-x-reverse">
                            <button onclick="downloadFile('${playLink}', 'dvr-tiktok.mp4')" type="button" class="btn waves-effect waves-light btn-success mb-2"> DOWNLOAD MP4</button>
                           </li>
                            <li id="mp3" class="flex space-x-3 rtl:space-x-reverse">
                                <button onclick="downloadFile('${musicLink}', 'dvr-tiktok.mp3')" type="button" class="btn waves-effect waves-light btn-danger mb-2"> DOWNLOAD MP3</button>
                            </li>
                        </div>
                      </div>
                  </div>
                    <div class="col-lg-4 mb-5">
                      <div class="card mb-lg-0">
                        <div class="card-body">
                          <h5 class="card-title mb-1">${nickname}</h5>
                          <span class="card-title mb-5">@${unique_id}</span>
                         <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th scope="col" class="fw-bold">Loại</th>
                                <th scope="col" class="fw-bold">Nội Dung</th>
                                
                              </tr>
                            </thead>
                            <tbody class="border-top">
                              <tr>
                                <th scope="row">
                                  <h6>
                                    <span class="badge text-bg-info">Lượt Xem</span>
                                  </h6>
                                </th>
                                <td>
                                  <p class="mb-0">${playCount}</p>
                                </td>
                                
                              </tr>
                              <tr>
                                <th scope="row">
                                  <h6>
                                    <span class="badge text-bg-info">Tim</span>
                                  </h6>
                                </th>
                                <td>
                                  <p class="mb-0">${diggCount}</p>
                                </td>
                                
                              </tr>
        
                              <tr>
                                <th scope="row">
                                  <h6>
                                    <span class="badge text-bg-info">Lượt Tải</span>
                                  </h6>
                                </th>
                                <td>
                                  <p class="mb-0">${downloadCount}</p>
                                </td>
                                
                              </tr>
                            <tr>
                                <th scope="row">
                                  <h6>
                                    <span class="badge text-bg-info">Ngày Đăng</span>
                                  </h6>
                                </th>
                                <td>
                                  <p class="mb-0">${createTime}</p>
                                </td>
                                
                              </tr></tbody>
                          </table>
                        </div>
                      </div>
                     </div>
                   <div class="col-lg-5 mb-5">
                      <div class="card mb-lg-0">
                        <div class="card-body">
                          <h5 class="card-title mb-4">View Video</h5>
                          <div id="video"><iframe src="${playLink}" width="100%" height="500" frameborder="0" allowfullscreen=""></iframe></div>
                          </div>
                        </div>
                     </div>
                  </div>
               </div>
            `;
                resultsBody.innerHTML = newRow;
          } else {
            const newRow = `<div class="col-12 text-center">
        <svg width="184" height="152" viewBox="0 0 184 152" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" fill-rule="evenodd">
                <g transform="translate(24 31.67)">
                    <ellipse fill-opacity=".8" fill="#F5F5F7" cx="67.797" cy="106.89" rx="67.797" ry="12.668"></ellipse>
                    <path d="M122.034 69.674L98.109 40.229c-1.148-1.386-2.826-2.225-4.593-2.225h-51.44c-1.766 0-3.444.839-4.592 2.225L13.56 69.674v15.383h108.475V69.674z" fill="#AEB8C2"></path>
                    <path d="M101.537 86.214L80.63 61.102c-1.001-1.207-2.507-1.867-4.048-1.867H31.724c-1.54 0-3.047.66-4.048 1.867L6.769 86.214v13.792h94.768V86.214z" fill="url(#linearGradient-1)" transform="translate(13.56)"></path>
                    <path d="M33.83 0h67.933a4 4 0 0 1 4 4v93.344a4 4 0 0 1-4 4H33.83a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4z" fill="#F5F5F7"></path>
                    <path d="M42.678 9.953h50.237a2 2 0 0 1 2 2V36.91a2 2 0 0 1-2 2H42.678a2 2 0 0 1-2-2V11.953a2 2 0 0 1 2-2zM42.94 49.767h49.713a2.262 2.262 0 1 1 0 4.524H42.94a2.262 2.262 0 0 1 0-4.524zM42.94 61.53h49.713a2.262 2.262 0 1 1 0 4.525H42.94a2.262 2.262 0 0 1 0-4.525zM121.813 105.032c-.775 3.071-3.497 5.36-6.735 5.36H20.515c-3.238 0-5.96-2.29-6.734-5.36a7.309 7.309 0 0 1-.222-1.79V69.675h26.318c2.907 0 5.25 2.448 5.25 5.42v.04c0 2.971 2.37 5.37 5.277 5.37h34.785c2.907 0 5.277-2.421 5.277-5.393V75.1c0-2.972 2.343-5.426 5.25-5.426h26.318v33.569c0 .617-.077 1.216-.221 1.789z" fill="#DCE0E6"></path>
                </g>
                <path d="M149.121 33.292l-6.83 2.65a1 1 0 0 1-1.317-1.23l1.937-6.207c-2.589-2.944-4.109-6.534-4.109-10.408C138.802 8.102 148.92 0 161.402 0 173.881 0 184 8.102 184 18.097c0 9.995-10.118 18.097-22.599 18.097-4.528 0-8.744-1.066-12.28-2.902z" fill="#DCE0E6"></path>
                <g transform="translate(149.65 15.383)" fill="#FFF">
                    <ellipse cx="20.654" cy="3.167" rx="2.849" ry="2.815"></ellipse>
                    <path d="M5.698 5.63H0L2.898.704zM9.259.704h4.985V5.63H9.259z"></path>
                </g>
            </g>
        </svg>
        <p>Chúng tôi không thể tìm thấy video của bạn với link này.</p>
    </div>`;
                resultsBody.innerHTML = newRow;
          }
       })
        .catch(() => {
            resultsBody.innerHTML = `<div class="alert alert-danger">Dữ liệu không hợp lệ hoặc lỗi xảy ra.</div>`;
        });
});

</script>
@endsection
