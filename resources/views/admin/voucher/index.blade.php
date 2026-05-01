@php
    use App\Helpers\Helper;
    use App\Models\VoucherLog;
@endphp
@extends('admin.layouts.master')
@section('title', 'Danh sách Mã Giảm Giá')
@section('css')
    <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

    <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">DANH SÁCH MÃ GIẢM GIÁ</div>
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable2"
                class="btn btn-sm btn-primary shadow-primary"><i class="ri-add-line fw-semibold align-middle"></i> Tạo mã
                giảm giá mới</button>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar" style="padding: 10px">
                <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
                    <thead>
                        <tr>
                            <th>Mã giảm giá</th>
                            <th>Sản phẩm áp dụng</th>
                            <th class="text-center">Đã sử dụng</th>
                            <th>Giảm</th>
                            <th>Trạng Thái</th>
                            <th>Thờ gian bắt đầu</th>
                            <th>Thời gian kết thúc</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voucher as $vouchers)
                            @php
                                $count = VoucherLog::where('code', $vouchers->code)->count();
                            @endphp
                            <tr>
                                <td><b>{{ $vouchers->code }}</b><br>
                                    (<span style="color:green">Còn {{ $vouchers->qty }} lượt sử dụng</span>)
                                </td>
                                <td class="text-center">
                                    {!! Helper::type_tranfer_admin($vouchers->type) !!}
                                </td>
                                <td class="text-center"><span style="font-size: 15px;"
                                        class="badge bg-danger">{{ $count }}</span>
                                </td>
                                <td><span style="font-size: 15px;" class="badge bg-primary">{{ $vouchers->value }}%</span>
                                </td>
                                <td>{!! Helper::status_voucher_admin($vouchers->expire_date) !!}</td>
                                <td>{{ $vouchers->start_date }}</td>
                                <td>{{ $vouchers->expire_date }}</td>
                                <td class="text-center">
                                    <buton type="button" onclick="modalViewCoupon(`{{ $vouchers->id }}`)"
                                        class="btn btn-sm btn-info" data-bs-toggle="tooltip" aria-label="Nhật ký sử dụng"
                                        data-bs-original-title="Nhật ký sử dụng">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    </buton>
                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#modal-update-{{ $vouchers->id }}" class="btn btn-sm btn-primary"
                                        data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a type="button" onclick="deleteRow({{ $vouchers->id }})" class="btn btn-sm btn-danger"
                                        data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    @foreach ($voucher as $value)
        <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật đơn hàng #{{ $value->code }}</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.voucher.update', ['id' => $value->id]) }}" method="POST"
                            enctype="multipart/form-data" class="default-form">
                            @csrf
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label" for="example-hf-email">Mã giảm giá
                                    (<span class="text-danger">*</span>)
                                </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $value->code }}"
                                            name="code" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label" for="example-hf-email">Số lượng mã giảm giá
                                    (<span class="text-danger">*</span>)</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <button class="btn btn-primary shadow-primary" type="button"
                                            id="button-minus-{{ $value->id }}">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <input type="number" class="form-control text-center" id="qty-{{ $value->id }}"
                                            value="{{ $value->qty }}" name="qty" required="">
                                        <button class="btn btn-primary shadow-primary" type="button"
                                            id="button-plus-{{ $value->id }}">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                    <script>
                                        document.getElementById('button-plus-{{ $value->id }}').addEventListener('click', function() {
                                            incrementValue('{{ $value->id }}');
                                        });
                                        document.getElementById('button-minus-{{ $value->id }}').addEventListener('click', function() {
                                            decrementValue('{{ $value->id }}');
                                        });

                                        function incrementValue(id) {
                                            var inputElement = document.getElementById('qty-' + id);
                                            var currentValue = parseInt(inputElement.value, 10) || 0;
                                            inputElement.value = currentValue + 1;
                                        }

                                        function decrementValue(id) {
                                            var inputElement = document.getElementById('qty-' + id);
                                            var currentValue = parseInt(inputElement.value, 10) || 0;
                                            if (currentValue > 1) {
                                                inputElement.value = currentValue - 1;
                                            }
                                        }
                                    </script>
                                    <small>Nếu bạn chọn 10, sẽ có 10 lượt sử dụng mã giảm giá cho 10 user khác nhau.</small>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label" for="example-hf-email">Chiết khấu giảm (<span
                                        class="text-danger">*</span>)</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="value"
                                            value="{{ $value->value }}" required="">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-percent"></i>
                                        </span>
                                    </div>
                                    <small>Nhập 10 tức giảm 10% cho đơn hàng áp dụng mã giảm giá này.</small>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label" for="example-hf-email">Ngày bắt đầu
                                    (<span class="text-danger">*</span>)</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="date" name="start_date"
                                            class="form-control flatpickr-input" value="{{ $value->start_date }}"
                                            required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label" for="example-hf-email">Ngày kết thúc
                                    (<span class="text-danger">*</span>)</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="date" name="expire_date"
                                            class="form-control flatpickr-input" value="{{ $value->expire_date }}"
                                            required="">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light " data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="AddCoupon"
                            class="btn btn-primary shadow-primary btn-wave waves-effect waves-light"><i
                                class="fa fa-fw fa-plus me-1"></i>
                            Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal fade" id="ModalDialogViewCoupon" tabindex="-1" aria-labelledby="modal-block-popout"
        role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl dialog-scrollable">
            <div class="modal-content">
                <div id="modalViewCoupon"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalScrollable2" tabindex="-1" aria-labelledby="exampleModalScrollable2"
        data-bs-keyboard="false" aria-hidden="true">
        <!-- Scrollable modal -->
        <div class="modal-dialog modal-dialog-centered modal-lg dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel2"><i class="fa-solid fa-plus"></i> Tạo mã giảm giá
                        mới
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.voucher.upload') }}" method="POST" enctype="multipart/form-data"
                    class="default-form">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Mã giảm giá (<span
                                    class="text-danger">*</span>)</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="code" name="code"
                                        placeholder="Nhập mã giảm giá cần tạo" required="">
                                    <button class="btn btn-danger" type="button" onclick="randomCode()"><i
                                            class="fa-solid fa-shuffle"></i> Tạo mã ngẫu
                                        nhiên</button>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Chọn loại sản phẩm(<span
                                    class="text-danger">*</span>)</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="type" name="type" required="">
                                    <option value="">----- Chọn loại sản phẩm -----</option>
                                    <option value="code">Áp dụng cho mã nguồn</option>
                                    <option value="domain">Áp dụng cho bán tên miền</option>
                                    <option value="hosting">Áp dụng cho bán hosting</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Số lượng mã giảm giá (<span
                                    class="text-danger">*</span>)</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <button class="btn btn-primary shadow-primary" type="button"
                                        id="button-minus-amount"><i class="fa-solid fa-minus"></i></button>
                                    <input type="number" class="form-control text-center" placeholder="" value="1"
                                        name="soluong" required="">
                                    <button class="btn btn-primary shadow-primary" type="button"
                                        id="button-plus-amount"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                <script>
                                    document.getElementById('button-plus-amount').addEventListener('click', function() {
                                        incrementValue();
                                    });
                                    document.getElementById('button-minus-amount').addEventListener('click', function() {
                                        decrementValue();
                                    });

                                    function incrementValue() {
                                        var inputElement = document.getElementsByName('soluong')[0];
                                        var currentValue = parseInt(inputElement.value, 10);
                                        inputElement.value = currentValue + 1;
                                    }

                                    function decrementValue() {
                                        var inputElement = document.getElementsByName('soluong')[0];
                                        var currentValue = parseInt(inputElement.value, 10);
                                        if (currentValue > 1) {
                                            inputElement.value = currentValue - 1;
                                        }
                                    }
                                </script>
                                <small>Nếu bạn chọn 10, sẽ có 10 lượt sử dụng mã giảm giá cho 10 user khác nhau.</small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Chiết khấu giảm (<span
                                    class="text-danger">*</span>)</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="value" required="">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-percent"></i>
                                    </span>
                                </div>
                                <small>Nhập 10 tức giảm 10% cho đơn hàng áp dụng mã giảm giá này.</small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Ngày bắt đầu
                                (<span class="text-danger">*</span>)</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="date" name="start_date"
                                        class="form-control flatpickr-input" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Ngày kết thúc
                                (<span class="text-danger">*</span>)</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="date" name="expire_date"
                                        class="form-control flatpickr-input" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light " data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="AddCoupon"
                            class="btn btn-primary shadow-primary btn-wave waves-effect waves-light"><i
                                class="fa fa-fw fa-plus me-1"></i>
                            Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const deleteRow = async (id) => {
            const confirmDelete = await Swal.fire({
                title: '{{ __('Bạn chắc chứ?') }}',
                text: "{{ __('Bạn sẽ không thể khôi phục lại dữ liệu này!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('Xóa') }}',
                cancelButtonText: '{{ __('Hủy') }}'
            });

            if (!confirmDelete.isConfirmed) return;

            $showLoading();

            try {
                const {
                    data: result
                } = await axios.post('{{ route('admin.voucher.delete') }}', {
                    id
                })

                Swal.fire('Thành công', result.message, 'success').then(() => {
                    window.location.reload();
                })
            } catch (error) {
                Swal.fire('Thất bại', $catchMessage(error), 'error')
            }
        }

        function random(length) {
            var result = '';
            var characters = 'QWERTYUPASDFGHJKZXCVBNM123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() *
                    charactersLength));
            }
            return result;
        }

        function randomCode() {
            document.getElementById('code').value = random(8);
        }
        flatpickr("#date", {
            enableTime: true,
            dateFormat: "Y-m-d",
        });

        function modalViewCoupon(id) {
            $("#modalViewCoupon").html('');
            $.ajax({
                url: '{{ route('admin.voucher.show-history') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    id: id
                },
                success: function(response) {
                    $('#modalViewCoupon').html(response);
                    $('#ModalDialogViewCoupon').modal('show')
                },
                error: function(xhr, status, error) {
                    var responseMessage = xhr.responseJSON ?
                        xhr.responseJSON.message :
                        'Không thể thực hiện';
                    showMessage(responseMessage, 'error');
                },
            });
        }
        $(document).ready(function() {
            window.pageOverlay = $("#page-overlay");

            // basic datatable
            $('#datatable').DataTable({
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

        })
    </script>
@endsection
