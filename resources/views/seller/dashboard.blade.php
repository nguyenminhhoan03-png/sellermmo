@extends('seller.layouts.master')

@section('title', 'Quản trị doanh thu - Kênh Người Bán')

@section('content')
<style>
    .btn-orange-grad {
        background: var(--primary-gradient);
        color: #fff !important;
        border: none;
        box-shadow: 0 4px 12px rgba(245, 124, 0, 0.2);
        transition: all 0.2s ease;
    }
    .btn-orange-grad:hover {
        background: linear-gradient(135deg, #f57c00, #e65100);
        transform: translateY(-1px);
    }
    .dashboard-rules-row {
        margin-bottom: 24px;
    }
    
    .rule-card {
        border-radius: 8px;
        color: #fff;
        padding: 20px;
        height: 100%;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .rule-card-navy {
        background-color: #1c1e2e;
        border-left: 5px solid #dc3545;
    }
    
    .rule-card-orange {
        background-color: #242220;
        border-left: 5px solid #fd7e14;
    }
    
    .rule-title {
        font-weight: 800;
        font-size: 0.85rem;
        text-transform: uppercase;
        margin-bottom: 15px;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .rule-pills {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .rule-pill {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #fff;
    }

    .rule-pill-danger {
        color: #ff9800;
        font-weight: bold;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 150px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-title {
        font-size: 0.75rem;
        font-weight: 800;
        color: #888899;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.9rem;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #111;
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .stat-subtext {
        font-size: 0.75rem;
        color: #666;
        margin: 0;
    }

    .stat-subtext-danger {
        color: #dc3545;
    }

    .stat-subtext-success {
        color: #198754;
    }

    .stat-card-purple {
        background: linear-gradient(135deg, #7F00FF, #E100FF);
        color: #fff;
        border: none;
    }

    .stat-card-purple .stat-title {
        color: rgba(255, 255, 255, 0.8);
    }

    .stat-card-purple .stat-value {
        color: #fff;
    }

    .stat-card-purple .stat-subtext {
        color: rgba(255, 255, 255, 0.9);
    }

    /* Available Balance Card Buttons */
    .avail-balance-actions {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-top: 12px;
    }

    .btn-avail-action {
        width: 100%;
        padding: 8px 12px;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 6px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-avail-yellow {
        background: var(--primary-gradient);
        color: #fff;
    }

    .btn-avail-yellow:hover {
        background: linear-gradient(135deg, #f57c00, #e65100);
        color: #fff;
    }

    .btn-avail-dark {
        background-color: #212529;
        color: #fff;
    }

    .btn-avail-dark:hover {
        background-color: #000;
    }

    /* Warning Banner block */
    .warning-banners {
        background-color: #151515;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 24px;
        color: #fff;
    }

    .banner-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 8px;
    }

    .banner-title {
        font-size: 0.85rem;
        font-weight: 800;
        color: #fff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .banner-title i {
        color: #ff9800;
    }

    .status-badge-active {
        background-color: #198754;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 20px;
        letter-spacing: 0.5px;
    }

    .banner-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 6px;
        padding: 10px 15px;
        font-size: 0.75rem;
        margin-bottom: 8px;
    }

    .banner-item:last-child {
        margin-bottom: 0;
    }

    .banner-item-icon-yellow {
        color: #ff9800;
        font-size: 1rem;
        margin-top: 2px;
    }

    .banner-item-icon-red {
        color: #dc3545;
        font-size: 1rem;
        margin-top: 2px;
    }
</style>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0">Quản trị doanh thu</h4>
        <p class="text-muted small mb-0">Theo dõi dòng tiền và hiệu quả sinh doanh.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-sm btn-orange-grad fw-bold text-white px-3 shadow-sm" onclick="location.reload()"><i class="fas fa-sync-alt me-1"></i> Làm mới</button>
    </div>
</div>

<!-- Rule Row -->
<div class="row g-4 dashboard-rules-row">
    <div class="col-lg-7">
        <div class="rule-card rule-card-navy">
            <h6 class="rule-title"><i class="fas fa-exclamation-triangle text-danger"></i> Quy định giao dịch nghiêm ngặt</h6>
            <p class="small text-white-50 mb-3">Nghiêm cấm cung cấp thông tin liên hệ ngoài hệ thống (Zalo, Telegram, SĐT, Facebook, Link website hoặc bất kỳ hình thức nào điều hướng khách ra ngoài hệ thống).</p>
            <div class="rule-pills">
                <div class="rule-pill"><span class="rule-pill-danger">LẦN 1:</span> Khóa gian hàng và phạt 500.000đ</div>
                <div class="rule-pill"><span class="rule-pill-danger">LẦN 2:</span> Phạt 5% tổng giao dịch hoặc 1.000.000đ</div>
                <div class="rule-pill"><span class="rule-pill-danger">LẦN 3:</span> Khóa shop vĩnh viễn và đóng băng số dư</div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="rule-card rule-card-orange">
            <h6 class="rule-title"><i class="fas fa-hourglass-half text-warning"></i> Quy định trạng thái hoạt động</h6>
            <p class="small text-white-50 mb-3">Để đảm bảo trải nghiệm của khách hàng, hệ thống tự động xử lý các gian hàng không duy trì hoạt động (Offline):</p>
            <div class="rule-pills">
                <div class="rule-pill"><span class="text-warning fw-bold"><i class="fas fa-moon"></i> Offline quá 7 ngày:</span> Tự động TẠM ẨN toàn bộ sản phẩm</div>
                <div class="rule-pill"><span class="text-danger fw-bold"><i class="fas fa-ban"></i> Offline quá 15 ngày:</span> KHÓA GIAN HÀNG & xóa sản phẩm vĩnh viễn</div>
            </div>
        </div>
    </div>
</div>

<!-- Stats cards Grid -->
<div class="stats-grid">
    <!-- Card 1: Doanh thu (Đang chọn) -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Doanh thu (Đang chọn)</span>
            <div class="stat-icon" style="background-color: #fd7e14;"><i class="fas fa-dollar-sign"></i></div>
        </div>
        <div>
            <h3 class="stat-value">{{ number_format($todayRevenue) }}đ</h3>
            <p class="stat-subtext stat-subtext-success"><i class="fas fa-arrow-up me-1"></i>+100.0% so với hôm qua</p>
        </div>
        <div class="border-top pt-2 mt-2">
            <small class="text-muted d-block">Tổng thu nhập toàn thời gian: <strong>{{ number_format($totalRevenue) }}đ</strong></small>
            @php $netRevenue = $totalRevenue * 0.95; @endphp
            <small class="text-muted d-block">Số thực nhận (sau phí): <strong>{{ number_format($netRevenue) }}đ</strong></small>
        </div>
    </div>

    <!-- Card 2: Đã chuyển ví chính -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Đã chuyển ví chính</span>
            <div class="stat-icon" style="background-color: #198754;"><i class="fas fa-wallet"></i></div>
        </div>
        <div>
            <h3 class="stat-value">0đ</h3>
            <p class="stat-subtext">Tổng tiền đã rút về ví khách mua</p>
        </div>
    </div>

    <!-- Card 3: Tiền tạm giữ -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Tiền tạm giữ (Chuẩn)</span>
            <div class="stat-icon" style="background-color: #212529;"><i class="fas fa-lock"></i></div>
        </div>
        <div>
            @php
                // Calculate hold balance: recent 3 days sales
                $holdBalance = DB::table('tbl_his_code')
                    ->join('tbl_list_code', 'tbl_his_code.product_id', '=', 'tbl_list_code.id')
                    ->where('tbl_list_code.user_id', auth()->id())
                    ->where('tbl_his_code.created_at', '>=', now()->subDays(3))
                    ->sum('tbl_his_code.price');
            @endphp
            <h3 class="stat-value">{{ number_format($holdBalance) }}đ</h3>
            <p class="stat-subtext">Thực nhận sau phí (Tạm giữ 3 ngày)</p>
        </div>
    </div>

    <!-- Card 4: Ví khiếu nại -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Ví khiếu nại</span>
            <div class="stat-icon" style="background-color: #20c997;"><i class="fas fa-info-circle"></i></div>
        </div>
        <div>
            <h3 class="stat-value">0đ</h3>
            <p class="stat-subtext stat-subtext-success"><i class="fas fa-check-circle me-1"></i>Không có khiếu nại đang mở</p>
        </div>
    </div>

    <!-- Card 5: Đã rút ngân hàng -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Đã rút ngân hàng</span>
            <div class="stat-icon" style="background-color: #0d6efd;"><i class="fas fa-bank"></i></div>
        </div>
        <div>
            @php
                $totalWithdrawn = \App\Models\WithdrawCtv::where('user_id', auth()->id())->where('status', 1)->sum('price');
            @endphp
            <h3 class="stat-value">{{ number_format($totalWithdrawn) }}đ</h3>
            <p class="stat-subtext">Đã thanh toán về STK ngân hàng</p>
        </div>
    </div>

    <!-- Card 6: Chi Marketing -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Chi Marketing (Tổng)</span>
            <div class="stat-icon" style="background-color: #fd7e14;"><i class="fas fa-ad"></i></div>
        </div>
        <div>
            <h3 class="stat-value">0đ</h3>
            <p class="stat-subtext">Đấu giá đẩy từ khóa & Banner</p>
        </div>
    </div>

    <!-- Card 7: Số dư khả dụng (Rút tiền) -->
    <div class="stat-card" style="border: 2px solid #ff9800;">
        <div class="stat-header">
            <span class="stat-title" style="color: var(--text-dark); font-weight: bold;">Số dư khả dụng</span>
            <div class="stat-icon" style="background-color: #ff9800; color: #fff;"><i class="fas fa-coins"></i></div>
        </div>
        <div>
            <h3 class="stat-value" style="color: var(--text-dark);">{{ number_format($user->balance_ctv) }}đ</h3>
            <p class="stat-subtext fw-bold">Có thể rút hoặc chuyển ví lập tức</p>
        </div>
        <div class="avail-balance-actions">
            <a href="{{ route('seller.withdraw') }}" class="btn-avail-action btn-avail-yellow text-decoration-none">
                <i class="fas fa-bank"></i> Rút tiền về ngân hàng
            </a>
            <button class="btn-avail-action btn-avail-dark" onclick="transferMainWallet()">
                <i class="fas fa-exchange-alt"></i> Chuyển về ví chính
            </button>
        </div>
    </div>

    <!-- Card 8: Quỹ bảo hiểm -->
    <div class="stat-card stat-card-purple">
        <div class="stat-header">
            <span class="stat-title">Quỹ bảo hiểm</span>
            <div class="stat-icon" style="background-color: rgba(255,255,255,0.2);"><i class="fas fa-shield-alt"></i></div>
        </div>
        <div>
            <h3 class="stat-value">300,000đ</h3>
            <p class="stat-subtext">Hệ thống đang lưu trữ và bảo vệ quỹ</p>
        </div>
        <div class="mt-2 text-end">
            <a href="javascript:void(0)" onclick="Swal.fire('Thông báo', 'Quỹ bảo hiểm giúp gian hàng của bạn tăng độ uy tín, được gắn nhãn bảo hiểm và tăng tỷ lệ tiếp cận khách hàng.', 'info')" class="text-white text-decoration-none small fw-bold">Quản lý quỹ <i class="fas fa-chevron-right fs-8"></i></a>
        </div>
    </div>
</div>

<!-- Warning Banner Block -->
<div class="warning-banners">
    <div class="banner-header">
        <h5 class="banner-title"><i class="fas fa-lightbulb"></i> Mẹo bán hàng hiệu quả</h5>
        <span class="status-badge-active">TRẠNG THÁI: HOẠT ĐỘNG TỐT</span>
    </div>
    
    <div class="banner-item">
        <i class="fas fa-info-circle banner-item-icon-yellow"></i>
        <div>
            <strong>Offline > 2 ngày - Cảnh báo cho người mua</strong>
            <p class="text-white-50 mb-0 mt-0.5">Khi bạn không truy cập Kênh người bán quá 2 ngày, hệ thống sẽ hiện cảnh báo Offline trên giao diện chi tiết sản phẩm để người mua cân nhắc trước khi thanh toán.</p>
        </div>
    </div>
    
    <div class="banner-item">
        <i class="fas fa-exclamation-triangle banner-item-icon-red"></i>
        <div>
            <strong>Offline lâu - Giảm đề xuất sản phẩm</strong>
            <p class="text-white-50 mb-0 mt-0.5">Các sản phẩm của bạn sẽ tự động bị giảm độ hiển thị trên trang chủ và kết quả tìm kiếm nếu tài khoản của bạn không hoạt động thường xuyên.</p>
        </div>
    </div>
</div>

<!-- Recent sales block style of shopmini -->
<div class="card p-4 border bg-white shadow-sm mb-4">
    <h5 class="fw-bold mb-3"><i class="fas fa-shopping-cart text-warning me-2"></i>Đơn hàng gần đây</h5>
    @if($latestSales->isEmpty())
        <div class="text-center py-5">
            <p class="text-muted mb-0">Chưa có đơn hàng nào được bán ra gần đây.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted border-bottom fs-7 text-uppercase">
                        <th>Mã đơn</th>
                        <th>Sản phẩm</th>
                        <th>Người mua</th>
                        <th>Giá bán</th>
                        <th>Ngày mua</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestSales as $sale)
                        <tr>
                            <td><code class="text-info">{{ $sale->trans_id }}</code></td>
                            <td><strong>{{ $sale->product_name }}</strong></td>
                            <td><span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $sale->buyer_name }}</span></td>
                            <td><strong class="text-success">{{ number_format($sale->price) }}₫</strong></td>
                            <td><small class="text-muted">{{ \Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    function transferMainWallet() {
        Swal.fire({
            title: 'Chuyển về ví chính',
            text: 'Tính năng chuyển số dư CTV về ví chính (ví mua hàng) đang được hệ thống đồng bộ nâng cấp. Bạn vui lòng sử dụng chức năng rút tiền mặt về ngân hàng.',
            icon: 'info',
            confirmButtonColor: '#ffd305',
            confirmButtonText: 'Đã hiểu'
        });
    }
</script>
@endsection
