@php use App\Helpers\Helper; @endphp 
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Trở thành người bán hàng</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</li>
                <li class="breadcrumb-item text-gray-500">Nộp đơn đăng ký làm người bán hàng</li>
            </ul>
        </div>
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 m-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin tác giả</h4>
                        </div>
                    <div class="card-body">
                        <form action="{{ route('author-form') }}" method="POST">
                            @csrf
                                <div class="mb-3">
                                    <label class="form-label">Bạn có đội nào không?</label>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="team" id="teamYes" value="yes" checked="">
                                        <label class="form-check-label" for="teamYes">Đúng</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="team" id="teamNo" value="no">
                                        <label class="form-check-label" for="teamNo">KHÔNG</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="teamMembers">Nhóm của bạn có bao nhiêu thành viên?</label>
                                    <select class="form-select" data-control="select2" id="teamMembers" name="teamMembers">
                                        <option value="1-5" selected="">1-5</option>
                                        <option value="6-10">6-10</option>
                                        <option value="11-20">11-20</option>
                                        <option value="20+">20+</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bạn có tài khoản nào khác trên nền tảng này không?</label>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="otherAccount" id="accountYes" value="yes">
                                        <label class="form-check-label" for="accountYes">Đúng</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="otherAccount" id="accountNo" value="no">
                                        <label class="form-check-label" for="accountNo">KHÔNG</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bạn có tài khoản ở thị trường khác không?</label>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="marketAccount" id="marketYes" value="yes">
                                        <label class="form-check-label" for="marketYes">Đúng</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="marketAccount" id="marketNo" value="no">
                                        <label class="form-check-label" for="marketNo">KHÔNG</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bạn thích làm việc ở hạng mục nào?</label>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="phpCommands" name="workCategory[]" value="PHP Commands">
                                        <label class="form-check-label" for="phpCommands">Các tập lệnh PHP</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="wordpress" name="workCategory[]" value="Wordpress">
                                        <label class="form-check-label" for="wordpress">Wordpress</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="vibration" name="workCategory[]" value="CSS">
                                        <label class="form-check-label" for="vibration">CSS</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="vibration" name="workCategory[]" value="JAVASCRIPT">
                                        <label class="form-check-label" for="vibration">JAVASCRIPT</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="vibration" name="workCategory[]" value="REACT">
                                        <label class="form-check-label" for="vibration">React JS</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="http5" name="workCategory[]" value="What is HTTP5">
                                        <label class="form-check-label" for="http5">HTTP5 là gì?</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="graphics" name="workCategory[]" value="Graphics">
                                        <label class="form-check-label" for="graphics">Đồ họa</label>
                                    </div>
                                </div>


                            
                            <div class="settings-card-footer">
                                <div class="btn-item">
                                    <button class="btn btn-primary w-100" type="submit">Nộp Đơn</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end::Post-->
</div>
@endsection
@section('scripts')
  <script>
$("#kt_datatable_zero_configuration").DataTable();
  </script>
@endsection
