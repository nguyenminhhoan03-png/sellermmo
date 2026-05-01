"use strict";
var KTCustomersList = function () {
    var t, e, o, n, c = () => {
        n.querySelectorAll('[data-kt-customer-table-filter="delete_row"]').forEach((e => {
            e.addEventListener("click", (function (e) {
                e.preventDefault();
                const o = e.target.closest("tr"),
                    n = o.querySelectorAll("td")[1].innerText;
                Swal.fire({
                    text: "Are you sure you want to delete " + n + "?",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then((function (e) {
                    if (e.value) {
                        Swal.fire({
                            text: "You have deleted " + n + "!",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        }).then((function () {
                            t.row($(o)).remove().draw();
                        }));
                    } else if ("cancel" === e.dismiss) {
                        Swal.fire({
                            text: n + " was not deleted.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        });
                    }
                }));
            }));
        }));
    };

    return {
        init: function () {
            n = document.querySelector("#kt_customers_table");
            if (n) {
                n.querySelectorAll("tbody tr").forEach((t) => {
                    const e = t.querySelectorAll("td");
                    if (e.length > 3 && e[3]) {  // Kiểm tra xem có đủ 4 cột và e[3] không phải undefined
                        const o = moment(e[3].innerHTML, "DD MMM YYYY, LT").format();
                        e[3].setAttribute("data-order", o);
                    }
                });                
                t = $(n).DataTable({
                    info: !1,
                    order: [],
                    columnDefs: [
                        { orderable: !1, targets: 0 },
                        { orderable: !1, targets: 3 }
                    ]
                }).on("draw", (function () {
                    c(); 
                    KTMenu.init();
                }));
                document.querySelector('[data-kt-customer-table-filter="search"]').addEventListener("keyup", (function (e) {
                    t.search(e.target.value).draw();
                }));
                e = $('[data-kt-customer-table-filter="month"]');
                o = document.querySelectorAll('[data-kt-customer-table-filter="payment_type"] [name="payment_type"]');
                document.querySelector('[data-kt-customer-table-filter="filter"]').addEventListener("click", (function () {
                    const n = e.val();
                    let c = "";
                    o.forEach((t => {
                        if (t.checked) c = t.value;
                        if ("all" === c) c = "";
                    }));
                    const r = n + " " + c;
                    t.search(r).draw();
                }));
                document.querySelector('[data-kt-customer-table-filter="reset"]').addEventListener("click", (function () {
                    e.val(null).trigger("change");
                    o[0].checked = !0;
                    t.search("").draw();
                }));

                c();
            }
        }
    };
}();

KTUtil.onDOMContentLoaded((function () {
    KTCustomersList.init();
}));
