@extends('seller.layouts.master')

@section('title', 'Kho sản phẩm - Kênh Người Bán')

@section('content')
<style>
    /* Styling to match shopmini.pro product warehouse view */
    .warehouse-header-card {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        border-radius: 12px;
        padding: 20px 24px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.05);
    }

    .warehouse-title {
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

    .warehouse-subtitle {
        font-size: 0.8rem;
        font-weight: 500;
        color: #94a3b8;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-add-product-black {
        background: var(--primary-gradient);
        color: #fff;
        font-size: 0.8rem;
        font-weight: 700;
        border-radius: 8px;
        padding: 10px 20px;
        text-decoration: none;
        transition: all 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(245, 124, 0, 0.2);
    }

    .btn-add-product-black:hover {
        background: linear-gradient(135deg, #f57c00, #e65100);
        color: #fff;
    }

    /* Filter Bar style */
    .filter-bar-card {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 12px 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .filter-input {
        font-size: 0.82rem;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 8px 12px;
        height: 38px;
    }

    .filter-input:focus {
        border-color: var(--gold-primary);
        box-shadow: 0 0 0 0.2rem rgba(255, 211, 5, 0.25);
    }

    .btn-filter-yellow {
        background: var(--primary-gradient);
        color: #fff;
        font-size: 0.8rem;
        font-weight: 700;
        height: 38px;
        border: none;
        border-radius: 4px;
        padding: 0 25px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(245, 124, 0, 0.15);
    }

    .btn-filter-yellow:hover {
        background: linear-gradient(135deg, #f57c00, #e65100);
    }

    /* Listing Table style */
    .warehouse-table-card {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .w-table {
        margin-bottom: 0;
    }

    .w-table th {
        font-size: 0.72rem;
        font-weight: 800;
        color: #888899;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #dee2e6;
        padding: 12px 8px;
    }

    .w-table td {
        font-size: 0.8rem;
        border-bottom: 1px solid #eee;
        padding: 15px 8px;
        vertical-align: middle;
    }

    .product-cell {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .product-img {
        width: 48px;
        height: 48px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #dee2e6;
    }

    .product-title-link {
        font-weight: 700;
        color: #0d6efd;
        text-decoration: none;
        font-size: 0.82rem;
        display: block;
        margin-bottom: 3px;
        transition: color 0.15s ease;
    }

    .product-title-link:hover {
        color: #0a58ca;
        text-decoration: underline;
    }

    .cat-badge {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 8px;
        background-color: #e9ecef;
        color: #495057;
        border-radius: 4px;
        display: inline-block;
    }

    .var-badge {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 8px;
        background-color: #fff3cd;
        color: #664d03;
        border-radius: 4px;
        border: 1px solid #ffe69c;
        display: inline-block;
        margin-left: 5px;
    }

    .price-value-bold {
        font-weight: 800;
        color: #333;
        font-size: 0.85rem;
    }

    .price-sub {
        font-size: 0.7rem;
        color: #888;
        display: block;
        margin-top: 1px;
    }

    .status-badge-selling {
        background-color: #d1fae5;
        color: #065f46;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        display: inline-block;
        text-transform: uppercase;
    }

    .status-badge-pending {
        background-color: #6c757d;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 4px;
        letter-spacing: 0.5px;
        display: inline-block;
        text-transform: uppercase;
    }

    .status-badge-maintenance {
        background-color: #dc3545;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 4px;
        letter-spacing: 0.5px;
        display: inline-block;
        text-transform: uppercase;
    }

    .action-group {
        display: flex;
        gap: 6px;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        background-color: #fff;
        color: #555;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background-color: #212529;
        color: #fff;
        border-color: #212529;
    }

    .action-btn-danger:hover {
        background-color: #dc3545;
        color: #fff;
        border-color: #dc3545;
    }
</style>

<!-- Header Card -->
<div class="warehouse-header-card d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
    <div>
        <h5 class="warehouse-title"><i class="fas fa-cubes me-2"></i> Kho Sản Phẩm</h5>
        <p class="warehouse-subtitle"><i class="fas fa-info-circle"></i> Mẹo: Nhấn biểu tượng nhà để xem trên sàn, để sửa thông tin và kho nick.</p>
    </div>
    <div>
        <a href="{{ route('seller.products.upload') }}" class="btn-add-product-black">
            <i class="fas fa-plus me-1"></i> Thêm sản phẩm
        </a>
    </div>
</div>

<!-- Filter Bar -->
<div class="filter-bar-card">
    <form method="GET" action="{{ route('seller.products') }}">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control filter-input" placeholder="Tìm tên sản phẩm..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select filter-input">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang bán</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Bảo trì/Ẩn</option>
                </select>
            </div>
            <div class="col-md-3 d-grid">
                <button type="submit" class="btn-filter-yellow">Lọc dữ liệu</button>
            </div>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="warehouse-table-card">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($products->isEmpty())
        <div class="text-center py-5">
            <p class="text-muted mb-0">Không tìm thấy sản phẩm nào phù hợp.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table w-table align-middle">
                <thead>
                    <tr>
                        <th style="width: 170px;">Thao tác</th>
                        <th>Sản phẩm</th>
                        <th>Kho | Giá</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr id="product-row-{{ $product->id }}">
                            <td>
                                <div class="action-group">
                                    <a href="/view/{{ $product->slug }}" target="_blank" class="action-btn" title="Xem sản phẩm trên sàn">
                                        <i class="fas fa-home"></i>
                                    </a>
                                    <a href="{{ route('seller.products.edit', $product->id) }}" class="action-btn" title="Sửa thông tin sản phẩm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($product->status != 2)
                                        <button class="action-btn btn-toggle-status" data-id="{{ $product->id }}" title="{{ $product->status == 1 ? 'Ẩn sản phẩm' : 'Hiển thị sản phẩm' }}">
                                            @if($product->status == 1)
                                                <i class="fas fa-eye text-success"></i>
                                            @else
                                                <i class="fas fa-eye-slash text-secondary"></i>
                                            @endif
                                        </button>
                                    @else
                                        <button class="action-btn text-muted" disabled title="Chờ admin duyệt để ẩn/hiển thị">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    @endif
                                    <button class="action-btn action-btn-danger btn-delete-product" data-id="{{ $product->id }}" data-name="{{ $product->name }}" title="Xóa sản phẩm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                            
                            <!-- Product Column -->
                            <td>
                                <div class="product-cell">
                                    <img src="{{ $product->images }}" alt="Product" class="product-img" onerror="this.src='https://placehold.co/100x100?text=Product'">
                                    <div>
                                        <a href="{{ route('seller.products.edit', $product->id) }}" class="product-title-link">
                                            {{ $product->name }}
                                        </a>
                                        @php $cat = App\Models\Product::CATEGORIES[$product->category] ?? null; @endphp
                                        <span class="cat-badge">
                                            {{ $cat ? $cat['icon'] . ' ' . $cat['label'] : $product->category }}
                                        </span>
                                        @if($product->has_variants)
                                            @php $variantsCount = $product->variants()->count(); @endphp
                                            <span class="var-badge">
                                                {{ $variantsCount }} Phân loại
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Price & Stock Column -->
                            <td>
                                @if($product->has_variants)
                                    @php
                                        $minPrice = $product->variants()->min('price') ?? 0;
                                        $maxPrice = $product->variants()->max('price') ?? 0;
                                    @endphp
                                    <div class="price-value-bold">
                                        {{ number_format($minPrice) }}đ - {{ number_format($maxPrice) }}đ
                                    </div>
                                @else
                                    <div class="price-value-bold">
                                        {{ number_format($product->price) }}đ
                                    </div>
                                @endif
                                <span class="price-sub">VND / Item</span>
                                <span class="badge bg-light text-dark border mt-1">Kho: {{ $product->stock_count }} chiếc</span>
                            </td>
                            
                            <!-- Status Column -->
                            <td id="status-badge-container-{{ $product->id }}">
                                @if($product->status == 1)
                                    <span class="status-badge-selling">Đang bán</span>
                                @elseif($product->status == 2)
                                    <span class="status-badge-pending">Chờ duyệt</span>
                                @else
                                    <span class="status-badge-maintenance">Ẩn / Bảo trì</span>
                                @endif
                            </td>
                            
                            <!-- Created Date Column -->
                            <td>
                                <span class="text-muted">{{ $product->created_at->format('d/m/Y') }}</span>
                            </td>
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
    $(document).ready(function() {
        $('.btn-delete-product').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            
            Swal.fire({
                title: 'Xác nhận xóa?',
                text: `Bạn có chắc chắn muốn xóa sản phẩm "${name}"? Hành động này cũng sẽ xóa toàn bộ kho tài khoản đi kèm và không thể hoàn tác!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Đồng ý xóa',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('seller.products.delete') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                Swal.fire('Đã xóa!', response.message, 'success');
                                $(`#product-row-${id}`).fadeOut(400, function() {
                                    $(this).remove();
                                });
                            } else {
                                Swal.fire('Lỗi!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Lỗi!', 'Không thể thực hiện yêu cầu.', 'error');
                        }
                    });
                }
            });
        });

        $('.btn-toggle-status').click(function() {
            const btn = $(this);
            const id = btn.data('id');
            
            $.ajax({
                url: "{{ route('seller.products.toggle-status') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire({
                            title: 'Thành công!',
                            text: response.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        const icon = btn.find('i');
                        const badgeContainer = $(`#status-badge-container-${id}`);

                        if (response.new_status == 1) {
                            icon.removeClass('fa-eye-slash text-secondary').addClass('fa-eye text-success');
                            btn.attr('title', 'Ẩn sản phẩm');
                            badgeContainer.html('<span class="status-badge-selling">Đang bán</span>');
                        } else {
                            icon.removeClass('fa-eye text-success').addClass('fa-eye-slash text-secondary');
                            btn.attr('title', 'Hiển thị sản phẩm');
                            badgeContainer.html('<span class="status-badge-maintenance">Ẩn / Bảo trì</span>');
                        }
                    } else {
                        Swal.fire('Lỗi!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Lỗi!', 'Không thể thực hiện yêu cầu.', 'error');
                }
            });
        });
    });
</script>
@endsection
