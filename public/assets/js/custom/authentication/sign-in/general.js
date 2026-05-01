"use strict";
var KTSigninGeneral = function () {
    var t, e, r;
    return {
        init: function () {
            t = document.querySelector("#kt_sign_in_form");
            e = document.querySelector("#kt_sign_in_submit");

            r = FormValidation.formValidation(t, {
                fields: {
                    username: {
                        validators: {
                            notEmpty: {
                                message: "Tên tài khoản không được để trống"
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "Mật khẩu không được để trống"
                            }
                        }
                    }
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

            e.addEventListener("click", function (i) {
                i.preventDefault();
                r.validate().then(function (status) {
                    if (status !== "Valid") {
                        Swal.fire({
                            text: "Rất tiếc, có vẻ như đã phát hiện một số lỗi, vui lòng thử lại.",
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
                payload.remember = payload.remember === "on" ? true : false;

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
