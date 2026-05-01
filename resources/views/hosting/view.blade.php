@php use App\Helpers\Helper; @endphp
@php use App\Models\HostingPackages; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
    <style>
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-title {
            font-weight: 500;
        }

        .card-subtitle {
            font-weight: 400;
        }

        .icon,
        .quick-link-icon {
            font-size: 24px;
            color: #007bff;
        }

        .quick-link-icon {
            font-size: 20px;
        }

        .resource-bar {
            height: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .resource-bar-inner {
            height: 100%;
            background-color: #007bff;
        }


        .list-unstyled li {
            margin-bottom: 10px;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .header-dvr {
            background: linear-gradient(282deg, #00b0ff 5.54%, #3e98eb) !important;
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }

        .header-dvr h5,
        .header-dvr h6 {
            margin: 0;
        }

        .header-dvr h6 {
            margin-top: 5px;
        }

        .header-dvr p {
            margin-top: 10px;
        }

        .card-body {
            padding: 20px;
        }

        /* Tạo hiệu ứng shimmer */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite linear;
            color: transparent;
            text-align: center;
        }
    </style>
    <div class="toolbar d-flex flex-stack py-3 py-lg-5 mb-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                    {{ $category->name }}
                </h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Hosing</li>
                    <li class="breadcrumb-item text-gray-500">Hosting số #{{ $host->id }}</li>
                </ul>
            </div>

        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start  container-xxl ">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column gap-3 border-bottom pb-3">
                            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-2">
                                <div class="d-flex flex-column gap-2 align-items-center align-items-lg-start">
                                    <span class="fw-light">{{ $category->name }}</span>
                                    <div class="d-flex flex-column flex-lg-row gap-2 align-items-center align-items-lg-end">
                                        <span class="fw-bold fs-5">{{ $host->info_package['package_name'] }}</span>
                                        {!! Helper::status_hosting_view($host->status, 'html') !!}
                                    </div>
                                    <span class="text-primary text-decoration-underline cursor-pointer"
                                        onclick="window.open('https://{{ $host->domain_name }}', '_blank');">{{ $host->domain_name }}</span>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column text-center px-3 border-end">
                                        <span class="fw-light">Ngày đăng ký</span>
                                        <span class="fw-bold">{{ date('Y-m-d', $host->start_date) }}</span>
                                    </div>
                                    <div class="d-flex flex-column text-center px-3">
                                        <span class="fw-light">Ngày hết hạn</span>
                                        <span class="fw-bold">{{ date('Y-m-d', $host->end_date) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-lg-row gap-3 mt-3 fs-6">
                            <div class="d-flex flex-column flex-lg-row gap-2 flex-grow-1">
                                <span class="fw-light">Thanh toán lần đầu</span>
                                <span class="fw-bold">{{ number_format($host->total, 0, ',', ',') }} VND</span>
                            </div>
                            <div class="d-flex flex-column flex-lg-row gap-2 flex-grow-1">
                                <span class="fw-light">Chu kỳ thanh toán</span>
                                <span class="fw-bold">{{ checkYearOrMonth($host->month) }} ({{Helper::time_His_hosting($host->end_date)  }})</span>
                            </div>
                            <div class="d-flex flex-column flex-lg-row gap-2 flex-grow-1">
                                <span class="fw-light">Số tiền thanh toán định kỳ</span>
                                <span class="fw-bold">{{ number_format($host->total, 0, ',', ',') }} VND</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <span class="fs-5 fw-bold">Công cụ</span>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-2 mt-3">
                            <div class="col">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#btnChangeMainDomainModal"
                                    class="btn btn-light w-100 d-flex align-items-center p-2 rounded">
                                    <img src="/templates/vietnixv3/img/icon/cpanel_change_domain.svg" class="me-3"
                                        style="max-width: 48px; max-height: 48px;" loading="lazy" decoding="async">
                                    <div class="text-start">Đổi tên miền chính</div>
                                </button>
                            </div>
                            <div class="col">
                                <a type="button" href="javascript:Reinstall({{ $host->id }})"
                                    class="btn btn-light w-100 d-flex align-items-center p-2 rounded">
                                    <img src="/templates/vietnixv3/img/icon/cpanel_reinstall.svg" class="me-3"
                                        style="max-width: 48px; max-height: 48px;">
                                    <div class="text-start">Cài đặt lại hosting</div>
                                </a>
                            </div>
                            <div class="col">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#btnGiaHanModal"
                                    class="btn btn-light w-100 d-flex align-items-center p-2 rounded">
                                    <img src="/templates/vietnixv3/img/icon/cpanel_reload.svg" class="me-3"
                                        style="max-width: 48px; max-height: 48px;">
                                    <div class="text-start">Gia hạn hosting</div>
                                </button>
                            </div>
                            <div class="col">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#btnblockIpModal"
                                    class="btn btn-light w-100 d-flex align-items-center p-2 rounded">
                                    <img src="/templates/vietnixv3/img/icon/cpanel_unblock_ip.svg" class="me-3"
                                        style="max-width: 48px; max-height: 48px;">
                                    <div class="text-start">chặn truy cập IP</div>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Tài nguyên sử dụng</h5>
                                <div class="row">
                                    <div class="col-6" id="Cpu">
                                        <p class="text-muted">CPU</p>
                                        <div class="resource-bar">
                                            <div class="resource-bar-inner shimmer"></div>
                                        </div>
                                        <p class="shimmer">0 / 0 (0%)</p>
                                    </div>

                                    <div class="col-6" id="Ram">
                                        <p class="text-muted">RAM</p>
                                        <div class="resource-bar">
                                            <div class="resource-bar-inner shimmer"></div>
                                        </div>
                                        <p class="shimmer">0/ 0 (0%)</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6" id="Disk">
                                        <p class="text-muted">Disk Usage</p>
                                        <div class="resource-bar">
                                            <div class="resource-bar-inner shimmer"></div>
                                        </div>
                                        <p class="shimmer">0 / 0 (0%)</p>
                                    </div>
                                    <div class="col-6" id="Quytrinh">
                                        <p class="text-muted">Number of Processes</p>
                                        <div class="resource-bar">
                                            <div class="resource-bar-inner shimmer"></div>
                                        </div>
                                        <p class="shimmer">0 / 0 (0%)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <span class="fs-5 fw-bold">Liên kết nhanh</span>
                                <div class="list-group mt-3">
                                    <button onclick="loginToCpanel('cpaneld')" data-id="{{ $host->id }}"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <img src="/templates/vietnixv3/img/service/cpanel.svg" class="me-2"
                                            style="width: 25px; height: 25px;">
                                        Đăng nhập vào cPanel
                                        <i class="ki-duotone ki-to-right"></i>
                                    </button>
                                    <button onclick="loginToCpanel('webmaild')" data-id="{{ $host->id }}"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <img src="/templates/vietnixv3/img/service/web-mail.svg" class="me-2"
                                            style="width: 25px; height: 25px;">
                                        Đăng nhập vào Webmail
                                        <i class="ki-duotone ki-to-right"></i>
                                    </button>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#btnChangePassModal"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <img src="/templates/vietnixv3/img/service/change-pass.svg" class="me-2"
                                            style="width: 25px; height: 25px;">
                                        Thay đổi mật khẩu
                                        <i class="ki-duotone ki-to-right"></i>
                                    </a>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#btnchangePackageModal"
                                        id="Primary_Sidebar-Service_Details_Actions-Upgrade_Downgrade"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <img src="/templates/vietnixv3/img/service/upgrade.svg" class="me-2"
                                            style="width: 25px; height: 25px;">
                                        Nâng cấp
                                        <i class="ki-duotone ki-to-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title m-0">Liên kết với cPanel</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-6 mb-3" id="cPanelEmailAccounts">
                                <a type="button" onclick="redirectAPI('Email_Accounts')" data-id="{{ $host->id }}"
                                    target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/email_accounts.png" class="img-fluid">
                                    Email Accounts
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6 mb-3" id="cPanelForwarders">
                                <a type="button" onclick="redirectAPI('Email_Forwarders')"
                                    data-id="{{ $host->id }}" target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/forwarders.png" class="img-fluid">
                                    Forwarders
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6 mb-3" id="cPanelAutoResponders">
                                <a type="button" onclick="redirectAPI('Email_AutoResponders')"
                                    data-id="{{ $host->id }}" target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/autoresponders.png" class="img-fluid">
                                    Autoresponders
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6 mb-3">
                                <a type="button" onclick="redirectAPI('FileManager_Home')"
                                    data-id="{{ $host->id }}" target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/file_manager.png" class="img-fluid">
                                    File Manager
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6 mb-3" id="cPanelBackup">
                                <a type="button" onclick="redirectAPI('Backups_Home')" data-id="{{ $host->id }}"
                                    target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/backup.png" class="img-fluid">
                                    Backup Dữ Liệu
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6 mb-3" id="cPanelSubdomains">
                                <a type="button" onclick="redirectAPI('Domains_SubDomains')"
                                    data-id="{{ $host->id }}" target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/subdomains.png" class="img-fluid">
                                    Subdomains
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6 mb-3" id="cPanelAddonDomains">
                                <a type="button" onclick="redirectAPI('Domains_AddonDomains')"
                                    data-id="{{ $host->id }}" target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/addon_domains.png" class="img-fluid">
                                    Addon Domains
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6 mb-3" id="cPanelCronJobs">
                                <a type="button" onclick="redirectAPI('Cron_Home')" data-id="{{ $host->id }}"
                                    target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/cron_jobs.png" class="img-fluid">
                                    Cron Jobs
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6 mb-3" id="cPanelMySQLDatabases">
                                <a type="button" onclick="redirectAPI('Database_MySQL')" data-id="{{ $host->id }}"
                                    target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/mysql_databases.png" class="img-fluid">
                                    MySQL®
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6 mb-3" id="cPanelPhpMyAdmin">
                                <a type="button" onclick="redirectAPI('Database_phpMyAdmin')"
                                    data-id="{{ $host->id }}" target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/php_my_admin.png" class="img-fluid">
                                    phpMyAdmin
                                </a>
                            </div>
                            <div class="col-sm-3 col-6 mb-3" id="cPanelAwstats">
                                <a type="button" onclick="redirectAPI('Stats_AWStats')" data-id="{{ $host->id }}"
                                    target="_blank" class="d-block">
                                    <img src="/modules/servers/cpanel/img/awstats.png" class="img-fluid">
                                    Awstats
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="btnChangeMainDomainModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Đổi tên miền chính cho hosting của bạn</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tên miền chính hiện tại: <span class="text-primary"
                            onclick="window.open('{{ $host->domain_name }}', '_blank');">{{ $host->domain_name }}</span>
                    </p>
                    <form action="{{ route('hosting.view.domain', ['id' => $host->id]) }}" method="POST"
                        class="default-form" data-reload="1" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input class="form-control" type="text" id="domain" name="domain" host=""
                                placeholder="Nhập tên miền mới" required="">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary w-100" id="btnChangeMainDomain" type="submit">Cập
                                Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="btnChangePassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thay đổi mật khẩu</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('hosting.view.changepass', ['id' => $host->id]) }}" method="POST"
                        class="axios-form" data-reload="1" data-confirm="true" enctype="multipart/form-data">
                        @csrf
                        <div class="fv-row" data-kt-password-meter="true">
                            <div class="mb-1">
                                <label class="form-label fw-semibold fs-6 mb-2">
                                    Mật Khẩu Mới
                                </label>
                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-lg form-control-solid" type="password"
                                        placeholder="Nhập mật khẩu mới" name="password" autocomplete="off" />
                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                        data-kt-password-meter-control="visibility">
                                        <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i>
                                        <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span></i>
                                    </span>
                                </div>
                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                </div>
                            </div>
                            <div class="text-muted">
                                <div
                                    class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row p-5 mb-5">
                                    <small><i class="fa fa-info-circle fa-fw" aria-hidden="true"></i> <strong>Hướng dẫn
                                            tạo
                                            mật khẩu an toàn</strong><br>Sử dụng cả chữ thường và in hoa<br>Phải có thêm ký
                                        tự
                                        đặc biệt(# $ ! % &amp; etc...)<br>Không sử dụng mật khẩu dễ đoán như 123456 -
                                        abc123...</small>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary w-100" type="submit">Cập
                                Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="btnchangePackageModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nâng cấp hosting</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('hosting.view.changepackage', ['id' => $host->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @php
                            $pack = HostingPackages::where('category', $host->info_package['category'])->get();
                        @endphp
                        <div class="text-muted">
                            <div class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row p-5 mb-5">
                                <small><i class="fa fa-info-circle fa-fw" aria-hidden="true"></i> Bạn không thể nâng cấp
                                    gói thấp hơn gói hiện tại<br>
                                    <strong>Danh các gói bạn có thể nâng cấp:</strong><br>
                                    @foreach ($pack as $packz)
                                        @php
                                            $month = $host->month;
                                            $price = $packz->price;
                                            $total = $month * $price;
                                        @endphp
                                        <i class="fa-solid fa-box-archive"></i> Gói: {{ $packz->package_name }}
                                        @if ($packz->id < $host->info_package['id'])
                                            (Gói này bé hơn gói hiện tại)
                                        @endif
                                        @if ($packz->id > $host->info_package['id'])
                                            (bạn cần phải trả {{ formatCurrency($total - $host->total) }})
                                        @endif
                                        <br>
                                    @endforeach
                                </small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Chọn Gói Hosting</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">-- Chọn Gói Hosting --</option>
                                @foreach ($pack as $packs)
                                    <option value="{{ $packs->id }}" @if ($packs->id == $host->info_package['id']) disabled @endif
                                        @if ($packs->id < $host->info_package['id']) disabled @endif>Gói: {{ $packs->package_name }}
                                        @if ($packs->id < $host->info_package['id'])
                                            (Gói này bé hơn gói hiện tại)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary w-100" id="BtnChangePackage" type="submit">Nâng Cấp</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="btnblockIpModal" tabindex="-1" role="dialog" aria-labelledby="blockIpModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UnblockIpModal">Chặn IP Hosting</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('hosting.view.blockip', ['id' => $host->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="text-muted">
                            <div class="alert alert-dismissible bg-light-primary p-5 mb-5">
                                <i class="fa fa-info-circle fa-fw " aria-hidden="true"></i>
                                <strong>Một số lưu ý</strong><br>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted">IPv4 Range</label>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="text-monospace">ip=192.168.0.1-192.168.0.58</span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted">IPv6 Range</label>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="text-monospace">ip=2001:db8::1-2001:db8::3</span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted">Single IPv4 Address</label>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="text-monospace">ip=192.0.2.0</span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted">Single IPv6 Address</label>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="text-monospace">ip=2001:db8::1</span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted">Add by resolving hostname</label>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="text-monospace">ip=example.com</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label for="ip" class="form-label">IP hoặc Hostname</label>
                        <div class="mb-3">
                            <input class="form-control" type="text" id="ip" name="ip" host=""
                                placeholder="Nhập IP hoặc Hostname cần chặn hoặc mở" required="">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button type="button" id="btnUnlblockIp"
                                        class="btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-dange w-100">
                                        Mở Khóa »</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button class="btn btn-primary w-100" id="btnblockIp" type="submit">Thêm Mới
                                        »</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="btnGiaHanModal" tabindex="-1" role="dialog" aria-labelledby="blockIpModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UnblockIpModal">Gia Hạn Hosting</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <input type="hidden" value="{{ $host->info_package['price'] }}" id="price" />
                    <div class="mb-4">
                        <label for="months" class="block text-gray-700">Thời gian:</label>
                
                            <select id="months" class="form-select" data-control="select2">
                                                    <option value="1" selected="selected">1 Tháng</option>
                                                    <option value="2">2 Tháng</option>
                                                    <option value="3">3 Tháng</option>
                                                    <option value="4">4 Tháng</option>
                                                    <option value="5">5 Tháng</option>
                                                    <option value="6">6 Tháng</option>
                                                    <option value="7">7 Tháng</option>
                                                    <option value="8">8 Tháng</option>
                                                    <option value="9">9 Tháng</option>
                                                    <option value="10">10 Tháng</option>
                                                    <option value="11">11 Tháng</option>
                                                    <option value="12">12 Tháng</option>
                                            </select>
                
                    </div>
                    <div class="el-form-item asterisk-left">
                        <div class="mt-4">
                            <label class="font-medium block text-zinc-800 text-xs mb-1">Thanh toán:</label>
                            <span class="font-extrabold text-danger" id="total">{{ formatCurrency($host->info_package['price']) }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button> 
                    <button type="button" id="extend" class="btn btn-primary" onclick="extendHosting({{ $host->id }})">Gia Hạn</button>
                </div>
                <script>
                    document.getElementById("months").addEventListener("change", function() {
                        var months = this.value;
                        var price = document.getElementById("price").value;
                        var totalPayment = months * price;
                        document.getElementById("total").textContent = totalPayment.toLocaleString("vi-VN", { style: "currency", currency: "VND" });
                    });
                    function extendHosting(id) {
                        $("#extend").html("Đang xử lý...").prop("disabled",
                            true);
                            var loadingLayer = layer.open({
                            type: 2, 
                            content: "<div>Đang xử lý...</div>",
                            shade: [0.7, "#000"], 
                            shadeClose: false,
                            time: 0 
                          });
                        $.ajax({
                            url: "{{ route('hosting.view.extend') }}",
                            method: "POST",
                            dataType: "JSON",
                             headers: {
                              "X-CSRF-TOKEN": "{{ csrf_token() }}"
                             },
                            data: {
                                id: id,
                                action: "giahan",
                                month: $("#months").val()
                            },
                            success: function(res) {
                                layer.close(loadingLayer);
                                if (res.status == "200") {
                                    showMessage(res.message, "success");
                                    location.reload();
                                }
                                $("#extend").html(
                                        "Gia Hạn")
                                    .prop("disabled", false);
                            },
                              error: function (xhr, status, error) {
                                layer.close(loadingLayer);
                            var responseMessage = xhr.responseJSON
                                ? xhr.responseJSON.message
                                : "Không thể thực hiện";
                            showMessage(responseMessage, "error");
                           },
                        });
                    }
                </script>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
const Reinstall = async (id) => {
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
        } = await axios.post('{{ route('hosting.view.reinstall') }}', {
          id
        })

        Swal.fire('Thành công', result.message, 'success').then(() => {
          window.location.reload();
        })
      } catch (error) {
        Swal.fire('Thất bại', $catchMessage(error), 'error')
      }
    }
$("#BtnChangePackage").on("click", function() {
    $('#BtnChangePackage').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop(
        'disabled',
        true);
    $.ajax({
        url: "{{ route('hosting.view.changepackage') }}",
        method: "POST",
        dataType: "JSON",
        data: {
            _token: '{{ csrf_token() }}',
            id: "{{ $host->id }}",
            category: $("#category").val()
        },
        success: function(result) {
            if (result.status == '200') {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công !',
                    text: result.message,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                }).then(() => {
                    location.reload();
                });

            } else {
                showMessage(result.message, 'error');
            }
            $('#BtnChangePackage').html(
                'Nâng Cấp').prop(
                'disabled',
                false);
        },

        error: function(xhr, status, error) {
            var responseMessage = xhr.responseJSON ? xhr.responseJSON.message :
                'Vui lòng liên hệ Developer';
            showMessage(responseMessage, 'error');
            $('#BtnChangePackage').html(
                'Nâng Cấp').prop(
                'disabled',
                false);
        }

    });
});
$("#btnblockIp").on("click", function() {
    $('#btnblockIp').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop(
        'disabled',
        true);
    var loadingLayer = layer.open({
        type: 2,
        content: '<div>Đang xử lý...</div>',
        shade: [0.7, '#000'],
        shadeClose: false,
        time: 0
    });
    $.ajax({
        url: "{{ route('hosting.view.blockip') }}",
        method: "POST",
        dataType: "JSON",
        data: {
            _token: '{{ csrf_token() }}',
            id: "{{ $host->id }}",
            ip: $("#ip").val()
        },
        success: function(result) {
            layer.close(loadingLayer);
            if (result.status == '200') {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công !',
                    text: result.message,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                }).then(() => {
                    location.reload();
                });

            } else {
                showMessage(result.message, 'error');
            }
            $('#btnblockIp').html(
                'Thêm Mới »').prop(
                'disabled',
                false);
        },

        error: function(xhr, status, error) {
            layer.close(loadingLayer);
            var responseMessage = xhr.responseJSON ? xhr.responseJSON.message :
                'Vui lòng liên hệ Developer';
            showMessage(responseMessage, 'error');
            $('#btnblockIp').html(
                'Thêm Mới »').prop(
                'disabled',
                false);
        }

    });
});
$("#btnUnlblockIp").on("click", function() {
    $('#btnUnlblockIp').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop(
        'disabled',
        true);
    var loadingLayer = layer.open({
        type: 2,
        content: '<div>Đang xử lý...</div>',
        shade: [0.7, '#000'],
        shadeClose: false,
        time: 0
    });
    $.ajax({
        url: "{{ route('hosting.view.unlblockip') }}",
        method: "POST",
        dataType: "JSON",
        data: {
            _token: '{{ csrf_token() }}',
            id: "{{ $host->id }}",
            ip: $("#ip").val()
        },
        success: function(result) {
            layer.close(loadingLayer);
            if (result.status == '200') {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công !',
                    text: result.message,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                }).then(() => {
                    location.reload();
                });

            } else {
                showMessage(result.message, 'error');
            }
            $('#btnUnlblockIp').html(
                'Mở Khóa »').prop(
                'disabled',
                false);
        },

        error: function(xhr, status, error) {
            layer.close(loadingLayer);
            var responseMessage = xhr.responseJSON ? xhr.responseJSON.message :
                'Vui lòng liên hệ Developer';
            showMessage(responseMessage, 'error');
            $('#btnUnlblockIp').html(
                'Mở Khóa »').prop(
                'disabled',
                false);
        }

    });
});

function redirectAPI(app) {
    const id = $(event.target).data('id');
    var loadingLayer = layer.open({
        type: 2,
        content: '<div>Đang chuyển hướng...</div>',
        shade: [0.7, '#000'],
        shadeClose: false,
        time: 0
    });
    $.ajax({
        url: '{{ route('hosting.view.redirect') }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            app: app,
            id: id
        },
        beforeSend: function() {
            console.log("Đang gửi dữ liệu...");
        },
        success: function(response) {
            layer.close(loadingLayer);
            if (response.status == '200') {
                window.open(response.url, '_blank');
            } else {
                showMessage(response.errorMsg, 'error');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            layer.close(loadingLayer);
            const errorMsg = jqXHR.responseText || "Có lỗi xảy ra, vui lòng thử lại.";
            showMessage(errorMsg, 'error');
        }
    });
}

function loginToCpanel(action) {
    const id = $(event.target).data('id');
    var loadingLayer = layer.open({
        type: 2,
        content: '<div>Đang chuyển hướng...</div>',
        shade: [0.7, '#000'],
        shadeClose: false,
        time: 0
    });
    $.ajax({
        url: '{{ route('hosting.view.login') }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            action: action,
            id: id
        },
        beforeSend: function() {
            console.log("Đang gửi dữ liệu...");
        },
        success: function(response) {
            layer.close(loadingLayer);
            if (response.status == '200') {
                window.open(response.url, '_blank');
            } else {
                showMessage(response.errorMsg, 'error');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            layer.close(loadingLayer);
            const errorMsg = jqXHR.responseText || "Có lỗi xảy ra, vui lòng thử lại.";
            showMessage(errorMsg, 'error');
        }
    });
}
$("#btnChangeMainDomain").on("click", function() {
    $('#btnChangeMainDomain').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop(
        'disabled',
        true);
    $.ajax({
        url: "{{ route('hosting.view.domain') }}",
        method: "POST",
        dataType: "JSON",
        data: {
            _token: '{{ csrf_token() }}',
            id: "{{ $host->id }}",
            domain: $("#domain").val()
        },
        success: function(result) {
            if (result.status == '200') {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công !',
                    text: result.message,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                }).then(() => {
                    location.reload();
                });

            } else {
                showMessage(result.message, 'error');
            }
            $('#btnChangeMainDomain').html(
                'Cập Nhật').prop(
                'disabled',
                false);
        },

        error: function(xhr, status, error) {
            var responseMessage = xhr.responseJSON ? xhr.responseJSON.message :
                'Vui lòng liên hệ Developer';
            showMessage(responseMessage, 'error');
            $('#btnChangeMainDomain').html(
                'Cập Nhật').prop(
                'disabled',
                false);
        }

    });
});
document.addEventListener('DOMContentLoaded', function() {
    const id = {{ $host->id }};

    fetch(`/api/get-disk?id=${id}`)
        .then(response => response.json())
        .then(data => {
            const cell = document.getElementById('Disk');

            if (data.status === 200 && data.phamtram !== undefined) {
                const phamtram = Math.round(data.phamtram * 1);

                cell.innerHTML = `
            <p class="text-muted">Disk Usage</p>
            <div class="resource-bar">
                <div class="resource-bar-inner" style="width: ${phamtram}%;"></div>
            </div>
            <p>${data.disk_used} / ${data.disk_limit} (${phamtram}%)</p>
        `;
            } else {
                cell.textContent = 'Không thể lấy dữ liệu';
            }
        })
        .catch(error => {
            console.error('Error fetching disk usage:', error);
            const cell = document.getElementById('Disk');
            cell.textContent = 'Error loading';
        });
});
document.addEventListener('DOMContentLoaded', function() {
    const id = {{ $host->id }};

    fetch(`/api/get-all?id=${id}`)
        .then(response => response.json())
        .then(data => {
            const cpu = document.getElementById('Cpu');
            const ram = document.getElementById('Ram');
            const quytrinh = document.getElementById('Quytrinh');

            if (data.status === 200 && data.data.cpu !== undefined && data.data.ram !== undefined &&
                data.data.quytrinh !== undefined) {
                const phamtram = Math.round(data.data.ram.ram_phantram * 1);

                cpu.innerHTML = `
            <p class="text-muted">CPU</p>
            <div class="resource-bar">
                <div class="resource-bar-inner" style="width: ${data.data.cpu.cpu_phantram}%;"></div>
            </div>
            <p>${data.data.cpu.cpu_usage} / ${data.data.cpu.cpu_max} (${data.data.cpu.cpu_phantram}%)</p>
        `;
                ram.innerHTML = `
            <p class="text-muted">RAM</p>
            <div class="resource-bar">
                <div class="resource-bar-inner" style="width: ${phamtram}%;"></div>
            </div>
            <p>${data.data.ram.ram_usage} / ${data.data.ram.ram_max} (${phamtram}%)</p>
        `;
                quytrinh.innerHTML = `
            <p class="text-muted">Number of Processes</p>
            <div class="resource-bar">
                <div class="resource-bar-inner" style="width: ${data.data.quytrinh.quytrinh_phantram}%;"></div>
            </div>
            <p>${data.data.quytrinh.quytrinh_usage} / ${data.data.quytrinh.quytrinh_max} (${data.data.quytrinh.quytrinh_phantram}%)</p>
        `;
            } else {
                cpu.textContent = 'Không thể lấy dữ liệu';
                ram.textContent = 'Không thể lấy dữ liệu';
                quytrinh.textContent = 'Không thể lấy dữ liệu';
            }
        })
        .catch(error => {
            console.error('Error fetching disk usage:', error);
            const cpu = document.getElementById('Cpu');
            const ram = document.getElementById('Ram');
            const quytrinh = document.getElementById('Quytrinh');
            cpu.textContent = 'Error loading';
            ram.textContent = 'Error loading';
            quytrinh.textContent = 'Error loading';
        });
});
</script>
@endsection
