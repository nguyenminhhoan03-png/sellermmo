@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')

<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Đăng tải sản phẩm</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</li>
                <li class="breadcrumb-item text-gray-500">Mã Nguồn</li>
            </ul>
        </div>
        <div class="d-flex align-items-center py-2">
            <div class="me-4">
                <a href="/account/product" class="btn btn-sm btn-flex btn-light btn-active-danger fw-bold">
                    <i class="ki-duotone ki-filter fs-5 text-gray-500 me-1"
                        ><span class="path1"></span><span class="path2"></span
                    ></i>
                    Sản Phẩm
                </a>
            </div>
        </div>
    </div>
</div>
<div id="kt_app_content" class="app-content  flex-column-fluid " >
    <div id="kt_app_content_container" class="app-container  container-xxl ">
<form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" action="" method="POST" data-kt-redirect="/metronic8/demo1/apps/ecommerce/catalog/products.html">
    @csrf
<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
<div class="card card-flush py-4">
<div class="card-header">
    <div class="card-title">
        <h2>Thumbnail</h2>
    </div>
</div>
<div class="card-body text-center pt-0">
        <style>
            .image-input-placeholder {
                background-image: url('/metronic8/demo1/assets/media/svg/files/blank-image.svg');
            }

            [data-bs-theme="dark"] .image-input-placeholder {
                background-image: url('/metronic8/demo1/assets/media/svg/files/blank-image-dark.svg');
            }                
        </style>
            
    <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                        <div class="image-input-wrapper w-150px h-150px"></div>
        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
            <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
            <input type="file" name="images" accept=".png, .jpg, .jpeg" />
            <input type="hidden" name="avatar_remove" />
        </label>
        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
            <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>            </span>
        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
            <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>            </span>
    </div>
    <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
</div>
</div>
<div class="card card-flush py-4">
<div class="card-header">
    <div class="card-title">
        <h2>Status</h2>
    </div>
    <div class="card-toolbar">
        <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
    </div>
</div>
<div class="card-body pt-0">
    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select">
        <option></option>
        <option value="1" selected>Hoạt Động</option>
        <option value="2">Chờ Duyệt</option>
        <option value="0">Không Hoạt Động</option>
    </select>
    <div class="text-muted fs-7">Set the product status.</div>
    <div class="d-none mt-10">
        <label for="kt_ecommerce_add_product_status_datepicker" class="form-label">Select publishing date and time</label>
        <input class="form-control" id="kt_ecommerce_add_product_status_datepicker" placeholder="Pick date & time" />
    </div>
</div>
</div>
<div class="card card-flush py-4">
    <div class="card-header">
        <div class="card-title">
            <h2>Link Tải Code</h2>
        </div>
    </div>
    <div class="card-body pt-0">
        <input type="text" name="link_down" class="form-control mb-2" placeholder="Nhập link tải code" value="" data-gtm-form-interact-field-id="4">
    </div>
</div>
<div class="card card-flush py-4">
    <div class="card-header">
        <div class="card-title">
            <h2>Link Demo</h2>
        </div>
    </div>
    <div class="card-body pt-0">
        <input type="text" name="link_demo" class="form-control mb-2" placeholder="Nhập link demo" value="" data-gtm-form-interact-field-id="4">
    </div>
</div>
  </div>
<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
<li class="nav-item">
    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">Thông Tin Sản Phẩm</a>
</li>
</ul>
    <div class="tab-content">
    <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
            <div class="d-flex flex-column gap-7 gap-lg-10">
<div class="card card-flush py-4">
<div class="card-header">
    <div class="card-title">
        <h2>Thông Tin</h2>
    </div>
</div>
<div class="card-body pt-0">
    <div class="mb-10 fv-row">
        <label class="required form-label">Tên Sản Phẩm</label>
                    <input type="text" name="product_name" class="form-control mb-2" placeholder="Tên Sản Phẩm" value="" />
        <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>
    </div>
    <div>
        <label class="form-label">Mô Tả</label>
        <div id="kt_ecommerce_add_product_description" name="description" class="min-h-200px mb-2"></div>
        <div class="text-muted fs-7">Set a description to the product for better visibility.</div>
    </div>
</div>
</div>
<div class="card card-flush py-4">
<div class="card-header">
    <div class="card-title">
        <h2>Danh sách ảnh</h2>
    </div>
</div>
<div class="card-body pt-0">
    <div class="fv-row mb-2">
        <textarea class="form-control" name="list_images" placeholder="Nhập link ảnh" data-kt-autosize="true"></textarea>
    </div>
    <div class="text-muted fs-7">Mỗi ảnh là 1 link (xuống dòng).</div>
</div>
</div>
<div class="card card-flush py-4">
<div class="card-header">
    <div class="card-title">
        <h2>Pricing</h2>
    </div>
</div>
<div class="card-body pt-0">
    <div class="mb-10 fv-row">
        <label class="required form-label">Giá Sản Phẩm</label>
        <input type="number" name="price" class="form-control mb-2" placeholder="giá sản phẩm" value="" />
        <div class="text-muted fs-7">Đặt giá sản phẩm.</div>
    </div>
    <div class="fv-row mb-10">
        <label class="fs-6 fw-semibold mb-2">
            Chiết Khấu
<span class="ms-1"  data-bs-toggle="tooltip" title="Select a discount type that will be applied to this product" >
<i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>  
   </label>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-1 row-cols-xl-3 g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
            <div class="col">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6" data-kt-button="true">
                    <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                        <input class="form-check-input" type="radio" name="discount_option" value="1" checked="checked" />
                                                </span>
                    <span class="ms-5">
                        <span class="fs-4 fw-bold text-gray-800 d-block">Không Giảm Giá</span>
                    </span>
                </label>
            </div>
            <div class="col">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary  d-flex text-start p-6" data-kt-button="true">
                    <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                        <input class="form-check-input" type="radio" name="discount_option" value="2" />
                                                </span>
                    <span class="ms-5">
                        <span class="fs-4 fw-bold text-gray-800 d-block">Phần Trăm %</span>
                    </span>
                </label>
            </div>
            <div class="col">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6" data-kt-button="true">
                    <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                        <input class="form-check-input" type="radio" name="discount_option" value="3" />
                    </span>
                    <span class="ms-5">
                        <span class="fs-4 fw-bold text-gray-800 d-block">Nhập Chiết Khấu</span>
                    </span>
                </label>
            </div>
        </div>
    </div>
    <div class="d-none mb-10 fv-row" id="kt_ecommerce_add_product_discount_percentage">
        <label class="form-label">Set % giảm giá</label>
        <div class="d-flex flex-column text-center mb-5">
            <div class="d-flex align-items-start justify-content-center mb-7">
                <span class="fw-bold fs-3x" id="kt_ecommerce_add_product_discount_label">0</span>
                <span class="fw-bold fs-4 mt-1 ms-2">%</span>
            </div>
            <div id="kt_ecommerce_add_product_discount_slider" class="noUi-sm"></div>
        </div>
        <div class="text-muted fs-7">Đặt mức giảm giá phần trăm sẽ được áp dụng cho sản phẩm này.</div>
    </div>
    <div class="d-none mb-10 fv-row" id="kt_ecommerce_add_product_discount_fixed">
        <label class="form-label">Giá chiết khấu cố định</label>
        <input type="text" name="dicsounted_price" class="form-control mb-2" placeholder="Nhập chiết khấu" />
        <div class="text-muted fs-7">Khi nhập chiết khấu sẽ được tính theo số % để giảm</div>
           </div>
         </div>
       </div>
            </div>
        </div>
                </div>
    <div class="d-flex justify-content-end mb-10">
        <a href="/account/product/upload" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">
            Tải lại trang
        </a>
        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
            <span class="indicator-label">
                Save Changes
            </span>
            <span class="indicator-progress">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
</div>
</form>       
</div>
</div>
@endsection
@section('scripts')
<script>
    let descriptionEditor;
    InlineEditor
        .create(document.querySelector('#kt_ecommerce_add_product_description'))
        .then(editor => {
            descriptionEditor = editor;
        })
        .catch(error => {
            console.error('Editor initialization error:', error);
        });
    let formValidationInstance;
    const formElement = document.getElementById("kt_ecommerce_add_product_form");
    const submitButton = document.getElementById("kt_ecommerce_add_product_submit");

    formValidationInstance = FormValidation.formValidation(formElement, {
        fields: {
            product_name: {
                validators: {
                    notEmpty: {
                        message: "Tên sản phẩm là bắt buộc"
                    }
                }
            },
            price: {
                validators: {
                    notEmpty: {
                        message: "Giá bán là bắt buộc"
                    }
                }
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: ".fv-row",
                eleInvalidClass: "",
                eleValidClass: ""
            })
        }
    });
    submitButton.addEventListener("click", async function (event) {
        event.preventDefault();
        const isValid = await formValidationInstance.validate();

        if (isValid === 'Valid') {
            const formData = new FormData(formElement);
            const description = descriptionEditor.getData();
            formData.append('description', description);

            Swal.fire({
                icon: 'info',
                title: 'Processing...',
                text: 'Vui lòng đợi xử lý, không được tắt trang!',
                padding: '2em',
                customClass: 'sweet-alerts',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            try {
                const response = await fetch('/account/product/upload', {
                    method: 'POST',
                    body: formData,
                });
                const result = await response.json();

                if (result.status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Great!',
                        text: result.message || 'Sản phẩm đã được tải lên thành công!',
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Không thể tải lên sản phẩm.',
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Đã xảy ra lỗi khi tải lên sản phẩm. Vui lòng thử lại.',
                });
                console.error('Error uploading product:', error);
            }
        } else {
            Swal.fire({
                text: "Vui lòng điền đầy đủ các trường bắt buộc trước khi gửi.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    });
    const discountOptions = document.querySelectorAll('input[name="discount_option"]');
    const discountPercentageField = document.getElementById("kt_ecommerce_add_product_discount_percentage");
    const discountFixedField = document.getElementById("kt_ecommerce_add_product_discount_fixed");
    const discountedPriceInput = document.querySelector('input[name="dicsounted_price"]');

    discountOptions.forEach(option => {
        option.addEventListener("change", (event) => {
            switch (event.target.value) {
                case "2":
                    discountPercentageField.classList.remove("d-none");
                    discountFixedField.classList.add("d-none");
                    break;
                case "3":
                    discountPercentageField.classList.add("d-none");
                    discountFixedField.classList.remove("d-none");
                    break;
                default:
                    discountPercentageField.classList.add("d-none");
                    discountFixedField.classList.add("d-none");
                    discountedPriceInput.value = '';
            }
        });
    });
    const discountSlider = document.querySelector("#kt_ecommerce_add_product_discount_slider");
    const discountLabel = document.querySelector("#kt_ecommerce_add_product_discount_label");

    noUiSlider.create(discountSlider, {
        start: [0],
        connect: true,
        range: {
            min: 0,
            max: 100
        }
    });

    discountSlider.noUiSlider.on('update', function (values, handle) {
    const discountPercentage = Math.round(values[handle]);
    discountLabel.textContent = discountPercentage;

    discountedPriceInput.value = discountPercentage;
});

</script>
@endsection
