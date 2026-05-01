@extends('admin.layouts.master')
@section('title', 'Đơn hàng Tài Khoản AI')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0 fw-bold">📋 Đơn hàng Tài Khoản AI</h4>
  <a href="{{ route('admin.ai.index') }}" class="btn btn-outline-secondary btn-sm">← Quay lại danh sách</a>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card custom-card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Mã đơn</th>
            <th>Thành viên</th>
            <th>Tài khoản AI</th>
            <th>Số tiền</th>
            <th>Trạng thái</th>
            <th>Hết hạn</th>
            <th>Ngày mua</th>
            <th>Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
          @php
            $statusMap = [
              'pending'   => ['label' => 'Chờ xử lý',   'class' => 'warning'],
              'paid'      => ['label' => 'Đã thanh toán','class' => 'info'],
              'delivered' => ['label' => 'Đã giao',      'class' => 'success'],
              'canceled'  => ['label' => 'Đã hủy',       'class' => 'danger'],
            ];
            $st = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'secondary'];
          @endphp
          <tr>
            <td>{{ $order->id }}</td>
            <td><code>{{ $order->trans_id ?? '—' }}</code></td>
            <td>{{ $order->user?->name ?? '—' }}<br><small class="text-muted">{{ $order->user?->username }}</small></td>
            <td>
              @php $ai = \App\Models\AiAccount::find($order->ai_account_id); @endphp
              {{ $ai?->name ?? '#' . $order->ai_account_id }}
            </td>
            <td class="fw-bold">{{ number_format($order->price) }}đ</td>
            <td><span class="badge bg-{{ $st['class'] }}">{{ $st['label'] }}</span></td>
            <td>{{ $order->expiry_date ? \Carbon\Carbon::parse($order->expiry_date)->format('d/m/Y') : '—' }}</td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td>
              <form action="{{ route('admin.ai.orders.update-status') }}" method="POST" class="d-flex gap-1">
                @csrf
                <input type="hidden" name="id" value="{{ $order->id }}">
                <select name="status" class="form-select form-select-sm" style="width:130px;">
                  @foreach($statusMap as $val => $info)
                    <option value="{{ $val }}" @selected($order->status === $val)>{{ $info['label'] }}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="9" class="text-center py-4 text-muted">Chưa có đơn hàng nào.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3">{{ $orders->links() }}</div>
  </div>
</div>
@endsection
