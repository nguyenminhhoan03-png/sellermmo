@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<style>
    
.product-card {
    border-radius: 8px;
    overflow: hidden;
    transition: 0.2s linear;
    position: relative;
}

.product-card:hover {
    box-shadow: var(--box-shadow);
}

.product-card:hover .product-card__thumb::before {
    height: 100%;
}

.product-card:hover .product-card__thumb img {
    transform: scale(1.1);
}

.product-card:hover .collection-list {
    visibility: visible;
    opacity: 1;
    bottom: 16px;
    justify-content: end;
}

.product-card:hover .collection-list.list-style {
    bottom: 0;
}

.product-card__thumb {
    overflow: hidden;
    position: relative;
    z-index: 1;
    max-height: 180px;
}

.product-card__thumb::before {
    left: 0;
    bottom: 0;
    width: 100%;
    height: 0;
    background: linear-gradient(0deg, #282828 -8.87%, rgba(0, 0, 0, 0) 50.84%);
    z-index: 1;
    pointer-events: none;
    transition: 0.2s linear;
}

.product-card__thumb .link {
    width: 100%;
    height: 100%;
    display: block;
}

.product-card__thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.2s linear;
}

.product-card__content {
    border: 1px solid hsl(var(--black) / 0.05);
    border-top: 0;
    padding: 28px 16px;
    border-radius: inherit;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    background-color: hsl(var(--white));
}

@media screen and (max-width: 1199px) {
    .product-card__content {
        padding: 24px 12px;
    }
}

@media screen and (max-width: 575px) {
    .product-card__content {
        padding: 16px 12px;
    }
}

.product-card__content-inner {
    display: flex;
    justify-content: space-between;
    align-items: start;
    gap: 16px;
}

@media screen and (max-width: 575px) {
    .product-card__content-inner {
        gap: 8px;
    }
}

.product-card__top {
    align-items: start;
    gap: 6px;
}

.product-card__title {
    font-weight: 700;
    margin-bottom: 0;
}

.product-card__title .link {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box !important;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

@media (min-width:425px) and (max-width:550px) {
    .product-card__title .link {
        -webkit-line-clamp: 3;
    }
}

.product-card__title .link:hover {
    color: hsl(var(--base));
}

.product-card__title,
.product-card__price,
.product-card__author,
.product-card__sales {
    font-size: 0.875rem;
}

@media screen and (max-width: 575px) {

    .product-card__title,
    .product-card__price,
    .product-card__author,
    .product-card__sales {
        font-size: 0.8125rem;
    }
}

.product-card__author .link {
    color: hsl(var(--body-color));
}

.product-card__author .link:hover {
    text-decoration: underline;
}

.product-card__price {
    min-width: max-content;
    color: #ff6900;
    font-weight: 500;
    border-radius: 4px;
    background-color: #fff1e7;
    padding: 3px 6px;
}

.product-card__rating {
    margin-top: 12px;
}

.product-card__bottom {
    align-items: end;
}
</style>
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Danh mục sản phẩm</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</li>
                <li class="breadcrumb-item text-gray-500">Sản Phẩm</li>
            </ul>
        </div>
        <div class="d-flex align-items-center py-2">
            <div class="me-4">
                <a href="/account/product/upload" class="btn btn-sm btn-flex btn-light btn-active-danger fw-bold">
                    <i class="ki-duotone ki-filter fs-5 text-gray-500 me-1"
                        ><span class="path1"></span><span class="path2"></span
                    ></i>
                    Đăng Sản Phẩm
                </a>
            </div>
        </div>
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="row gy-4 dashboard-row-wrapper">
            <div class="row gy-4">
                @foreach ($products as $product)
                <div class="col-xl-3 col-lg-3 col-sm-3 col-xsm-3 list-view">
                                <div class="product-card h-100 border shadow-sm">
                                    <div class="product-card__thumb">
                                        <a href="/view/{{ $product->slug ?? $product->id }}" class="link" title="test">
                                            <img src="{{ $product->images }}" alt="Product Image">
                                        </a>
                                    </div>
                                    <div class="product-card__content h-100">
                                        <div class="product-card__content-inner">
                                            <div class="product-card__top d-flex w-100 justify-content-between ">
                                                <div class="product-card-title-wrapper">
                                                    <h6 class="product-card__title">
                                                        <a href="/view/{{ $product->slug ?? $product->id }}" class="link border-effect">
                                                            {{ $product->name }}                                                        </a>
                                                    </h6>
                                                </div>
                                                <span class="product-card__price">{{ number_format($product->price, 0, ',', ',') }}đ</span>
                                            </div>
                                            <div class="collection-list list-style">
                                                <a class="collection-list__button collection-btn product-edit-btn" href="/account/product/edit/{{ $product->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a data-product-id="1" data-product_title="test" href="" class="collection-list__button collection-btn  add-collection-btn " data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to Collection" data-bs-original-title="" title="">
                                                    <i class="fa fa-folder-plus"></i>
                                                </a>

                                            </div>
                                        </div>
                                        <div class="fs-6 fw-bold mt-5 d-flex flex-stack">
                                            <span class="badge border border-dashed fs-2 fw-bold text-gray-900 p-2">
                                                <span class="fs-6 fw-semibold">Đã bán: {{ $product->sold }} </span>
                                            </span>
                                            <!--end::Label-->            
                                            
                                            <!--begin::Action-->
                                            <a href="/view/{{ $product->slug ?? $product->id }}" class="btn btn-sm btn-danger">Live Preview</a>     
                                            <!--end::Action-->              
                                        </div>
                                    </div>
                                </div>
                               </div>
                          @endforeach
                                            </div>

        </div>
    </div>
    <!--end::Post-->
</div>
@endsection
@section('scripts')
  <script>
$("#kt_datatable_zero_configuration").DataTable();
  </script>
@endsection
