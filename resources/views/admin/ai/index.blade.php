@extends('admin.layouts.master')
@section('title', 'Quản Lý Tài Khoản AI')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
  <h4 class="mb-0 fw-bold">🤖 Tài Khoản AI</h4>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.ai.categories') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bx bx-category"></i> Danh mục
    </a>
    <a href="{{ route('admin.ai.orders') }}" class="btn btn-outline-info btn-sm">
      <i class="bx bx-list-ul"></i> Đơn hàng
    </a>
    <a href="{{ route('admin.ai.create') }}" class="btn btn-primary btn-sm">
      <i class="fas fa-plus"></i> Thêm mới
    </a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card custom-card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0 text-nowrap">
        <thead class="table-light">
          <tr>
            <th width="50">#</th>
            <th>Ảnh</th>
            <th>Tên tài khoản</th>
            <th>Danh mục</th>
            <th>Biến thể / Giá</th>
            <th>Trạng thái</th>
            <th width="160">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @forelse($accounts as $acc)
          @php
            $minPrice = $acc->variant->min('price');
            $maxPrice = $acc->variant->max('price');
            $catName  = $categories->firstWhere('id', $acc->category_id)?->name ?? '—';
          @endphp
          <tr>
            <td class="text-center">{{ $acc->id }}</td>
            <td class="text-center">
              @if($acc->image)
                <img src="{{ img_url($acc->image, '/assets/media/avatars/user-placeholder.svg') }}" width="50" height="50" style="object-fit:cover;border-radius:8px;" onerror="this.src='/assets/media/avatars/user-placeholder.svg'">
              @else
                <div style="width:50px;height:50px;border-radius:8px;background:linear-gradient(135deg,#6c63ff,#a855f7);display:flex;align-items:center;justify-content:center;font-size:1.4rem;">🤖</div>
              @endif
            </td>
            <td>
              <div class="fw-semibold">{{ $acc->name }}</div>
              <small class="text-muted">{{ Str::limit($acc->account_info, 50) }}</small>
            </td>
            <td>{{ $catName }}</td>
            <td>
              <span class="badge bg-light text-dark border">{{ $acc->variant_count }} biến thể</span>
              @if($minPrice !== null)
                <br><small class="text-success fw-bold">{{ number_format($minPrice) }}đ — {{ number_format($maxPrice) }}đ</small>
              @endif
            </td>
            <td class="text-center">
              <div class="form-check form-switch d-inline-flex">
                <input class="form-check-input" type="checkbox" role="switch"
                  id="sw{{ $acc->id }}" value="{{ $acc->id }}"
                  onchange="updateStatus(this)"
                  @if($acc->status == 1) checked @endif>
              </div>
            </td>
            <td class="text-center">
              <a href="{{ route('admin.ai.edit', $acc->id) }}" class="btn btn-sm btn-warning" title="Sửa & quản lý biến thể">
                <i class="fa-solid fa-pen-to-square"></i>
              </a>
              <button class="btn btn-sm btn-danger" onclick="deleteRow({{ $acc->id }})">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center py-4 text-muted">Chưa có tài khoản AI nào.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3">{{ $accounts->links() }}</div>
  </div>
</div>


@endsection

@section('scripts')
<script>
function updateStatus(el) {
  fetch('{{ route('admin.ai.update-status') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ id: el.value, status: el.checked ? 1 : 0 })
  }).then(r => r.json()).then(d => {
    if (d.status !== 200) { el.checked = !el.checked; alert(d.message); }
  });
}

function deleteRow(id) {
  if (!confirm('Xác nhận xóa tài khoản AI #' + id + '?')) return;
  fetch('{{ route('admin.ai.delete') }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ id })
  }).then(r => r.json()).then(d => {
    if (d.status === 200) location.reload();
    else alert(d.message);
  });
}
</script>
@endsection
