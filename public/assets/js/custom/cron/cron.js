"use strict";
var KTSigninGeneral = function () {
    var t, e, r;
    return {
        init: function () {
            t = document.querySelector("#formCron");
            e = document.querySelector("#btnThueCron");

            r = FormValidation.formValidation(t, {
                fields: {
                    url: {
                        validators: {
                            notEmpty: {
                                message: "Link Cron không được để trống"
                            },
                            uri: {
                                message: "Link Cron không hợp lệ"
                            }
                        }
                    },
                    sogiay: {
                        validators: {
                            notEmpty: {
                                message: "Vòng lặp không được để trống"
                            },
                            numeric: {
                                message: "Vòng lặp phải là số",
                                thousandsSeparator: '',
                                decimalSeparator: '.'
                            },
                            greaterThan: {
                                message: "Vòng lặp phải lớn hơn 0",
                                min: 1
                            }
                        }
                    },
                    server: {
                        validators: {
                            notEmpty: {
                                message: "Vui lòng chọn máy chủ"
                            }
                        }
                    },
                    thoigiangiahan: {
                        validators: {
                            notEmpty: {
                                message: "Vui lòng chọn thời gian sử dụng"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".align-items-center",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            });

            e.addEventListener("click", function (i) {
                i.preventDefault();
                r.validate().then(function (status) {
                    if (status !== "Valid") {
                        Swal.fire({
                            text: "Vui lòng nhập đẩy đủ thông tin.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    } else {
                        handleFormSubmit();
                    }
                });
            });

            function handleFormSubmit() {
                const formData = new FormData(t);
                const payload = $formDataToPayload(formData);

                const loadingSwal = Swal.fire({
                    title: 'Đang xử lý...',
                    text: 'Vui lòng chờ',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                axios.post(t.action, payload)
                    .then(({ data: result }) => {
                        Swal.fire({
                            title: 'Thành công',
                            text: result.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 10000,
                            allowOutsideClick: false,
                        });
                        setTimeout(() => {
                            window.location.href = result.data.redirect;
                        }, 1000);
                    })
                    .catch(error => {
                        const errors = error?.response?.data?.errors || null;

                        if (errors !== null) {
                            for (const [key, value] of Object.entries(errors)) {
                                document.getElementById(`${key}`).classList.add("is-invalid");
                                document.getElementById(`${key}-error`).innerHTML = value;
                            }
                        }
                        loadingSwal.close();
                        showMessage(error.response?.data?.message || 'Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                    });
            }
        }
    };
}();

function $formDataToPayload(formData) {
    const payload = {};
    formData.forEach((value, key) => {
        payload[key] = value;
    });
    return payload;
}

KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
