@extends('admin.layouts.master')
@section('title', 'Danh mục Tài Khoản AI')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0 fw-bold">🗂️ Danh mục Tài Khoản AI</h4>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.ai.index') }}" class="btn btn-outline-secondary btn-sm">← Danh sách tài khoản</a>
    <button data-bs-toggle="modal" data-bs-target="#modal-create" class="btn btn-primary btn-sm">
      <i class="fas fa-plus"></i> Thêm danh mục
    </button>
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
      <table class="table table-bordered table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th width="50">#</th>
            <th>Tên danh mục</th>
            <th>Slug</th>
            <th>Icon / Hình</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th width="120">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $cat)
          <tr>
            <td>{{ $cat->id }}</td>
            <td class="fw-semibold">{{ $cat->name }}</td>
            <td><code>{{ $cat->slug }}</code></td>
            <td>
              @if($cat->icon_url)
                @if(Str::startsWith($cat->icon_url, 'http'))
                  <img src="{{ $cat->icon_url }}" height="32" class="rounded">
                @else
                  <span style="font-size:1.4rem;">{{ $cat->icon_url }}</span>
                @endif
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td>
              @if($cat->is_active)
                <span class="badge bg-success">Hiển thị</span>
              @else
                <span class="badge bg-secondary">Ẩn</span>
              @endif
            </td>
            <td>{{ \Carbon\Carbon::parse($cat->created_at)->format('d/m/Y') }}</td>
            <td class="text-center">
              <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $cat->id }}">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
              <button class="btn btn-sm btn-danger" onclick="deleteCat({{ $cat->id }})">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center py-4 text-muted">Chưa có danh mục nào.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- ══ MODAL TẠO MỚI ══ --}}
<div class="modal fade" id="modal-create" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.ai.categories.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">➕ Thêm danh mục AI</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="vd: ChatGPT" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
            <input type="text" name="slug" class="form-control" placeholder="vd: chatgpt" required>
            <div class="form-text">Chữ thường, không dấu, không khoảng trắng</div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Icon (emoji hoặc URL ảnh)</label>
            <input type="text" name="icon_url" class="form-control" placeholder="vd: 💬 hoặc https://...">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Trạng thái</label>
            <select name="is_active" class="form-select">
              <option value="1">✅ Hiển thị</option>
              <option value="0">❌ Ẩn</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- ══ MODALS SỬA ══ --}}
@foreach($categories as $cat)
<div class="modal fade" id="modal-edit-{{ $cat->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.ai.categories.update') }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{ $cat->id }}">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">✏️ Sửa danh mục #{{ $cat->id }}</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
            <input type="text" name="slug" class="form-control" value="{{ $cat->slug }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Icon (emoji hoặc URL ảnh)</label>
            <input type="text" name="icon_url" class="form-control" value="{{ $cat->icon_url }}">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Trạng thái</label>
            <select name="is_active" class="form-select">
              <option value="1" @selected($cat->is_active)>✅ Hiển thị</option>
              <option value="0" @selected(!$cat->is_active)>❌ Ẩn</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-warning">Cập nhật</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
function deleteCat(id) {
  if (!confirm('Xóa danh mục #' + id + '? Tài khoản AI trong danh mục này sẽ không còn danh mục.')) return;
  fetch('{{ route('admin.ai.categories.delete') }}', {
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
