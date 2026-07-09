@extends('seller.layouts.master')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Chỉnh sửa sản phẩm</h1>
    <p class="text-muted mb-0">Cập nhật thông tin chi tiết hoặc bổ sung kho tài khoản cho dịch vụ số của bạn.</p>
</div>

<div class="premium-card">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Left Column: Primary Fields -->
            <div class="col-lg-8">
                <div class="mb-4">
                    <label class="form-label required fw-semibold" for="product_name">Tên sản phẩm</label>
                    <input type="text" class="form-control form-control-lg shadow-none" id="product_name" name="product_name" value="{{ old('product_name', $product->name) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label required fw-semibold" for="category">Danh mục sản phẩm</label>
                    <select class="form-select form-select-lg" id="category" name="category" required>
                        @foreach(App\Models\Product::CATEGORIES as $key => $cat)
                            <option value="{{ $key }}" {{ $product->category == $key ? 'selected' : '' }}>{{ $cat['icon'] }} {{ $cat['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- DYNAMIC AREA: File Download Link OR Accounts Stock Area -->
                <div class="card bg-light border border-secondary-subtle p-4 mb-4" id="dynamicFieldsArea">
                    <!-- File Download Input -->
                    <div id="fileTypeGroup" class="{{ in_array($product->category, ['account', 'mail', 'via_bm', 'clone']) ? 'd-none' : '' }}">
                        <label class="form-label fw-semibold" for="link_down"><i class="fas fa-link text-warning me-2"></i>Đường dẫn tải xuống file / source code</label>
                        <input type="url" class="form-control" id="link_down" name="link_down" value="{{ old('link_down', App\Helpers\Helper::muabanwebsite_dec($product->link_down)) }}">
                        <small class="text-muted d-block mt-2">Đường dẫn này tự động bàn giao cho khách mua code.</small>
                    </div>

                    <!-- Account Pasting Input (Supplemental) -->
                    <div id="accountTypeGroup" class="{{ in_array($product->category, ['account', 'mail', 'via_bm', 'clone']) ? '' : 'd-none' }}">
                        <!-- Switch for Variants -->
                        <div class="form-check form-switch mb-4 p-3 bg-white rounded border border-warning-subtle">
                            <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" id="has_variants" name="has_variants" value="1" {{ $variants->isNotEmpty() ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-warning-emphasis" for="has_variants">Bán theo phân loại hàng (Biến thể sản phẩm)</label>
                        </div>

                        <!-- Single Mode Stock Block -->
                        <div id="singleAccountBlock" class="{{ $variants->isNotEmpty() ? 'd-none' : '' }}">
                            <!-- Stock Status Widget -->
                            <div class="alert bg-white border border-success-subtle d-flex align-items-center mb-4 p-3 rounded">
                                <div class="p-2 bg-success-subtle text-success rounded-circle me-3">
                                    <i class="fas fa-warehouse"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-success-emphasis">Trạng thái kho hàng hiện tại (Đơn lẻ)</h6>
                                    <span class="fs-7 text-muted">Đang còn: <strong>{{ $stockCount }}</strong> chưa bán | Đã bán: <strong>{{ $soldCount }}</strong> tài khoản</span>
                                </div>
                            </div>

                            <label class="form-label fw-semibold" for="add_accounts_list"><i class="fas fa-plus text-warning me-2"></i>Nhập bổ sung danh sách tài khoản (mỗi dòng 1 tài khoản, để trống nếu không thêm)</label>
                            <textarea class="form-control" id="add_accounts_list" name="add_accounts_list" rows="6" placeholder="username3|password3|2fa_3
username4|password4|2fa_4"></textarea>
                        </div>

                        <!-- Variant Mode Stock Block -->
                        <div id="variantAccountBlock" class="{{ $variants->isNotEmpty() ? '' : 'd-none' }}">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="form-label fw-semibold mb-0"><i class="fas fa-cubes text-warning me-2"></i>Danh sách phân loại hàng</label>
                                <button type="button" class="btn btn-sm btn-warning fw-bold text-dark" id="btnAddVariant">
                                    <i class="fas fa-plus me-1"></i>Thêm phân loại mới
                                </button>
                            </div>
                            
                            <div id="variantsContainer">
                                @foreach($variants as $v)
                                    <div class="variant-row card border border-dashed mb-3 p-3 bg-white" id="variant-row-{{ $v->id }}">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h6 class="fw-bold text-dark-emphasis mb-0">Phân loại hàng: <span class="var-name-text">{{ $v->name }}</span></h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger py-0.5 px-2 btn-remove-variant" onclick="removeVariantRow('{{ $v->id }}')"><i class="fas fa-trash me-1"></i>Xóa</button>
                                        </div>
                                        <div class="row g-3 mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label required fs-7 fw-semibold">Tên phân loại</label>
                                                <input type="text" class="form-control form-control-sm" name="variants[{{ $v->id }}][name]" value="{{ $v->name }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label required fs-7 fw-semibold">Giá bán (VNĐ)</label>
                                                <input type="number" class="form-control form-control-sm" name="variants[{{ $v->id }}][price]" value="{{ $v->price }}" min="0" required>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <label class="form-label fs-7 fw-semibold mb-0">Bổ sung tài khoản (mỗi dòng 1 nick)</label>
                                                <span class="badge bg-success-subtle text-success-emphasis">Đang còn: {{ $v->accounts_count }}</span>
                                            </div>
                                            <textarea class="form-control form-control-sm" name="variants[{{ $v->id }}][add_accounts]" rows="3" placeholder="Nhập thêm nick mới để bổ sung vào kho phân loại này..."></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label required fw-semibold" for="description">Mô tả sản phẩm</label>
                    <textarea class="form-control shadow-none" id="description" name="description" rows="6" required>{{ old('description', $product->intro) }}</textarea>
                </div>
            </div>

            <!-- Right Column: Sidebar Settings (Price, Image, etc.) -->
            <div class="col-lg-4">
                <div class="card p-4 border bg-light-subtle mb-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-tags text-warning me-2"></i>Cài đặt giá & Ảnh</h5>
                    
                    <div class="mb-3" id="priceInputGroup">
                        <label class="form-label required fw-semibold" for="price">Giá bán (VNĐ)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required>
                            <span class="input-group-text">₫</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="ck">Chiết khấu (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="ck" name="ck" value="{{ old('ck', $product->ck) }}" min="0" max="100">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label fw-semibold mb-0" for="images">Ảnh đại diện sản phẩm</label>
                            <a href="{{ $product->images }}" target="_blank" class="fs-7 text-warning">Xem ảnh hiện tại</a>
                        </div>
                        <input type="file" class="form-control" id="images" name="images" accept="image/*">
                        <div class="mt-2 text-center" id="imagePreviewContainer">
                            <img id="imagePreview" src="{{ $product->images }}" class="img-thumbnail" style="max-height: 180px; border-radius: 10px; border: 1px solid rgba(255, 215, 0, 0.3); padding: 5px; background: rgba(255, 255, 255, 0.1);">
                        </div>
                        <small class="text-muted fs-7">Để trống nếu muốn giữ nguyên ảnh đại diện hiện tại.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="link_demo">Link Demo / Preview</label>
                        <input type="url" class="form-control" id="link_demo" name="link_demo" value="{{ old('link_demo', $product->link_demo) }}">
                    </div>
                    
                    <div class="mb-3 d-none">
                        <input type="hidden" name="list_images" value="{{ $product->list_images }}">
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-warning btn-lg fw-bold text-dark" type="submit">
                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                    </button>
                    <a href="{{ route('seller.products') }}" class="btn btn-light border py-2.5">Quay lại danh sách</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const categorySelect = document.getElementById('category');
        const fileTypeGroup = document.getElementById('fileTypeGroup');
        const accountTypeGroup = document.getElementById('accountTypeGroup');
        const linkDown = document.getElementById('link_down');

        const accountCategories = ['account', 'mail', 'via_bm', 'clone'];

        categorySelect.addEventListener('change', function() {
            const val = this.value;
            if (accountCategories.includes(val)) {
                accountTypeGroup.classList.remove('d-none');
                fileTypeGroup.classList.add('d-none');
                linkDown.removeAttribute('required');
            } else {
                fileTypeGroup.classList.remove('d-none');
                accountTypeGroup.classList.add('d-none');
                linkDown.setAttribute('required', 'required');
            }
        });

        let newVariantCount = 0;
        const hasVariantsCheckbox = document.getElementById('has_variants');
        const singleAccountBlock = document.getElementById('singleAccountBlock');
        const variantAccountBlock = document.getElementById('variantAccountBlock');
        const variantsContainer = document.getElementById('variantsContainer');
        const btnAddVariant = document.getElementById('btnAddVariant');

        function togglePriceInput() {
            if (hasVariantsCheckbox.checked) {
                document.getElementById('priceInputGroup').classList.add('d-none');
                document.getElementById('price').removeAttribute('required');
                document.getElementById('price').value = 0;
            } else {
                document.getElementById('priceInputGroup').classList.remove('d-none');
                document.getElementById('price').setAttribute('required', 'required');
            }
        }

        hasVariantsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                singleAccountBlock.classList.add('d-none');
                variantAccountBlock.classList.remove('d-none');
                
                if (variantsContainer.children.length === 0) {
                    addVariantRow();
                }
            } else {
                singleAccountBlock.classList.remove('d-none');
                variantAccountBlock.classList.add('d-none');
            }
            togglePriceInput();
        });

        togglePriceInput();

        const imagesInput = document.getElementById('images');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');

        imagesInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

        function addVariantRow() {
            const index = 'new_' + (newVariantCount++);
            const rowHtml = `
                <div class="variant-row card border border-dashed mb-3 p-3 bg-white" id="variant-row-${index}">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="fw-bold text-dark-emphasis mb-0">Phân loại mới <span class="var-idx"></span></h6>
                        <button type="button" class="btn btn-sm btn-outline-danger py-0.5 px-2 btn-remove-variant" onclick="removeVariantRow('${index}')"><i class="fas fa-trash me-1"></i>Xóa</button>
                    </div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label class="form-label required fs-7 fw-semibold">Tên phân loại</label>
                            <input type="text" class="form-control form-control-sm" name="variants[${index}][name]" placeholder="Ví dụ: US Cổ, VN Cổ..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required fs-7 fw-semibold">Giá bán (VNĐ)</label>
                            <input type="number" class="form-control form-control-sm" name="variants[${index}][price]" placeholder="0" min="0" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label required fs-7 fw-semibold">Danh sách tài khoản (mỗi dòng 1 nick)</label>
                        <textarea class="form-control form-control-sm" name="variants[${index}][add_accounts]" rows="3" placeholder="user|pass|2fa" required></textarea>
                    </div>
                </div>
            `;
            $(variantsContainer).append(rowHtml);
        }

        if (btnAddVariant) {
            btnAddVariant.addEventListener('click', function(e) {
                e.preventDefault();
                addVariantRow();
            });
        }

        window.removeVariantRow = function(id) {
            const row = document.getElementById(`variant-row-${id}`);
            if (row) {
                row.remove();
            }
        };
    });
</script>
@endsection
