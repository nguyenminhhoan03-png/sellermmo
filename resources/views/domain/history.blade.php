@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@php use App\Models\Domain; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <!--begin::Container-->
    <div
        id="kt_toolbar_container"
        class="container-xxl d-flex flex-stack flex-wrap"
    >
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Lịch sử mua tên miền
            </h1>
            <!--end::Title-->

            <!--begin::Breadcrumb-->
            <ul
                class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1"
            >
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a
                        href="/"
                        class="text-gray-600 text-hover-primary"
                    >
                        Home
                    </a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">{{ $user->name }}</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Lịch sử mua tên miền</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-2">
            <!--begin::Wrapper-->
            <div class="me-4">
                <!--begin::Menu-->
                <a
                    href="#"
                    class="btn btn-sm btn-flex btn-light btn-active-primary fw-bold"
                    data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end"
                >
                    <i class="ki-duotone ki-filter fs-5 text-gray-500 me-1"
                        ><span class="path1"></span><span class="path2"></span
                    ></i>
                    Filter
                </a>

                <!--begin::Menu 1-->
                <div
                    class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                    data-kt-menu="true"
                    id="kt_menu_6739b0e589661"
                >
                    <!--begin::Header-->
                    <div class="px-7 py-5">
                        <div class="fs-5 text-gray-900 fw-bold">
                            Filter Options
                        </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Menu separator-->
                    <div class="separator border-gray-200"></div>
                    <!--end::Menu separator-->

                    <!--begin::Form-->
                    <div class="px-7 py-5">
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold"
                                >Status:</label
                            >
                            <!--end::Label-->

                            <!--begin::Input-->
                            <div>
                                <select
                                    class="form-select form-select-solid"
                                    multiple
                                    data-kt-select2="true"
                                    data-close-on-select="false"
                                    data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_6739b0e589661"
                                    data-allow-clear="true"
                                >
                                    <option></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Pending</option>
                                    <option value="2">In Process</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold"
                                >Member Type:</label
                            >
                            <!--end::Label-->

                            <!--begin::Options-->
                            <div class="d-flex">
                                <!--begin::Options-->
                                <label
                                    class="form-check form-check-sm form-check-custom form-check-solid me-5"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="1"
                                    />
                                    <span class="form-check-label">
                                        Author
                                    </span>
                                </label>
                                <!--end::Options-->

                                <!--begin::Options-->
                                <label
                                    class="form-check form-check-sm form-check-custom form-check-solid"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="2"
                                        checked="checked"
                                    />
                                    <span class="form-check-label">
                                        Customer
                                    </span>
                                </label>
                                <!--end::Options-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold"
                                >Notifications:</label
                            >
                            <!--end::Label-->

                            <!--begin::Switch-->
                            <div
                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid"
                            >
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    name="notifications"
                                    checked
                                />
                                <label class="form-check-label">
                                    Enabled
                                </label>
                            </div>
                            <!--end::Switch-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button
                                type="reset"
                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true"
                            >
                                Reset
                            </button>

                            <button
                                type="submit"
                                class="btn btn-sm btn-primary"
                                data-kt-menu-dismiss="true"
                            >
                                Apply
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Menu 1-->
                <!--end::Menu-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Button-->
            <a
                href="#"
                class="btn btn-sm btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#kt_modal_create_app"
                id="kt_toolbar_primary_button"
            >
                Create
            </a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->

<!--begin::Container-->
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div
                        class="d-flex align-items-center position-relative my-1"
                    >
                        <i
                            class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                            ><span class="path1"></span
                            ><span class="path2"></span
                        ></i>
                        <input
                            type="text"
                            data-kt-customer-table-filter="search"
                            class="form-control form-control-solid w-250px ps-12"
                            placeholder="Tìm kiếm tên miền"
                        />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div
                        class="d-flex justify-content-end"
                        data-kt-customer-table-toolbar="base"
                    >
                        <!--begin::Filter-->
                        <button
                            type="button"
                            class="btn btn-light-primary me-3"
                            data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end"
                        >
                            <i class="ki-duotone ki-filter fs-2"
                                ><span class="path1"></span
                                ><span class="path2"></span
                            ></i>
                            Filter
                        </button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-4 text-gray-900 fw-bold">
                                    Filter Options
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->

                            <!--begin::Content-->
                            <div class="px-7 py-5">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label
                                        class="form-label fs-5 fw-semibold mb-3"
                                        >Month:</label
                                    >
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <select
                                        class="form-select form-select-solid fw-bold"
                                        data-kt-select2="true"
                                        data-placeholder="Select option"
                                        data-allow-clear="true"
                                        data-kt-customer-table-filter="month"
                                        data-dropdown-parent="#kt-toolbar-filter"
                                    >
                                        <option></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label
                                        class="form-label fs-5 fw-semibold mb-3"
                                        >Đuôi Miền:</label
                                    >
                                    <!--end::Label-->

                                    <!--begin::Options-->
                                    <div
                                        class="d-flex flex-column flex-wrap fw-semibold"
                                        data-kt-customer-table-filter="payment_type"
                                    >
                                        <!--begin::Option-->
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="payment_type"
                                                value="all"
                                                checked="checked"
                                            />
                                            <span
                                                class="form-check-label text-gray-600"
                                            >
                                                All
                                            </span>
                                        </label>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        @foreach($domain as $domains)
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="payment_type"
                                                value="{{ $domains->name }}"
                                            />
                                            <span
                                                class="form-check-label text-gray-600"
                                            >
                                                {{ $domains->name }}
                                            </span>
                                        </label>
                                        <!--end::Option-->
                                    @endforeach
                                    </div>
                                    <!--end::Options-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button
                                        type="reset"
                                        class="btn btn-light btn-active-light-primary me-2"
                                        data-kt-menu-dismiss="true"
                                        data-kt-customer-table-filter="reset"
                                    >
                                        Reset
                                    </button>

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        data-kt-menu-dismiss="true"
                                        data-kt-customer-table-filter="filter"
                                    >
                                        Apply
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div>
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Group actions-->
                   
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table
                    class="table align-middle table-row-dashed fs-6 gy-5"
                    id="kt_customers_table"
                >
                    <thead>
                        <tr
                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"
                        >
                            <th class="min-w-125px">Mã Giao Dịch</th>
                            <th class="min-w-125px">Tên miền</th>
                            <th class="min-w-125px">Giá tiền</th>
                            <th class="min-w-125px">Trạng Thái</th>
                            <th class="min-w-125px">Gia hạn auto</th>
                            <th class="min-w-125px">Ngày Mua</th>
                            <th class="min-w-125px">Ngày Hết Hạn</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($hisdomain as $hisdomains)
<tr>
    <td>{{ $hisdomains->trans_id }}</td>
    <td>{{ $hisdomains->domain_name }}</td>
    @php
    $parts = explode('.', $hisdomains->domain_name);
    $extension = end($parts);
    @endphp
    <td data-filter="{{ $extension }}">{{ number_format($hisdomains->price) }}đ</td>
    <td>{!! Helper::statusdomain($hisdomains->status) !!}</td>
    <td>
        <div class="form-check form-switch form-check-custom form-check-danger form-check-solid">
            <input type="checkbox" class="form-check-input Switch" data-table="status_domain" data-id="{{ $hisdomains->id }}" data-col="status" id="customSwitch{{ $hisdomains->id }}"  @if ($hisdomains->giahan == 1) checked @endif />
        </div>
    </td>
    <td>{{ $hisdomains->created_at }}</td>
    <td>{{ $hisdomains->expired_date }}</td>
    <td class="text-end">
        <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <i class="ki-duotone ki-down fs-5 ms-1"></i>
        </a>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#modal-update-{{ $hisdomains->id }}">Cài Đặt NS</a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#modal-giahan-{{ $hisdomains->id }}">Gia hạn</a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#modal-user-{{ $hisdomains->id }}">Tặng miền</a>
            </div>
            <div class="menu-item px-3">
                <a href="/domain/view/{{ $hisdomains->id }}" class="menu-link px-3">Xem chi tiết</a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-customer-table-filter="delete_row">Delete</a>
            </div>
        </div>
    </td>
</tr>
<div class="modal fade " tabindex="-1" id="modal-update-{{ $hisdomains->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cập nhật NS {{ $hisdomains->domain_name }}</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    Khuyến khích các bạn nên sử dụng ns của cloudflare.com để dễ quản lý hơn nhé
                </div>
                @php
                $lines = explode(",", $hisdomains->ns); 
                @endphp         
                @foreach ($lines as $line)
                <div class="input-group input-group-sm mb-5">
                    <span class="input-group-text">NS{{ $loop->iteration }}</span>
                    <input type="text" class="form-control ns-input" name="ns{{ $loop->iteration }}" value="{{ $line }}">
                    @if ($loop->iteration > 1)
                    <button type="button" class="btn btn-danger btn-sm btn-remove-ns ms-2" style="display: inline-block;">Xóa</button>
                    @else
                    <button type="button" class="btn btn-success btn-sm btn-add-ns ms-2" style="display: inline-block;">Thêm NS</button>
                    @endif
                </div>
                @endforeach
                
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary btn-save" data-id="{{ $hisdomains->id }}">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " tabindex="-1" id="modal-user-{{ $hisdomains->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Gửi tặng tên miền</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    Nhập tài khoản của người bạn muốn chuyển quyền quản trị (phí chuyển là 1,000đ vì lí do tránh spam)
                </div>
                
                <div class="form-floating mb-7">
                    <input type="email" class="form-control" id="user"  placeholder="muabanwebsite"/>
                    <label for="floatingInput">Tên tài khoản</label>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary btn-save-user" data-id-user="{{ $hisdomains->id }}">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " tabindex="-1" id="modal-giahan-{{ $hisdomains->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Gia hạn tên miền</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    Vui lòng ko spam chúng tôi phát hiện sẽ khóa tài khoản
                </div>               
                    <select class="form-select" id="giahan" data-control="select2">
                        <option value="1">1 Năm</option>
                        <option value="2">2 Năm</option>
                        <option value="3">3 Năm</option>
                        <option value="4">4 Năm</option>
                        <option value="5">5 Năm</option>
                    </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary btn-save-giahan" data-id-giahan="{{ $hisdomains->id }}">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>
@endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-save-giahan').forEach(button => {
        button.addEventListener('click', function () {
            $(".loader-wrapper").removeClass("d-none");
            const domainId = this.getAttribute('data-id-giahan');
            const giahan = $('#giahan').select2('val');
          if (!giahan) {
            showMessage('Vui lòng chọn thời gian gia hạn', 'error');
            return;
          }
            fetch('/domain/giahan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: domainId,
                    giahan: giahan,
                })
            })
            .then(response => response.json())
            .then(data => {
                $(".loader-wrapper").addClass("d-none");
                if (data.status === 200) {
                    showMessage(data.message, 'success');
                    setTimeout(() => {
                        location.reload(); 
                    }, 600);
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                showMessage(error, 'error');
            });
        });
    });
});
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-save-user').forEach(button => {
        button.addEventListener('click', function () {
            $(".loader-wrapper").removeClass("d-none");
            const domainId = this.getAttribute('data-id-user');
            const user = document.getElementById('user').value;
          if (!user) {
            showMessage('Vui lòng nhập tài khoản', 'error');
            return;
          }
            fetch('/domain/user-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: domainId,
                    user: user,
                })
            })
            .then(response => response.json())
            .then(data => {
                $(".loader-wrapper").addClass("d-none");
                if (data.status === 200) {
                    showMessage(data.message, 'success');
                    setTimeout(() => {
                        location.reload(); 
                    }, 600);
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                showMessage(error, 'error');
            });
        });
    });
});
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.modal').forEach(modal => {
        const modalBody = modal.querySelector('.modal-body');

        modalBody.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-add-ns')) {
                const nsCount = modalBody.querySelectorAll('.ns-input').length + 1;
                const newDiv = document.createElement('div');
                newDiv.className = 'input-group input-group-sm mb-5';
                newDiv.innerHTML = `
                    <span class="input-group-text">NS${nsCount}</span>
                    <input type="text" class="form-control ns-input" name="ns${nsCount}" value="">
                    <button type="button" class="btn btn-danger btn-sm btn-remove-ns ms-2" style="display: ${nsCount > 2 ? 'inline-block' : 'none'}">Xóa</button>
                `;
                modalBody.appendChild(newDiv);
            }
        });
        modalBody.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-remove-ns')) {
                e.target.closest('.input-group').remove();
                updateNSLabels(modalBody);
            }
        });
    });
    function updateNSLabels(modalBody) {
        modalBody.querySelectorAll('.ns-input').forEach((input, index) => {
            input.closest('.input-group').querySelector('.input-group-text').textContent = `NS${index + 1}`;
            const removeButton = input.closest('.input-group').querySelector('.btn-remove-ns');
            removeButton.style.display = (index >= 1) ? 'inline-block' : 'none';
        });
    }
});
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-save').forEach(button => {
        button.addEventListener('click', function () {
            $(".loader-wrapper").removeClass("d-none");
            const domainId = this.getAttribute('data-id');
            const modal = document.getElementById(`modal-update-${domainId}`);
            const inputs = modal.querySelectorAll('.ns-input');

            let nsData = Array.from(inputs).map(input => input.value.trim()).join(',');

            fetch('/domain/ns-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: domainId,
                    ns: nsData
                })
            })
            .then(response => response.json())
            .then(data => {
                $(".loader-wrapper").addClass("d-none");
                if (data.status === 200) {
                    showMessage(data.message, 'success');
                    setTimeout(() => {
                        location.reload(); 
                    }, 600);
                } else {
                    showMessage(data.message, 'error');
                }
                let bootstrapModal = bootstrap.Modal.getInstance(modal);
                bootstrapModal.hide();
            })
            .catch(error => {
                console.error('Lỗi:', error);
                showMessage(error, 'error');
            });
        });
    });
});
    $(document).ready(function () {
            $(".Switch").on('click', function () {
                var switchElement = $(this);
               var isChecked = $(this).prop('checked'); 
               Swal.fire({
            title: isChecked ? 'Bật gia hạn auto?' : 'Bạn có chắc chắn muốn hủy gia hạn auto?',
            text: "Hành động này sẽ thay đổi trạng thái gia hạn!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng ý",
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/domain/status-update",
                    type: "post",
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        table: switchElement.attr('data-table'),
                        col: switchElement.attr('data-col'),
                        id: switchElement.attr('data-id'),
                        status: isChecked ? 1 : 0,
                    },
                    success: function (result) {
                        if (result.status == '200') {
                            showMessage(result.message, 'success');
                        } else {
                            showMessage(result.message, 'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        var responseMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Vui lòng liên hệ Developer';
                        showMessage(responseMessage, 'error');
                    }
                });
            } else {
                switchElement.prop('checked', !isChecked);
            }
        });
            });
        });
        </script>
@endsection
