@extends('admin.layouts.master')
@section('title', isset($account) ? 'Sửa tài khoản AI #' . $account->id : 'Thêm tài khoản AI')

@section('css')
<style>
.form-section {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    padding: 24px;
    margin-bottom: 20px;
}
.form-section-title {
    font-size: .8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #7b8191;
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f0f0;
}
.variant-row {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 10px 12px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.variant-row .vr-label {
    font-size: .72rem;
    color: #7b8191;
    margin-bottom: 2px;
}
.variant-row input {
    border-radius: 6px;
    font-size: .83rem;
    padding: 5px 8px;
    height: auto;
}
.img-preview-box {
    width: 100px;
    height: 100px;
    border-radius: 12px;
    border: 2px dashed #d0d5dd;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    overflow: hidden;
    background: #f8f9fa;
    font-size: 2rem;
    transition: border-color .2s;
}
.img-preview-box:hover { border-color: #6c63ff; }
.img-preview-box img { width: 100%; height: 100%; object-fit: cover; }
</style>
@endsection

@section('content')
@php $isEdit = isset($account); @endphp

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.ai.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bx bx-arrow-back"></i> Quay lại
    </a>
    <h4 class="mb-0 fw-bold">
        {{ $isEdit ? '✏️ Sửa tài khoản AI #' . $account->id : '➕ Thêm tài khoản AI mới' }}
    </h4>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<form action="{{ $isEdit ? route('admin.ai.update') : route('admin.ai.store') }}"
      method="POST" enctype="multipart/form-data" id="ai-form">
  @csrf
  @if($isEdit) <input type="hidden" name="id" value="{{ $account->id }}"> @endif

  <div class="row g-4">
    {{-- ── CỘT TRÁI: Thông tin chính ── --}}
    <div class="col-lg-8">

      <div class="form-section">
        <div class="form-section-title">📝 Thông tin cơ bản</div>
        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label fw-semibold">Tên tài khoản <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $account->name ?? '') }}"
                   placeholder="vd: ChatGPT Plus Shared" required>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Danh mục</label>
            <select name="category_id" class="form-select">
              <option value="">— Chọn danh mục —</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                  @selected(old('category_id', $account->category_id ?? '') == $cat->id)>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Thông tin ngắn</label>
            <input type="text" name="account_info" class="form-control"
                   value="{{ old('account_info', $account->account_info ?? '') }}"
                   placeholder="Ghi chú ngắn, vd: Shared account, renew monthly">
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Mô tả chi tiết</label>
            <textarea name="description" class="form-control" rows="5"
                      placeholder="Mô tả đặc điểm, tính năng...">{{ old('description', $account->description ?? '') }}</textarea>
          </div>
        </div>
      </div>

      {{-- ── BIẾN THỂ (GÓI GIÁ) ── --}}
      <div class="form-section">
        <div class="form-section-title">🏷️ Biến thể / Gói giá</div>

        @if($isEdit)
          {{-- Tài khoản đã tồn tại: quản lý trực tiếp bằng AJAX --}}
          <div id="variant-list">
            @forelse($account->variant as $v)
            <div class="variant-row" id="vrow-{{ $v->id }}">
              <div style="flex:2;min-width:130px;">
                <div class="vr-label">Tên gói</div>
                <input type="text" class="form-control" id="ve-name-{{ $v->id }}" value="{{ $v->variant_name }}">
              </div>
              <div style="flex:1;min-width:90px;">
                <div class="vr-label">Giá bán (đ)</div>
                <input type="number" class="form-control" id="ve-price-{{ $v->id }}" value="{{ $v->price }}" min="0">
              </div>
              <div style="flex:1;min-width:90px;">
                <div class="vr-label">Giá gốc (đ)</div>
                <input type="number" class="form-control" id="ve-old-{{ $v->id }}" value="{{ $v->old_price }}" min="0">
              </div>
              <div style="flex:0 0 70px;">
                <div class="vr-label">Tồn kho</div>
                <input type="number" class="form-control" id="ve-stock-{{ $v->id }}" value="{{ $v->stock_quantity }}" min="0">
              </div>
              <div style="flex:0 0 70px;">
                <div class="vr-label">Số ngày</div>
                <input type="number" class="form-control" id="ve-days-{{ $v->id }}" value="{{ $v->duration_days }}">
              </div>
              <div style="flex:0 0 80px;">
                <div class="vr-label">SKU</div>
                <input type="text" class="form-control" id="ve-sku-{{ $v->id }}" value="{{ $v->sku }}">
              </div>
              <div style="display:flex;flex-direction:column;gap:4px;padding-top:16px;">
                <button type="button" class="btn btn-success btn-sm py-0" onclick="saveVariant({{ $v->id }})">
                  <i class="fas fa-check"></i> Lưu
                </button>
                <button type="button" class="btn btn-danger btn-sm py-0" onclick="deleteVariant({{ $v->id }})">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
            @empty
            <div id="no-variant-msg" class="text-center text-muted py-3">Chưa có biến thể nào</div>
            @endforelse
          </div>

          <hr>
          <div class="fw-semibold mb-2 small text-primary">➕ Thêm gói mới</div>
          <div class="variant-row" style="background:#e8f4ff;">
            <div style="flex:2;min-width:130px;">
              <div class="vr-label">Tên gói <span class="text-danger">*</span></div>
              <input type="text" class="form-control" id="new-vname" placeholder="vd: 1 tháng">
            </div>
            <div style="flex:1;min-width:90px;">
              <div class="vr-label">Giá bán (đ) <span class="text-danger">*</span></div>
              <input type="number" class="form-control" id="new-vprice" placeholder="0" min="0">
            </div>
            <div style="flex:1;min-width:90px;">
              <div class="vr-label">Giá gốc (đ)</div>
              <input type="number" class="form-control" id="new-vold" placeholder="0" min="0">
            </div>
            <div style="flex:0 0 70px;">
              <div class="vr-label">Tồn kho</div>
              <input type="number" class="form-control" id="new-vstock" value="999" min="0">
            </div>
            <div style="flex:0 0 70px;">
              <div class="vr-label">Số ngày</div>
              <input type="number" class="form-control" id="new-vdays" placeholder="30">
            </div>
            <div style="flex:0 0 80px;">
              <div class="vr-label">SKU</div>
              <input type="text" class="form-control" id="new-vsku" placeholder="tuỳ chọn">
            </div>
            <div style="padding-top:16px;">
              <button type="button" class="btn btn-primary btn-sm" onclick="addVariant({{ $account->id }})">
                <i class="fas fa-plus"></i> Thêm
              </button>
            </div>
          </div>

        @else
          {{-- Tài khoản mới: ghi vào array để gửi kèm form --}}
          <div id="new-variant-list"></div>
          <div class="variant-row" style="background:#e8f4ff;">
            <div style="flex:2;min-width:130px;">
              <div class="vr-label">Tên gói <span class="text-danger">*</span></div>
              <input type="text" class="form-control" id="nv-name" placeholder="vd: 1 tháng">
            </div>
            <div style="flex:1;min-width:90px;">
              <div class="vr-label">Giá bán (đ) <span class="text-danger">*</span></div>
              <input type="number" class="form-control" id="nv-price" placeholder="0" min="0">
            </div>
            <div style="flex:1;min-width:90px;">
              <div class="vr-label">Giá gốc (đ)</div>
              <input type="number" class="form-control" id="nv-old" placeholder="0" min="0">
            </div>
            <div style="flex:0 0 70px;">
              <div class="vr-label">Tồn kho</div>
              <input type="number" class="form-control" id="nv-stock" value="999" min="0">
            </div>
            <div style="flex:0 0 70px;">
              <div class="vr-label">Số ngày</div>
              <input type="number" class="form-control" id="nv-days" placeholder="30">
            </div>
            <div style="flex:0 0 80px;">
              <div class="vr-label">SKU</div>
              <input type="text" class="form-control" id="nv-sku" placeholder="tuỳ chọn">
            </div>
            <div style="padding-top:16px;">
              <button type="button" class="btn btn-outline-primary btn-sm" onclick="queueVariant()">
                <i class="fas fa-plus"></i> Thêm vào danh sách
              </button>
            </div>
          </div>
          <div id="queued-variants-hidden"></div>
          <div id="queued-count" class="text-muted small mt-1"></div>
        @endif

      </div>
    </div>

    {{-- ── CỘT PHẢI: Ảnh + Trạng thái ── --}}
    <div class="col-lg-4">

      <div class="form-section">
        <div class="form-section-title">🖼️ Ảnh đại diện</div>
        <div class="d-flex flex-column align-items-center gap-3">
          <div class="img-preview-box" onclick="document.getElementById('img-input').click()">
            @if($isEdit && $account->image)
              <img src="{{ img_url($account->image) }}" id="img-preview" onerror="this.parentElement.innerHTML='🤖'">
            @else
              <span id="img-preview-icon">🤖</span>
            @endif
          </div>
          <input type="file" id="img-input" name="image" class="d-none" accept="image/*"
                 onchange="previewImg(this)">
          <button type="button" class="btn btn-outline-secondary btn-sm w-100"
                  onclick="document.getElementById('img-input').click()">
            <i class="bx bx-upload"></i>
            {{ $isEdit && $account->image ? 'Đổi ảnh' : 'Chọn ảnh' }}
          </button>
          <div class="text-muted small text-center">JPG, PNG, GIF, WEBP – tối đa 4MB<br>Click vào ảnh để chọn file</div>
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">⚙️ Cài đặt</div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Trạng thái hiển thị</label>
          <select name="status" class="form-select">
            <option value="1" @selected(old('status', $account->status ?? 1) == 1)>✅ Hoạt động</option>
            <option value="0" @selected(old('status', $account->status ?? 1) == 0)>❌ Ẩn</option>
          </select>
        </div>
        @if($isEdit)
        <div class="text-muted small">
          <i class="bx bx-time"></i> Tạo lúc: {{ $account->created_at->format('d/m/Y H:i') }}<br>
          <i class="bx bx-refresh"></i> Cập nhật: {{ $account->updated_at->format('d/m/Y H:i') }}
        </div>
        @endif
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="fas fa-save"></i>
          {{ $isEdit ? 'Lưu thay đổi' : 'Tạo tài khoản AI' }}
        </button>
        <a href="{{ route('admin.ai.index') }}" class="btn btn-outline-secondary">Hủy bỏ</a>
      </div>

    </div>
  </div>
</form>
@endsection

@section('scripts')
<script>
const CSRF = '{{ csrf_token() }}';

// ── Preview ảnh ──────────────────────────────────────────────────────────────
function previewImg(input) {
  if (!input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const box = input.closest ? document.querySelector('.img-preview-box') : document.querySelector('.img-preview-box');
    box.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
  };
  reader.readAsDataURL(input.files[0]);
}

@if($isEdit)
// ── EDIT MODE: AJAX variant management ───────────────────────────────────────
function saveVariant(id) {
  const payload = {
    id,
    variant_name:   document.getElementById('ve-name-' + id).value,
    price:          document.getElementById('ve-price-' + id).value,
    old_price:      document.getElementById('ve-old-' + id).value,
    stock_quantity: document.getElementById('ve-stock-' + id).value,
    duration_days:  document.getElementById('ve-days-' + id).value,
    sku:            document.getElementById('ve-sku-' + id).value,
  };
  if (!payload.variant_name || !payload.price) { alert('Tên gói và giá bán là bắt buộc!'); return; }
  fetch('{{ route('admin.ai.variant.update') }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    body: JSON.stringify(payload)
  }).then(r => r.json()).then(d => {
    if (d.status === 200) {
      const row = document.getElementById('vrow-' + id);
      row.style.background = '#d4edda';
      setTimeout(() => row.style.background = '', 1200);
    } else alert(d.message);
  });
}

function deleteVariant(id) {
  if (!confirm('Xóa biến thể này?')) return;
  fetch('{{ route('admin.ai.variant.delete') }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    body: JSON.stringify({ id })
  }).then(r => r.json()).then(d => {
    if (d.status === 200) document.getElementById('vrow-' + id)?.remove();
    else alert(d.message);
  });
}

function addVariant(accountId) {
  const name  = document.getElementById('new-vname').value.trim();
  const price = document.getElementById('new-vprice').value;
  if (!name || !price) { alert('Tên gói và giá bán là bắt buộc!'); return; }
  const payload = {
    account_id:     accountId,
    variant_name:   name,
    price,
    old_price:      document.getElementById('new-vold').value || 0,
    stock_quantity: document.getElementById('new-vstock').value || 999,
    duration_days:  document.getElementById('new-vdays').value || null,
    sku:            document.getElementById('new-vsku').value || null,
  };
  fetch('{{ route('admin.ai.variant.store') }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    body: JSON.stringify(payload)
  }).then(r => r.json()).then(d => {
    if (d.status === 200) {
      // thêm row mới vào danh sách
      const list = document.getElementById('variant-list');
      const noMsg = document.getElementById('no-variant-msg');
      if (noMsg) noMsg.remove();
      const newId = d.id;
      const row = document.createElement('div');
      row.className = 'variant-row';
      row.id = 'vrow-' + newId;
      row.style.background = '#d4edda';
      row.innerHTML = buildVariantRow(newId, payload);
      list.insertBefore(row, list.querySelector('hr') || list.firstChild);
      setTimeout(() => row.style.background = '', 1200);
      // reset input
      ['new-vname','new-vprice','new-vold','new-vsku','new-vdays'].forEach(id => document.getElementById(id).value = '');
      document.getElementById('new-vstock').value = 999;
    } else alert(d.message);
  });
}

function buildVariantRow(id, v) {
  const fld = (label, fid, val, type='text', width='') =>
    `<div style="flex:1;min-width:${width || '90px'};">
      <div class="vr-label">${label}</div>
      <input type="${type}" class="form-control" id="ve-${fid}-${id}" value="${val || ''}">
    </div>`;
  return `
    ${fld('Tên gói', 'name', v.variant_name, 'text', '130px')}
    ${fld('Giá bán (đ)', 'price', v.price, 'number')}
    ${fld('Giá gốc (đ)', 'old', v.old_price, 'number')}
    ${fld('Tồn kho', 'stock', v.stock_quantity, 'number', '70px')}
    ${fld('Số ngày', 'days', v.duration_days, 'number', '70px')}
    ${fld('SKU', 'sku', v.sku, 'text', '80px')}
    <div style="display:flex;flex-direction:column;gap:4px;padding-top:16px;">
      <button type="button" class="btn btn-success btn-sm py-0" onclick="saveVariant(${id})"><i class="fas fa-check"></i> Lưu</button>
      <button type="button" class="btn btn-danger btn-sm py-0" onclick="deleteVariant(${id})"><i class="fas fa-trash"></i></button>
    </div>`;
}

@else
// ── CREATE MODE: queue variants vào hidden inputs ────────────────────────────
let queuedVariants = [];

function queueVariant() {
  const name  = document.getElementById('nv-name').value.trim();
  const price = document.getElementById('nv-price').value;
  if (!name || !price) { alert('Tên gói và giá bán là bắt buộc!'); return; }
  const v = {
    variant_name:   name,
    price,
    old_price:      document.getElementById('nv-old').value || 0,
    stock_quantity: document.getElementById('nv-stock').value || 999,
    duration_days:  document.getElementById('nv-days').value || '',
    sku:            document.getElementById('nv-sku').value || '',
  };
  queuedVariants.push(v);
  renderQueuedVariants();
  ['nv-name','nv-price','nv-old','nv-sku','nv-days'].forEach(id => document.getElementById(id).value = '');
  document.getElementById('nv-stock').value = 999;
}

function removeQueued(idx) {
  queuedVariants.splice(idx, 1);
  renderQueuedVariants();
}

function renderQueuedVariants() {
  const list = document.getElementById('new-variant-list');
  const hidden = document.getElementById('queued-variants-hidden');
  list.innerHTML = '';
  hidden.innerHTML = '';
  queuedVariants.forEach((v, i) => {
    list.innerHTML += `
      <div class="variant-row" style="background:#e6f9ef;">
        <div style="flex:2;"><div class="vr-label">Tên gói</div><strong>${v.variant_name}</strong></div>
        <div style="flex:1;"><div class="vr-label">Giá bán</div>${Number(v.price).toLocaleString('vi-VN')}đ</div>
        <div style="flex:1;"><div class="vr-label">Tồn kho</div>${v.stock_quantity}</div>
        <div style="flex:0 0 60px;"><div class="vr-label">Ngày</div>${v.duration_days || '—'}</div>
        <button type="button" class="btn btn-sm btn-danger py-0 px-1 ms-auto" onclick="removeQueued(${i})"><i class="fas fa-times"></i></button>
      </div>`;
    Object.entries(v).forEach(([k, val]) => {
      hidden.innerHTML += `<input type="hidden" name="variants[${i}][${k}]" value="${val}">`;
    });
  });
  document.getElementById('queued-count').textContent =
    queuedVariants.length ? `✅ ${queuedVariants.length} biến thể sẽ được thêm khi lưu` : '';
}
@endif
</script>
@endsection
