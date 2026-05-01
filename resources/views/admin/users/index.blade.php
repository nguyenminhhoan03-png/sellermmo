@extends('admin.layouts.master')
@section('title', 'Admin: Users Management')
@section('content')
    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Quản Lý Thành Viên
            </div>
            <a href="javascript:void(0);" data-bs-toggle="card-fullscreen">
                <i class="ri-fullscreen-line"></i>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped text-nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Thao tác</th>
                            <th>Tài khoản</th>
                            <th>Email</th>
                            <th>Số dư</th>
                            <th>Tổng nạp</th>
                            <th>Cấp độ</th>
                            <th>Trạng thái</th>
                            <th>Hoạt động</th>
                            <th>Địa chỉ IP</th>
                            <th>Loại tài khoản</th>
                            <th>Ngày đăng ký</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
          function getLoaitk(loai) {
            if (loai === 'demo') {
                return "<span class='badge bg-danger-gradient'>Demo</span>";
            } else if (loai === 'gg') {
                return "<span class='badge rounded-full bg-primary-gradient'>Google</span>";
            } else {
                return "<span class='badge rounded-full bg-secondary-gradient'>Tài Khoản</span>";
            }
        }
        function getUserBadge(level) {
            if (level === 1) {
                return "<span class='badge bg-danger-gradient'>Admin</span>";
            } else if (level === 2) {
                return "<span class='badge bg-danger'>Cộng Tác Viên</span>";
            } else {
                return "<span class='badge bg-success'>Thành Viên</span>";
            }
        }

        function displayBanned(data) {
            if (data === 1) {
                return '<span class="badge bg-danger">Bị khóa</span>';
            } else {
                return '<span class="badge bg-success">Hoạt động</span>';
            }
        }

        function displayOnline(time) {
            const currentTime = Math.floor(Date.now() / 1000); 
            if (currentTime - time <= 300) {
                return '<span class="badge bg-success">Online</span>';
            } else {
                return '<span class="badge bg-danger">Offline</span>';
            }
        }

        function formatCurrency(amount, locale = 'vi-VN', currency = 'VND') {
            return new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: currency,
            }).format(amount);
        }

        $(document).ready(function() {
            $("#datatable").DataTable({
                order: [0, 'desc'],
                responsive: false,
                lengthMenu: [
                    [10, 50, 100, 200, 500, 1000, 2000, 10000, -1],
                    [10, 50, 100, 200, 500, 1000, 2000, 10000, "All"]
                ],
                language: {
                    searchPlaceholder: 'Tìm kiếm...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/api/Cpanel/users',
                    async: true,
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        Authorization: `Bearer ${access_token}`,
                        'Accept': 'application/json',
                    },
                    data: function(data) {
                        let payload = {}

                        payload.page = data.start / data.length + 1;
                        payload.limit = data.length;
                        payload.search = data.search.value;
                        payload.sort_by = data.columns[data.order[0].column].data;
                        payload.sort_type = data.order[0].dir;
                        return payload;
                    },
                    error: function(xhr) {
                        Swal.fire('Thất bại', $catchMessage(xhr), 'error')
                    },
                    dataFilter: function(data) {
                        let json = JSON.parse(data);
                        if (json.status) {
                            json.recordsTotal = json.data.meta.total
                            json.recordsFiltered = json.data.meta.total
                            json.data = json.data.data
                            return JSON.stringify(json);
                        } else {
                            Swal.fire('Thất bại', json.message, 'error')
                            return JSON.stringify({
                                recordsTotal: 0,
                                recordsFiltered: 0,
                                data: []
                            });
                        }
                    }
                },
                columns: [{
                    data: 'id',
                }, {
                    render: function(data, type, row) {
                        return `
            <a href="/Cpanel/users/edit/${row.id}" class="shadow badge bg-success-gradient text-white me-1"><i class="fas fa-edit"></i> Sửa</a>
            <a href="/Cpanel/users/login-to/${row.username}" class="shadow badge bg-danger-gradient text-white me-1"><i class="fas fa-sign-in"></i></a>
            `
                    }
                }, {
                    data: null,
                    render: function(data) {
                        return `<a class="text-primary" href="/Cpanel/users/edit/${data.id}">${data.username} [ID ${data.id}]</a>`
                    }
                }, {
                    data: 'email',
                    render: function(data) {
                        return `<i class="fa fa-envelope" aria-hidden="true"></i> ${data}`
                    }
                }, {
                    data: 'balance',
                    render: function(data) {
                        return `<b style="color:blue;">${formatCurrency(data)}</b>`
                    }
                }, {
                    data: 'total_deposit',
                    render: function(data) {
                        return `<b style="color:red;">${formatCurrency(data)}</b>`
                    }
                }, {
                    data: 'level',
                    render: function(data) {
                        return `${getUserBadge(data)}`
                    }
                }, {
                    data: 'banned',
                    render: function(data) {
                        return `${displayBanned(data)}`
                    }
                }, {
                    data: 'time_request',
                    render: function(data) {
                        return `${displayOnline(data)}`
                    }
                }, {
                    data: 'ip',
                }, {
                    data: 'loai',
                    render: function(data) {
                        return `${getLoaitk(data)}`
                    }
                }, {
                    data: 'created_at',
                    render: function(data) {
                        return (data)
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    targets: [1]
                }],
            })
        })
    </script>
@endsection
