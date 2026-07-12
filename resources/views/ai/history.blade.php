@php use App\Helpers\Helper; @endphp
@extends('layouts.app')
@section('title', $pageTitle)

@push('head-styles')
<style>
/* ─── Backdrop ─────────────────────────────────────────── */
.sc-backdrop {
    position:fixed;inset:0;background:rgba(15,23,42,.45);
    backdrop-filter:blur(4px);z-index:9990;
    opacity:0;pointer-events:none;transition:opacity .3s;
}
.sc-backdrop.open{opacity:1;pointer-events:auto;}

/* ─── Drawer Panel ─────────────────────────────────────── */
.sc-drawer {
    position:fixed;top:0;right:0;bottom:0;
    width:420px;max-width:100vw;
    background:#fff;z-index:9991;
    display:flex;flex-direction:column;
    box-shadow:-10px 0 50px rgba(0,0,0,.15);
    transform:translateX(100%);
    transition:transform .38s cubic-bezier(.4,0,.2,1);
}
.sc-drawer.open{transform:translateX(0);}

/* ─── Header ───────────────────────────────────────────── */
.sc-header {
    padding:0 20px;
    background:linear-gradient(135deg,#1565c0,#1e88e5,#42a5f5);
    color:#fff;position:relative;overflow:hidden;
    flex-shrink:0;
}
.sc-header::before{
    content:'';position:absolute;top:-40px;right:-40px;
    width:160px;height:160px;border-radius:50%;
    background:rgba(255,255,255,.08);pointer-events:none;
}
.sc-header-top {
    display:flex;align-items:center;justify-content:space-between;
    padding:16px 0 0;
}
.sc-close-btn {
    width:34px;height:34px;border-radius:50%;border:none;
    background:rgba(255,255,255,.15);color:#fff;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    font-size:16px;transition:background .2s;flex-shrink:0;
}
.sc-close-btn:hover{background:rgba(255,255,255,.28);}

.sc-seller-profile {
    display:flex;align-items:center;gap:14px;
    padding:14px 0 20px;
}
.sc-avatar {
    width:58px;height:58px;border-radius:50%;flex-shrink:0;
    background:rgba(255,255,255,.22);
    display:flex;align-items:center;justify-content:center;
    font-size:24px;font-weight:800;color:#fff;
    border:3px solid rgba(255,255,255,.4);
    text-transform:uppercase;
}
.sc-seller-name{font-size:17px;font-weight:700;margin:0;}
.sc-seller-user{font-size:13px;opacity:.78;margin-top:2px;}
.sc-online-dot{
    width:9px;height:9px;border-radius:50%;
    background:#4cef8a;display:inline-block;
    margin-right:5px;box-shadow:0 0 0 2px rgba(76,239,138,.3);
}

/* ─── Tabs ─────────────────────────────────────────────── */
.sc-tabs {
    display:flex;background:#f1f5f9;
    border-bottom:1px solid #e2e8f0;flex-shrink:0;
}
.sc-tab {
    flex:1;padding:12px;border:none;background:none;
    font-size:13.5px;font-weight:600;color:#64748b;cursor:pointer;
    border-bottom:2px solid transparent;transition:all .2s;
    display:flex;align-items:center;justify-content:center;gap:6px;
}
.sc-tab.active{color:#1e88e5;border-bottom-color:#1e88e5;background:#fff;}
.sc-tab:hover:not(.active){color:#334155;}

/* ─── Tab Content ──────────────────────────────────────── */
.sc-tab-pane{display:none;flex:1;overflow:hidden;flex-direction:column;}
.sc-tab-pane.active{display:flex;}

/* Info Pane */
.sc-info-body{overflow-y:auto;padding:20px;}
.sc-info-card{
    background:#f8fafc;border-radius:12px;
    border:1px solid #e2e8f0;padding:16px;margin-bottom:12px;
}
.sc-info-label{font-size:11px;font-weight:700;text-transform:uppercase;
    letter-spacing:.06em;color:#94a3b8;margin-bottom:8px;}
.sc-info-value{font-size:14px;color:#1e293b;font-weight:600;}
.sc-info-value small{font-weight:400;color:#64748b;}
.sc-contact-btn{
    display:flex;align-items:center;gap:10px;
    padding:11px 16px;border-radius:10px;
    text-decoration:none;font-size:13.5px;font-weight:600;
    transition:all .2s;margin-bottom:8px;border:none;cursor:pointer;
    width:100%;
}
.sc-contact-btn.tele{background:#e3f2fd;color:#1565c0;}
.sc-contact-btn.tele:hover{background:#1565c0;color:#fff;}
.sc-contact-btn.chat{background:#e8f5e9;color:#2e7d32;}
.sc-contact-btn.chat:hover{background:#2e7d32;color:#fff;}

/* Chat Pane */
.sc-chat-body{
    flex:1;overflow-y:auto;padding:16px;
    background:#f4f7fb;display:flex;flex-direction:column;gap:10px;
}
.sc-chat-body::-webkit-scrollbar{width:4px;}
.sc-chat-body::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px;}
.sc-msg{
    max-width:78%;padding:10px 14px;border-radius:16px;
    font-size:13.5px;line-height:1.55;word-break:break-word;
}
.sc-msg.me{
    background:linear-gradient(135deg,#1e88e5,#1565c0);
    color:#fff;align-self:flex-end;border-bottom-right-radius:4px;
    box-shadow:0 3px 12px rgba(30,136,229,.25);
}
.sc-msg.them{
    background:#fff;color:#1e293b;align-self:flex-start;
    border-bottom-left-radius:4px;border:1px solid #e2e8f0;
    box-shadow:0 2px 6px rgba(0,0,0,.05);
}
.sc-msg-time{font-size:10px;margin-top:4px;display:block;}
.sc-msg.me .sc-msg-time{color:rgba(255,255,255,.65);text-align:right;}
.sc-msg.them .sc-msg-time{color:#94a3b8;}
.sc-empty{
    flex:1;display:flex;flex-direction:column;
    align-items:center;justify-content:center;color:#94a3b8;text-align:center;padding:30px;
}
.sc-empty i{font-size:3.5rem;opacity:.35;display:block;margin-bottom:12px;}

.sc-chat-footer{
    padding:12px 14px;background:#fff;border-top:1px solid #e2e8f0;
    display:flex;gap:10px;align-items:flex-end;flex-shrink:0;
}
.sc-chat-footer input{
    flex:1;border:1.5px solid #e2e8f0;border-radius:22px;
    padding:10px 16px;outline:none;font-size:13.5px;
    background:#f8fafc;transition:border .2s,background .2s;resize:none;
}
.sc-chat-footer input:focus{border-color:#1e88e5;background:#fff;}
.sc-send-btn{
    background:linear-gradient(135deg,#1e88e5,#1565c0);color:#fff;border:none;
    width:42px;height:42px;border-radius:50%;display:flex;
    align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;
    box-shadow:0 4px 12px rgba(30,136,229,.35);transition:transform .2s,opacity .2s;
}
.sc-send-btn:hover{transform:scale(1.08);}
.sc-send-btn:disabled{opacity:.5;cursor:not-allowed;transform:none;}

/* ─── Chat Button in table ────────────────────────────── */
.btn-seller-chat{
    display:inline-flex;align-items:center;gap:5px;
    padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;
    background:linear-gradient(135deg,#1e88e5,#1565c0);color:#fff;
    border:none;cursor:pointer;transition:opacity .2s,transform .2s;
    box-shadow:0 2px 8px rgba(30,136,229,.3);white-space:nowrap;
}
.btn-seller-chat:hover{opacity:.88;transform:translateY(-1px);}
.btn-admin-support{
    display:inline-flex;align-items:center;gap:5px;
    padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;
    background:#f1f5f9;color:#475569;
    border:1px solid #e2e8f0;cursor:pointer;transition:all .2s;white-space:nowrap;
}
.btn-admin-support:hover{background:#e2e8f0;}

@media(max-width:575px){.sc-drawer{width:100vw;}}
</style>
@endpush

@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Lịch sử mua tài khoản AI</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600"><a href="/" class="text-gray-600 text-hover-primary">Home</a></li>
                <li class="breadcrumb-item text-gray-600">{{ $user->name }}</li>
                <li class="breadcrumb-item text-gray-500">Lịch sử tài khoản AI</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        <input type="text" id="aiOrderSearch"
                               class="form-control form-control-solid w-250px ps-12"
                               placeholder="Tìm kiếm tài khoản AI" />
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="ai_orders_table">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">Mã Đơn</th>
                                <th class="min-w-150px">Tài Khoản AI</th>
                                <th class="min-w-125px">Gói/Biến Thể</th>
                                <th class="min-w-100px">Giá Tiền</th>
                                <th class="min-w-125px">Người Bán</th>
                                <th class="min-w-125px">Trạng Thái</th>
                                <th class="min-w-125px">Hạn Dùng</th>
                                <th class="min-w-125px">Ngày Mua</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @forelse($orders as $order)
                            @php
                                $statusMap = [
                                    'pending'   => ['label'=>'Chờ xử lý',    'class'=>'badge-light-warning'],
                                    'paid'      => ['label'=>'Đã thanh toán','class'=>'badge-light-info'],
                                    'delivered' => ['label'=>'Đã giao',       'class'=>'badge-light-success'],
                                    'canceled'  => ['label'=>'Đã hủy',        'class'=>'badge-light-danger'],
                                ];
                                $st     = $statusMap[$order->status] ?? ['label'=>$order->status,'class'=>'badge-light-secondary'];
                                $seller = $order->seller ?? $order->aiAccount?->seller ?? null;
                            @endphp
                            <tr>
                                <td><code>{{ $order->trans_id }}</code></td>
                                <td><span class="text-gray-800 fw-bold">{{ $order->aiAccount?->name ?? 'Tài khoản #'.$order->ai_account_id }}</span></td>
                                <td>{{ $order->note ?: ($order->variant?->variant_name ?? 'Mặc định') }}</td>
                                <td><strong>{{ number_format($order->price) }}đ</strong></td>
                                <td>
                                    @if($seller)
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-30px me-3">
                                            @if($seller->avatar)
                                                <img src="{{ $seller->avatar }}" class="rounded-circle" alt="">
                                            @else
                                                <span class="symbol-label bg-light-primary text-primary fw-bold">{{ mb_substr($seller->name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="javascript:void(0)" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-placement="top" title="<div class='d-flex align-items-center'><i class='bi bi-patch-check-fill text-success me-2'></i> Thông tin người bán</div>" data-bs-content="<div class='mb-2'><b>{{ $seller->name }}</b> <span class='badge badge-light-warning ms-1'>LV 12</span></div><div class='text-muted fs-7 mb-2'>Online 10 phút trước</div><div class='d-flex align-items-center gap-2 mb-2'><span class='badge badge-light-success'><i class='bi bi-check-circle-fill text-success me-1'></i>Đã xác thực</span><span class='badge badge-light-info'><i class='bi bi-shield-fill-check text-info me-1'></i>Bảo hiểm: 2tr</span></div>">
                                                {{ $seller->name }}
                                            </a>
                                            <a href="javascript:void(0)" onclick="openPanel({{ $seller->id }}, '{{ addslashes($seller->name) }}', '{{ addslashes($seller->username) }}', '{{ addslashes($seller->chat_id ?? '') }}', '{{ $order->trans_id }}')" class="text-primary fw-semibold fs-7"><i class="bi bi-chat-dots text-primary"></i> Chat ngay</a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-30px me-3">
                                            <span class="symbol-label bg-light-danger text-danger fw-bold"><i class="bi bi-shield-lock-fill"></i></span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 fw-bold mb-1 fs-6">Admin</span>
                                            <a href="javascript:void(0)" onclick="openPanel(1, 'Hỗ trợ viên (Admin)', 'admin', '', '{{ $order->trans_id }}')" class="text-danger fw-semibold fs-7"><i class="bi bi-headset text-danger"></i> Hỗ trợ</a>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                                <td><span class="badge {{ $st['class'] }}">{{ $st['label'] }}</span></td>
                                <td>{{ $order->expiry_date ? \Carbon\Carbon::parse($order->expiry_date)->format('d/m/Y') : 'Vĩnh viễn' }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-10 text-muted">Bạn chưa mua tài khoản AI nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include("components.seller-chat-drawer")
@endsection

@section('scripts')
<script>
// ── Search ──────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    // Search
    const inp  = document.getElementById('aiOrderSearch');
    const rows = document.querySelectorAll('#ai_orders_table tbody tr');
    if(inp && rows) {
        inp.addEventListener('keyup', function() {
            const q = this.value.toLowerCase();
            rows.forEach(r => {
                r.style.display = r.innerText.toLowerCase().includes(q) || r.querySelector('td[colspan]') ? '' : 'none';
            });
        });
    }

    // Init Popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
});
</script>

@endsection
