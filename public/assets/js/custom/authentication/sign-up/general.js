"use strict";
var KTSignupGeneral = function () {
    var e, t, r, a, s = function () {
        return a.getScore() > 50
    };
    return {
        init: function () {
            e = document.querySelector("#kt_sign_up_form");
            t = document.querySelector("#kt_sign_up_submit");
            a = KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]'));

            !function (e) {
                try {
                    return new URL(e), !0;
                } catch (e) {
                    return !1;
                }
            }(t.closest("form").getAttribute("action")) ? (r = FormValidation.formValidation(e, {
                fields: {
                    "first-name": {
                        validators: {
                            notEmpty: {
                                message: "First Name is required"
                            }
                        }
                    },
                    "last-name": {
                        validators: {
                            notEmpty: {
                                message: "Last Name is required"
                            }
                        }
                    },
                    username: {
                        validators: {
                            notEmpty: {
                                message: "Tên tài khoản không được để trống"
                            }
                        }
                    },
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "The value is not a valid email address"
                            },
                            notEmpty: {
                                message: "Email Không được để trống"
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "Mật khẩu là bắt buộc"
                            },
                            callback: {
                                message: "Please enter valid password",
                                callback: function (e) {
                                    if (e.value.length > 0) return s();
                                }
                            }
                        }
                    },
                    "confirm-password": {
                        validators: {
                            notEmpty: {
                                message: "The password confirmation is required"
                            },
                            identical: {
                                compare: function () {
                                    return e.querySelector('[name="password"]').value;
                                },
                                message: "The password and its confirm are not the same"
                            }
                        }
                    },
                    toc: {
                        validators: {
                            notEmpty: {
                                message: "Bạn phải chấp nhận các điều khoản và điều kiện"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: !1
                        }
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", function (s) {
                s.preventDefault();
                r.revalidateField("password");
                r.validate().then(function (r) {
                    if (r === "Valid") {
                        t.setAttribute("data-kt-indicator", "on");
                        t.disabled = true;

                        setTimeout(function () {
                            t.removeAttribute("data-kt-indicator");
                            t.disabled = false;
                            Swal.fire({
                                text: "You have successfully reset your password!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (t) {
                                if (t.isConfirmed) {
                                    e.reset();
                                    a.reset();
                                    var r = e.getAttribute("data-kt-redirect-url");
                                    if (r) location.href = r;
                                }
                            });
                        }, 1500);
                    } else {
                        Swal.fire({
                            text: "Rất tiếc, có vẻ như đã phát hiện một số lỗi, vui lòng thử lại.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }), e.querySelector('input[name="password"]').addEventListener("input", function () {
                this.value.length > 0 && r.updateFieldStatus("password", "NotValidated");
            })) : (r = FormValidation.formValidation(e, {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: "Name is required"
                            }
                        }
                    },
                    username: {
                        validators: {
                            notEmpty: {
                                message: "Tên tài khoản không được để trống"
                            }
                        }
                    },
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "The value is not a valid email address"
                            },
                            notEmpty: {
                                message: "Email address is required"
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "The password is required"
                            },
                            callback: {
                                message: "Please enter valid password",
                                callback: function (e) {
                                    if (e.value.length > 0) return s();
                                }
                            }
                        }
                    },
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: "The password confirmation is required"
                            },
                            identical: {
                                compare: function () {
                                    return e.querySelector('[name="password"]').value;
                                },
                                message: "The password and its confirm are not the same"
                            }
                        }
                    },
                    toc: {
                        validators: {
                            notEmpty: {
                                message: "Bạn phải chấp nhận các điều khoản và điều kiện"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: !1
                        }
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", function (a) {
                a.preventDefault();
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
            }), e.querySelector('input[name="password"]').addEventListener("input", function () {
                this.value.length > 0 && r.updateFieldStatus("password", "NotValidated");
            }));
            function handleFormSubmit() {
                const formData = new FormData(e);
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
                        Swal.fire({
                            title: 'Error',
                            text: error.response?.data?.message || 'Có lỗi xảy ra. Vui lòng thử lại.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    });
            }
            
        }
    }
}();

function $formDataToPayload(formData) {
    const payload = {};
    formData.forEach((value, key) => {
        payload[key] = value;
    });
    return payload;
}
KTUtil.onDOMContentLoaded(function () {
    KTSignupGeneral.init();
});
