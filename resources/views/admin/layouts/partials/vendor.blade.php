<!-- Popper JS -->
<script src="/_assets/libs/@popperjs/core/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="/_assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Defaultmenu JS -->
<script src="/_assets/js/defaultmenu.min.js"></script>

<!-- Node Waves JS-->
<script src="/_assets/libs/node-waves/waves.min.js"></script>

<!-- Sticky JS -->
<script src="/_assets/js/sticky.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="/_assets/js/select2.js"></script>
<script src="/_assets/libs/flatpickr/flatpickr.min.js"></script>
<!-- Simplebar JS -->
<script src="/_assets/libs/simplebar/simplebar.min.js"></script>
<script src="/_assets/js/simplebar.js"></script>

<!-- Color Picker JS -->
<script src="/_assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>

<!-- Custom JS -->
<script src="/_assets/js/custom.js"></script>

<!-- Custom-Switcher JS -->
<script src="/_assets/js/custom-switcher.min.js"></script>

<!-- Internal Datatables JS -->
<script src="/_assets/js/datatables.js"></script>
<!-- Datatables Cdn -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript"
    src="https://cdn.jsdelivr.net/gh/lelinh014756/fui-toast-js@master/assets/js/toast@1.0.1/fuiToast.min.js"></script>
<!-- extra js-->
<script src="https://unpkg.com/clipboard@2/dist/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.27/sweetalert2.min.js"></script>

@vite('resources/js/functions.js')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    const notyf = new Notyf();
    var pusher = new Pusher('{{ config('app.app_pusher') }}', {
        cluster: 'ap1',
    });
    var channel = pusher.subscribe('notification');
    channel.bind('admin',
        function(data) {
            notyf.success(data.message);
        });
</script>
<script>
    $(document).ready(function() {
        window.pageOverlay = $("#page-overlay");

        // basic datatable
        $('.datatable').DataTable({
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            },
            response: false,
            order: [
                [0, 'desc']
            ],
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100, 500, 1000, 5000, -1],
                [10, 25, 50, 100, 500, 1000, 5000, 'All']
            ]
        });
        $('.axios-dvr').submit(async function(e) {
            e.preventDefault();

            const confirm = await Swal.fire({
                title: '{{ __('Bạn chắc chứ?') }}',
                text: "{{ __('Bạn đã ấn kiểm tra kết nối chưa?') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('Rồi') }}',
                cancelButtonText: '{{ __('Hủy') }}'
            });

            if (confirm.isConfirmed) {
                pageOverlay.show();

                let form = $(this);
                let url = form.attr('action');
                let method = form.attr('method');
                let data = form.serialize();

                try {
                    const response = await axios({
                        method: method,
                        url: url,
                        data: data
                    });

                    if (response.data.status == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message,
                        }).then(() => {
                            if (reload) {
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.data.message,
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: $catchMessage(error),
                    });
                } finally {
                    pageOverlay.hide();
                }
            }
        });
        // muabanwebsite
        $('.default-dvr').submit(async function(e) {
            e.preventDefault();

            const confirm = await Swal.fire({
                title: '{{ __('Bạn chắc chứ?') }}',
                text: "{{ __('Bạn đã ấn kiểm tra kết nối chưa?') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('Rồi') }}',
                cancelButtonText: '{{ __('Hủy') }}'
            });

            if (confirm.isConfirmed) {
                pageOverlay.show();
                $(this).off('submit').submit();
            }
        });
        // .axios-form
        $('.default-form').submit(async function(e) {
            // show page overlay
            pageOverlay.show()
            // submit form
            $(this).submit();
        })

        $('.axios-form').submit(async function(e) {
            e.preventDefault();

            let reload = $(this).data('reload'),
                button = $(this).find('button[type="submit"]'),
                confirm = $(this).data('confirm'),
                callback = $(this).data('callback');

            if (confirm) {
                const confirmResult = await Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be undo this action!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ok',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                })

                if (!confirmResult.isConfirmed) {
                    return;
                }
            }

            let form = $(this);
            let url = form.attr('action');
            let method = form.attr('method');
            let data = form.serialize();

            pageOverlay.show()

            axios({
                method: method,
                url: url,
                data: data
            }).then(function(response) {
                if (response.data.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message,
                    }).then(() => {
                        if (reload) {
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    });


                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.data.message,
                    });
                }
            }).catch(function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: $catchMessage(error),
                });
            }).finally(function() {
                pageOverlay.hide()
            });
        });

    })
</script>

@yield('scripts')
@stack('scripts')
