@extends('seller.layouts.master')

@section('title', 'Đơn hàng đã bán - Kênh Người Bán')

@section('content')
<style>
    .revenue-header-card {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        border-radius: 12px;
        padding: 20px 24px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.05);
    }
    .revenue-title {
        font-size: 1.25rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }
    .revenue-subtitle {
        font-size: 0.8rem;
        font-weight: 500;
        color: #94a3b8;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .revenue-table-card {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
</style>

<!-- Header Card -->
<div class="revenue-header-card">
    <h5 class="revenue-title"><i class="fas fa-shopping-basket me-2"></i> Đơn hàng đã bán</h5>
    <p class="revenue-subtitle"><i class="fas fa-info-circle"></i> Tra cứu chi tiết tất cả các lượt mua hàng, mã giao dịch và tài khoản đã bàn giao cho khách.</p>
</div>

<!-- Table Card -->
<div class="revenue-table-card">
    @if($sales->isEmpty())
        <div class="text-center py-5">
            <p class="text-muted mb-0">Chưa có lượt giao dịch mua sản phẩm nào từ shop của bạn.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted border-bottom fs-7 text-uppercase" style="font-size: 0.72rem; font-weight: 800; letter-spacing: 0.5px;">
                        <th>Mã đơn hàng</th>
                        <th>Sản phẩm</th>
                        <th>Khách hàng</th>
                        <th>Thu nhập (Nhận về)</th>
                        <th>Trạng thái</th>
                        <th>Thời gian</th>
                        <th class="text-end">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                        @php
                            $productModel = \App\Models\Product::find($sale->product_id);
                            $isAccountType = $productModel && in_array($productModel->category, ['account', 'mail', 'via_bm', 'clone']);
                        @endphp
                        <tr>
                            <td><code class="text-info" style="font-weight: 700;">{{ $sale->trans_id }}</code></td>
                            <td><strong>{{ $sale->product_name }}</strong></td>
                            <td><span class="badge bg-secondary-subtle text-secondary-emphasis px-2 py-1">{{ $sale->buyer_name }}</span></td>
                            <td><strong class="text-success" style="font-size: 0.85rem;">+{{ number_format($sale->price) }}₫</strong></td>
                            <td>
                                <span class="badge bg-success-subtle text-success-emphasis"><i class="fas fa-check-circle me-1"></i>Thành công</span>
                            </td>
                            <td><small class="text-muted">{{ $sale->created_at }}</small></td>
                            <td class="text-end">
                                @if($isAccountType)
                                    <button type="button" class="btn btn-sm btn-outline-warning fw-semibold px-2 py-1" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#modal-accounts-{{ $sale->id }}">
                                        <i class="fas fa-eye me-1"></i> Xem nick
                                    </button>
                                @else
                                    <span class="text-muted fs-8">File tự động</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Delievered Accounts -->
                        @if($isAccountType)
                            @php $delivered = \App\Models\ProductAccount::where('trans_id', $sale->trans_id)->get(); @endphp
                            <div class="modal fade" id="modal-accounts-{{ $sale->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h6 class="modal-title text-dark fw-bold">Thông tin nick đã bán (Mã đơn: {{ $sale->trans_id }})</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <label class="form-label fw-bold text-dark fs-7">Danh sách nick bàn giao:</label>
                                            <textarea class="form-control" rows="6" readonly onclick="this.select(); document.execCommand('copy');" style="font-family: monospace; background: #f8f9fa; font-size: 0.82rem;">@foreach($delivered as $d){{ $d->account_info }}
@endforeach</textarea>
                                            <small class="text-muted d-block mt-2">Nhấp chuột vào khung trên để tự động bôi đen và copy nhanh.</small>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $sales->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
