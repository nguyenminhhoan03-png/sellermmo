@extends('seller.layouts.master')

@section('title', 'Rút tiền doanh thu')

@section('content')
<style>
    .withdraw-header-card {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        border-radius: 12px;
        padding: 20px 24px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.05);
    }
    .withdraw-title {
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
    .withdraw-subtitle {
        font-size: 0.8rem;
        font-weight: 500;
        color: #94a3b8;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
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
</style>

<div class="withdraw-header-card">
    <h5 class="withdraw-title"><i class="fas fa-wallet me-2"></i> Rút tiền doanh thu</h5>
    <p class="withdraw-subtitle"><i class="fas fa-info-circle"></i> Rút số dư tích lũy từ doanh số bán hàng của shop về tài khoản ngân hàng của bạn.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4 mb-4">
    <!-- Withdraw Form -->
    <div class="col-lg-6">
        <div class="premium-card h-100">
            <h4 class="fw-bold mb-4"><i class="fas fa-money-bill-wave text-warning me-2"></i>Yêu cầu rút tiền</h4>
            
            <div class="mb-4 p-3 bg-light rounded border">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Số dư khả dụng:</span>
                    <strong class="text-danger fs-5">{{ number_format($user->balance_ctv) }}₫</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Hạn mức rút tối thiểu:</span>
                    <strong class="text-success">{{ number_format(setting('minctv', '0')) }}₫</strong>
                </div>
            </div>

            <form action="{{ route('seller.withdraw.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label required fw-semibold" for="amount">Số tiền muốn rút (VNĐ)</label>
                    <input type="number" class="form-control shadow-none" id="amount" name="amount" placeholder="Nhập số tiền" required>
                </div>

                <div class="mb-3">
                    <label class="form-label required fw-semibold" for="bank">Chọn Ngân Hàng</label>
                    <select name="bank" id="bank" class="form-select" required>
                        <option value="">-- Chọn ngân hàng --</option>
                        <option value="Localbank_TCB">Techcombank</option>
                        <option value="Localbank_VCB">Vietcombank</option>
                        <option value="Localbank_MB">MB Bank</option>
                        <option value="Localbank_VIETINBANK">VietinBank</option>
                        <option value="Localbank_BIDV">BIDV</option>
                        <option value="Localbank_AGRIBANK">Agribank</option>
                        <option value="Localbank_SACOMBANK">Sacombank</option>
                        <option value="Localbank_VPBANK">VPBank</option>
                        <option value="Localbank_TPBANK">TPBank</option>
                        <option value="Localbank_ACB">ACB</option>
                    </select>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label required fw-semibold" for="stk">Số tài khoản</label>
                        <input type="text" class="form-control shadow-none" id="stk" name="stk" placeholder="Nhập số tài khoản" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required fw-semibold" for="ctk">Chủ tài khoản</label>
                        <input type="text" class="form-control shadow-none" id="ctk" name="ctk" placeholder="Nhập tên chủ tài khoản" required>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-orange-grad fw-bold py-2.5" type="submit">
                        <i class="fas fa-check-circle me-2"></i>Xác nhận rút tiền
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rules Card -->
    <div class="col-lg-6">
        <div class="premium-card h-100">
            <h4 class="fw-bold mb-4"><i class="fas fa-shield-halved text-warning me-2"></i>Quy định rút tiền</h4>
            <div class="text-muted fs-6" style="line-height: 1.7;">
                {!! base64_decode(App\Helpers\Helper::getNotice('notectv')) !!}
            </div>
        </div>
    </div>
</div>

<!-- History table -->
<div class="premium-card">
    <h4 class="fw-bold mb-4"><i class="fas fa-history text-warning me-2"></i>Lịch sử rút tiền</h4>
    @if($withdrawals->isEmpty())
        <div class="text-center py-5">
            <img src="/assets/images/null.svg" alt="Empty" width="100" class="mb-3">
            <p class="text-muted mb-0">Chưa có giao dịch rút tiền nào trước đây.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted border-bottom fs-7 text-uppercase">
                        <th>Mã giao dịch</th>
                        <th>Thông tin ngân hàng</th>
                        <th>Số tiền rút</th>
                        <th>Trạng thái</th>
                        <th>Ngày rút</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $w)
                        <tr>
                            <td><code class="text-info">{{ $w->trans_id }}</code></td>
                            <td>
                                <div><strong>{{ $w->bank }}</strong></div>
                                <small class="text-muted">{{ $w->stk }} - {{ $w->ctk }}</small>
                            </td>
                            <td><strong class="text-danger">{{ number_format($w->price) }}₫</strong></td>
                            <td>
                                {!! App\Helpers\Helper::statuswithdraw($w->status) !!}
                            </td>
                            <td><small class="text-muted">{{ $w->created_at }}</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $withdrawals->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
