@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@php use App\Models\Transaction; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Lấy link ảnh
            </h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">Uploads</li>
                <li class="breadcrumb-item text-gray-500">Images</li>
            </ul>
        </div>
        
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start  container-xxl ">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="col-xl-12 mb-5">
            <div class="card card-flush h-lg-100" id="kt_contacts_main">
                <div class="card-body p-0">
                    <div class="card-px text-center py-20 my-10">
                        <div class="text-center px-4">
                            <img class="mw-100 mh-300px d-block mx-auto mb-5" alt="" src="https://preview.keenthemes.com/metronic8/demo18/assets/media/email/icon-positive-vote-1.svg">
                        </div>
                        <h2 class="fs-2x fw-bold mb-10">Chào mừng bạn đến với công cụ lấy link ảnh</h2>
                        <p class="text-gray-500 fs-4 fw-semibold mb-10">
                            Kích thước tệp tối đa là 20MB và bạn có thể up 10 ảnh cùng lúc.
                        </p>
                        <div class="dropzone dropzone-queue mb-2 text-center mb-5" id="kt_dropzonejs_example_3">
                            <div class="dropzone-panel mb-lg-0 mb-2">
                                <a class="dropzone-select btn btn-sm btn-primary me-2">Tải ảnh lên</a>
                                <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove All</a>
                            </div>
                            <div class="dropzone-items wm-200px">
                                <div class="dropzone-item" style="display:none">
                                    <div class="dropzone-file">
                                        <div class="dropzone-filename" title="some_image_file_name.jpg">
                                            <span data-dz-name>some_image_file_name.jpg</span>
                                            <strong>(<span data-dz-size>340kb</span>)</strong>
                                        </div>
        
                                        <div class="dropzone-error" data-dz-errormessage></div>
                                    </div>
                                    <div class="dropzone-progress">
                                        <div class="progress">
                                            <div
                                                class="progress-bar bg-primary"
                                                role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropzone-toolbar">
                                        <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="img-dvr alert alert-dismissible border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5 justify-content-center align-items-center text-center d-none">
                            <div class="col-lg-12 col-12">
                                <div id="result">
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script>
    const id = "#kt_dropzonejs_example_3";
    const dropzone = document.querySelector(id);

    var previewNode = dropzone.querySelector(".dropzone-item");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var myDropzone = new Dropzone(id, {
        url: "/upanh",
        parallelUploads: 10,
        maxFilesize: 20,
        maxFiles: 10,
        previewTemplate: previewTemplate,
        previewsContainer: id + " .dropzone-items",
        clickable: id + " .dropzone-select"
    });
    var uploadedFilesCount = 0;

    myDropzone.on("addedfile", function (file) {
        uploadedFilesCount++;
        const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
        dropzoneItems.forEach(dropzoneItem => {
            dropzoneItem.style.display = '';
        });
    });

    myDropzone.on("totaluploadprogress", function (progress) {
        const progressBars = dropzone.querySelectorAll('.progress-bar');
        progressBars.forEach(progressBar => {
            progressBar.style.width = progress + "%";
        });
    });

    myDropzone.on("sending", function (file, xhr, formData) {
        formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        const progressBars = dropzone.querySelectorAll('.progress-bar');
        progressBars.forEach(progressBar => {
            progressBar.style.opacity = "1";
        });
    });

    myDropzone.on("success", function (file, response) {
        if (response.status === 'success') {
            $(".img-dvr").removeClass("d-none");
            showMessage(response.message, 'success');
            if (uploadedFilesCount === 1) {
                document.querySelector('#result').innerHTML = `
                    <div class="text-center">
                        <img src="${response.link}" alt="muabanwebsite" class="mw-100 mh-300px d-block mx-auto">
                        <form class="mt-3 mb-2 col-lg-6 mx-auto">
                            <input type="text" value="${response.link}" readonly onclick="this.select(); document.execCommand('copy');" class="form-control is-valid text-center">
                        </form>
                    </div>`;
            } else {
            const resultContainer = document.querySelector('#result');
            const inputElement = `
                <form class="mt-3 mb-2 col-lg-6 mx-auto">
                    <input type="text" value="${response.link}" readonly onclick="this.select(); document.execCommand('copy');" class="form-control is-valid text-center">
                </form>`;
            resultContainer.innerHTML += inputElement;
            }
        } else {
            showMessage(response.message, 'error');
        }
    });

    myDropzone.on("error", function (file, errorMessage) {
        showMessage('Vui lòng liên hệ Developer', 'error');
    });

    myDropzone.on("complete", function (progress) {
        const progressBars = dropzone.querySelectorAll('.dz-complete');
        setTimeout(function () {
            progressBars.forEach(progressBar => {
                progressBar.querySelector('.progress-bar').style.opacity = "0";
                progressBar.querySelector('.progress').style.opacity = "0";
            });
        }, 300);
    });
</script>
    </div>
        </div>
@endsection
@section('scripts')
@endsection
