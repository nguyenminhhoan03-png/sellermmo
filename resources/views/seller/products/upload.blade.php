@extends('seller.layouts.master')

@section('title', 'Đăng bán sản phẩm mới')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Đăng bán sản phẩm mới</h1>
    <p class="text-muted mb-0">Thiết lập thông tin và đưa dịch vụ/sản phẩm số của bạn lên sàn.</p>
</div>

<div class="premium-card">
    <form id="uploadProductForm" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Left Column: Primary Fields -->
            <div class="col-lg-8">
                <div class="mb-4">
                    <label class="form-label required fw-semibold" for="product_name">Tên sản phẩm</label>
                    <input type="text" class="form-control form-control-lg shadow-none" id="product_name" name="product_name" placeholder="Ví dụ: Tool Auto Reg Gmail, Mail cổ 2020..." required>
                </div>

                <div class="mb-4">
                    <label class="form-label required fw-semibold" for="category">Danh mục sản phẩm</label>
                    <select class="form-select form-select-lg" id="category" name="category" required>
                        <option value="">-- Chọn danh mục sản phẩm --</option>
                        @foreach(App\Models\Product::CATEGORIES as $key => $cat)
                            <option value="{{ $key }}">{{ $cat['icon'] }} {{ $cat['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- DYNAMIC AREA: File Download Link OR Accounts Stock Area -->
                <div class="card bg-light border border-secondary-subtle p-4 mb-4 d-none" id="dynamicFieldsArea">
                    <!-- File Download Input -->
                    <div id="fileTypeGroup" class="d-none">
                        <label class="form-label required fw-semibold" for="link_down"><i class="fas fa-link text-warning me-2"></i>Đường dẫn tải xuống file / source code</label>
                        <input type="url" class="form-control" id="link_down" name="link_down" placeholder="Nhập link Google Drive, Mediafire, Mega...">
                        <small class="text-muted d-block mt-2">Dùng để tự động bàn giao link tải khi khách hàng thanh toán thành công.</small>
                    </div>

                    <!-- Account Pasting Input -->
                    <div id="accountTypeGroup" class="d-none">
                        <!-- Switch for Variants -->
                        <div class="form-check form-switch mb-4 p-3 bg-white rounded border border-warning-subtle">
                            <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" id="has_variants" name="has_variants" value="1">
                            <label class="form-check-label fw-bold text-warning-emphasis" for="has_variants">Bán theo phân loại hàng (Biến thể sản phẩm)</label>
                        </div>

                        <!-- Single Mode Stock Block -->
                        <div id="singleAccountBlock">
                            <label class="form-label required fw-semibold" for="accounts_list"><i class="fas fa-clipboard-list text-warning me-2"></i>Danh sách tài khoản (Nhập kho tự động)</label>
                            <textarea class="form-control" id="accounts_list" name="accounts_list" rows="8" placeholder="Định dạng ví dụ:
username1|password1|recoverymail1
username2|password2|recoverymail2
(Mỗi dòng tương ứng với 1 tài khoản được bàn giao cho 1 lượt mua)"></textarea>
                            <small class="text-muted d-block mt-2">Mỗi dòng text sẽ được coi là 1 sản phẩm tài khoản riêng biệt. Khi có khách mua, hệ thống tự lấy ra giao cho khách và giảm số dư tồn kho tương ứng.</small>
                        </div>

                        <!-- Variant Mode Stock Block -->
                        <div id="variantAccountBlock" class="d-none">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="form-label fw-semibold mb-0"><i class="fas fa-cubes text-warning me-2"></i>Danh sách phân loại hàng</label>
                                <button type="button" class="btn btn-sm btn-warning fw-bold text-dark" id="btnAddVariant">
                                    <i class="fas fa-plus me-1"></i>Thêm phân loại mới
                                </button>
                            </div>
                            
                            <div id="variantsContainer">
                                <!-- Dynamic variants row will be injected here by JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label required fw-semibold" for="description">Mô tả sản phẩm</label>
                    <textarea class="form-control shadow-none" id="description" name="description" rows="6" placeholder="Mô tả chi tiết tính năng sản phẩm, chính sách bảo hành, hướng dẫn sử dụng..." required></textarea>
                </div>
            </div>

            <!-- Right Column: Sidebar Settings (Price, Image, etc.) -->
            <div class="col-lg-4">
                <div class="card p-4 border bg-light-subtle mb-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-tags text-warning me-2"></i>Cài đặt giá & Ảnh</h5>
                    
                    <div class="mb-3" id="priceInputGroup">
                        <label class="form-label required fw-semibold" for="price">Giá bán (VNĐ)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="price" name="price" min="0" placeholder="0" required>
                            <span class="input-group-text">₫</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="ck">Chiết khấu (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="ck" name="ck" min="0" max="100" placeholder="0">
                            <span class="input-group-text">%</span>
                        </div>
                        <small class="text-muted fs-7">Tỷ lệ giảm giá cho khách mua hàng.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required fw-semibold" for="images">Ảnh đại diện sản phẩm</label>
                        <input type="file" class="form-control" id="images" name="images" accept="image/*" required>
                        <div class="mt-2 text-center d-none" id="imagePreviewContainer">
                            <img id="imagePreview" src="" class="img-thumbnail" style="max-height: 180px; border-radius: 10px; border: 1px solid rgba(255, 215, 0, 0.3); padding: 5px; background: rgba(255, 255, 255, 0.1);">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="link_demo">Link Demo / Preview (Nếu có)</label>
                        <input type="url" class="form-control" id="link_demo" name="link_demo" placeholder="https://demo.example.com">
                    </div>
                    
                    <div class="mb-3 d-none">
                        <label class="form-label fw-semibold" for="list_images">Danh sách ảnh phụ (Ngăn cách bằng dấu phẩy)</label>
                        <input type="text" class="form-control" id="list_images" name="list_images" placeholder="https://imgur.com/image1.png, https://imgur.com/image2.png">
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-warning btn-lg fw-bold text-dark" type="submit" id="btnSubmit">
                        <i class="fas fa-paper-plane me-2"></i>Đăng bán ngay
                    </button>
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
        const dynamicFieldsArea = document.getElementById('dynamicFieldsArea');
        const fileTypeGroup = document.getElementById('fileTypeGroup');
        const accountTypeGroup = document.getElementById('accountTypeGroup');
        const linkDown = document.getElementById('link_down');
        const accountsList = document.getElementById('accounts_list');

        // Categories that deliver text account lines dynamically
        const accountCategories = ['account', 'mail', 'via_bm', 'clone'];

        let variantCount = 0;
        const hasVariantsCheckbox = document.getElementById('has_variants');
        const singleAccountBlock = document.getElementById('singleAccountBlock');
        const variantAccountBlock = document.getElementById('variantAccountBlock');
        const variantsContainer = document.getElementById('variantsContainer');
        const btnAddVariant = document.getElementById('btnAddVariant');

        categorySelect.addEventListener('change', function() {
            const val = this.value;
            if (!val) {
                dynamicFieldsArea.classList.add('d-none');
                fileTypeGroup.classList.add('d-none');
                accountTypeGroup.classList.add('d-none');
                linkDown.removeAttribute('required');
                accountsList.removeAttribute('required');
                return;
            }

            dynamicFieldsArea.classList.remove('d-none');

            if (accountCategories.includes(val)) {
                // Show Accounts block, Hide File download block
                accountTypeGroup.classList.remove('d-none');
                fileTypeGroup.classList.add('d-none');
                
                linkDown.removeAttribute('required');
                if (hasVariantsCheckbox.checked) {
                    accountsList.removeAttribute('required');
                } else {
                    accountsList.setAttribute('required', 'required');
                }
            } else {
                // Show File download block, Hide Accounts block
                fileTypeGroup.classList.remove('d-none');
                accountTypeGroup.classList.add('d-none');
                
                linkDown.setAttribute('required', 'required');
                accountsList.removeAttribute('required');
            }
        });

        hasVariantsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                singleAccountBlock.classList.add('d-none');
                variantAccountBlock.classList.remove('d-none');
                accountsList.removeAttribute('required');
                
                document.getElementById('priceInputGroup').classList.add('d-none');
                document.getElementById('price').removeAttribute('required');
                document.getElementById('price').value = 0;
                
                if (variantCount === 0) {
                    addVariantRow();
                }
            } else {
                singleAccountBlock.classList.remove('d-none');
                variantAccountBlock.classList.add('d-none');
                
                document.getElementById('priceInputGroup').classList.remove('d-none');
                document.getElementById('price').setAttribute('required', 'required');
                
                const val = categorySelect.value;
                if (accountCategories.includes(val)) {
                    accountsList.setAttribute('required', 'required');
                }
            }
        });

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
            } else {
                imagePreview.src = '';
                imagePreviewContainer.classList.add('d-none');
            }
        });

        function addVariantRow() {
            const index = variantCount++;
            const rowHtml = `
                <div class="variant-row card border border-dashed mb-3 p-3 bg-white" id="variant-row-${index}">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="fw-bold text-dark-emphasis mb-0">Phân loại hàng #<span class="var-idx">${variantsContainer.children.length + 1}</span></h6>
                        <button type="button" class="btn btn-sm btn-outline-danger py-0.5 px-2 btn-remove-variant" onclick="removeVariantRow(${index})"><i class="fas fa-trash me-1"></i>Xóa</button>
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
                        <textarea class="form-control form-control-sm" name="variants[${index}][accounts]" rows="3" placeholder="user|pass|2fa" required></textarea>
                    </div>
                </div>
            `;
            $(variantsContainer).append(rowHtml);
        }

        btnAddVariant.addEventListener('click', function(e) {
            e.preventDefault();
            addVariantRow();
        });

        window.removeVariantRow = function(index) {
            const row = document.getElementById(`variant-row-${index}`);
            if (row) {
                row.remove();
                const labels = variantsContainer.querySelectorAll('.var-idx');
                labels.forEach((label, idx) => {
                    label.textContent = idx + 1;
                });
            }
        };

        // Submit form via AJAX
        $('#uploadProductForm').on('submit', function(e) {
            e.preventDefault();
            
            const name = $('#product_name').val();
            const category = $('#category').val();
            const price = $('#price').val();
            const desc = $('#description').val();
            
            if(!name || !category || !price || !desc) {
                Swal.fire('Thiếu thông tin!', 'Vui lòng điền đầy đủ các trường thông tin bắt buộc.', 'warning');
                return;
            }

            const formData = new FormData(this);
            
            Swal.fire({
                title: 'Đang đăng tải sản phẩm...',
                text: 'Hệ thống đang upload hình ảnh và xử lý dữ liệu. Vui lòng không đóng trang.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('seller.products.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.close();
                    if (response.status == 200) {
                        Swal.fire({
                            title: 'Thành công!',
                            text: response.message,
                            icon: 'success'
                        }).then(() => {
                            window.location.href = "{{ route('seller.products') }}";
                        });
                    } else {
                        Swal.fire('Lỗi!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let errMsg = 'Đã xảy ra lỗi không xác định.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    Swal.fire('Lỗi!', errMsg, 'error');
                }
            });
        });
    });
</script>
@endsection
