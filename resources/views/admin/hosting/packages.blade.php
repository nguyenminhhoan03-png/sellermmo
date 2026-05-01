@php
    use App\Helpers\Helper;
    use App\Models\CategoryHosting;
    use App\Models\WhmInfo;
@endphp
@extends('admin.layouts.master')
@section('title', 'DANH SÁCH CÁC GÓI HOSTING')
@section('css')
    <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

    <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
    <div class="mb-3 text-end">
        <button data-bs-toggle="modal" data-bs-target="#modal-create" class="btn btn-outline-primary me-2"><i
                class="fas fa-plus"></i> {{ __('Thêm Gói Hosting') }}</button>
    </div>

    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">DANH SÁCH CÁC GÓI HOSTING</div>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar" style="padding: 10px">
                <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
                    <thead>
                        <tr>
                            <th class="text-center">Danh Mục Hosting</th>
                            <th class="text-center">Tên Gói Hosting</th>
                            <th class="text-center">Dung Lượng</th>
                            <th class="text-center">Bằng Thông</th>
                            <th class="text-center">SubDomain</th>
                            <th class="text-center">Domain Parket</th>
                            <th class="text-center">Domain Addon</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hosting_packages_view as $hosting_packages_views)
                            @php
                                $category_hostingo = CategoryHosting::find($hosting_packages_views->category);
                                $whm = WhmInfo::where('category', $hosting_packages_views->category)->first();
                            @endphp
                            <tr>
                                <td class="text-center">{{ $category_hostingo->name ?? 'Không Rõ' }}</td>
                                <td class="text-center">{{ $whm->whm_user ?? 'not data' }}_{{ $hosting_packages_views->package_name }}</td>
                                <td class="text-center">{{ FormatDungLuong($hosting_packages_views->disk_quota) }}</td>
                                <td class="text-center">{{ FormatBandwidth($hosting_packages_views->bandwidth_limit) }}</td>
                                <td class="text-center">{{ FormatDuLieu($hosting_packages_views->max_subdomains) }}</td>
                                <td class="text-center">{{ FormatDuLieu($hosting_packages_views->max_parked_domains) }}</td>
                                <td class="text-center">{{ FormatDuLieu($hosting_packages_views->max_addon_domains) }}</td>
                                <td class="text-center">{!! Helper::status_server_cron_admin($hosting_packages_views->status) !!}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#modal-update-{{ $hosting_packages_views->id }}"
                                        class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                        data-bs-original-title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="javascript:deleteRow({{ $hosting_packages_views->id }})"
                                        class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @foreach ($hosting_packages_view as $value)
        <div class="modal fade" id="modal-update-{{ $value->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật Gói hosting #{{ $value->id }}</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
                           API Cpanel Không hỗ trợ đổi tên gói nhé vui lòng ko đổi tên gói <br>
                           Bạn có thể đổi tên bằng cách xóa gói này và tạo gói mới nhé
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
                        </div>
                        <form action="{{ route('admin.hosting.packages.update', ['id' => $value->id]) }}" method="POST" class="axios-form"
                        data-reload="1" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Danh Mục:</label>
                                    <select name="category" id="category" class="form-control"
                                        style="width: 100%;">
                                        @foreach ($category_hosting as $category_hostings)
                                            <option value="{{ $category_hostings->id }}" @if ($category_hostings->id == $value->category) selected @endif >{{ $category_hostings->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Package Name:</label>
                                    <input name="package_name" id="package_name" type="text" class="form-control"
                                        placeholder="Package Name..." required="" value="{{ $value->package_name }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Giá Bán:</label>
                                    <input name="price" id="price" type="number" class="form-control"
                                        placeholder="Giá Bán..." required="" value="{{ $value->price }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Disk Quota (MB):</label>
                                    <input name="disk_quota" id="disk_quota" type="number" class="form-control"
                                        placeholder="Disk Quota..." required="" value="{{ $value->disk_quota }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Bandwidth Limit (MB):</label>
                                    <input name="bandwidth_limit" id="bandwidth_limit" type="text"
                                        class="form-control" placeholder="Bandwidth Limit..." required="" value="{{ $value->bandwidth_limit }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Max Subdomains:</label>
                                    <input name="max_subdomains" id="max_subdomains" type="text" class="form-control"
                                        placeholder="Max Subdomains..." required="" value="{{ $value->max_subdomains }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Max Parked Domains:</label>
                                    <input name="max_parked_domains" id="max_parked_domains" type="text"
                                        class="form-control" placeholder="Max Parked Domains..." value="{{ $value->max_parked_domains }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Max Addon Domains:</label>
                                    <input name="max_addon_domains" id="max_addon_domains" type="text"
                                        class="form-control" placeholder="Max Addon Domains..." required="" value="{{ $value->max_addon_domains }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Language:</label>
                                    <select name="language" id="language" class="form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="vi" selected="selected">Tiếng Việt</option>
                                        <option value="ar">Tiếng A-rập (العربية)</option>
                                        <option value="bg">Tiếng Bun-ga-ri (български)</option>
                                        <option value="cs">Tiếng Séc (čeština)</option>
                                        <option value="da">Tiếng Đan Mạch (dansk)</option>
                                        <option value="de">Tiếng Đức (Deutsch)</option>
                                        <option value="el">Tiếng Hy Lạp (Ελληνικά)</option>
                                        <option value="en">Tiếng Anh (English)</option>
                                        <option value="es">Tiếng Tây Ban Nha (español)</option>
                                        <option value="es_419">Tiếng Tây Ban Nha (Mỹ La tinh) (español
                                            latinoamericano)
                                        </option>
                                        <option value="es_es">Tiếng Tây Ban Nha (I-bê-ri) (español de España)
                                        </option>
                                        <option value="fi">Tiếng Phần Lan (suomi)</option>
                                        <option value="fil">Tiếng Philipin (Filipino)</option>
                                        <option value="fr">Tiếng Pháp (français)</option>
                                        <option value="he">Tiếng Hê-brơ (עברית)</option>
                                        <option value="hu">Tiếng Hung-ga-ri (magyar)</option>
                                        <option value="i_cpanel_snowmen">☃ cPanel Snowmen ☃ - i_cpanel_snowmen
                                        </option>
                                        <option value="i_en">i_en</option>
                                        <option value="id">Tiếng In-đô-nê-xia (Bahasa Indonesia)</option>
                                        <option value="it">Tiếng Ý (italiano)</option>
                                        <option value="ja">Tiếng Nhật (日本語)</option>
                                        <option value="ko">Tiếng Hàn Quốc (한국어)</option>
                                        <option value="ms">Tiếng Ma-lay-xi-a (Bahasa Melayu)</option>
                                        <option value="nb">Tiếng Na Uy (Bokmål) (norsk bokmål)</option>
                                        <option value="nl">Tiếng Hà Lan (Nederlands)</option>
                                        <option value="no">Tiếng Na Uy (Norwegian)</option>
                                        <option value="pl">Tiếng Ba Lan (polski)</option>
                                        <option value="pt">Tiếng Bồ Đào Nha (português)</option>
                                        <option value="pt_br">Tiếng Bồ Đào Nha (Braxin) (português do Brasil)
                                        </option>
                                        <option value="ro">Tiếng Ru-ma-ni (română)</option>
                                        <option value="ru">Tiếng Nga (русский)</option>
                                        <option value="sl">Tiếng Xlô-ven (slovenščina)</option>
                                        <option value="sv">Tiếng Thụy Điển (svenska)</option>
                                        <option value="th">Tiếng Thái (ไทย)</option>
                                        <option value="tr">Tiếng Thổ Nhĩ Kỳ (Türkçe)</option>
                                        <option value="uk">Tiếng U-crai-na (українська)</option>
                                        <option value="zh">Tiếng Trung Quốc (中文)</option>
                                        <option value="zh_cn">Tiếng Trung Quốc (Trung Quốc) (中文（中国）)</option>
                                        <option value="zh_tw">Tiếng Trung Quốc (Đài Loan) (中文（台湾）)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>cPanel Module:</label>
                                    <select name="cpanel_module" id="cpanel_module" class="form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="jupiter" selected="">Jupiter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="3">{{ base64_decode($value->description) }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" @if ($value->id == 1) selected @endif>Hoạt động</option>
                                <option value="0" @if ($value->id == 0) selected @endif>Không hoạt động</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary w-100" type="submit">Thêm mới</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm gói hosting</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
                        Bạn có thể nhập (unlimited) để có thể cho mục mà mình muốn là không giới hạn <br>
                        Lưu Ý : Ổ cứng host và Băng thông không thể nhập (unlimited) <br>
                        Băng thông có thể nhập : 1048576 ; hoặc cũng có thể nhập (unlimited) vì hệ thống đã được cấu hình rồi
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
                    </div>
                    <form action="{{ route('admin.hosting.packages.store') }}" method="POST" class="axios-form"
                        data-reload="1" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Danh Mục:</label>
                                    <select name="category" id="category" class="form-control"
                                        style="width: 100%;">
                                        @foreach ($category_hosting as $category_hostings)
                                            <option value="{{ $category_hostings->id }}">{{ $category_hostings->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Package Name:</label>
                                    <input name="package_name" id="package_name" type="text" class="form-control"
                                        placeholder="Package Name..." required="">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Giá Bán:</label>
                                    <input name="price" id="price" type="number" class="form-control"
                                        placeholder="Giá Bán..." required="">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Disk Quota (MB):</label>
                                    <input name="disk_quota" id="disk_quota" type="number" class="form-control"
                                        placeholder="Disk Quota..." required="">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Bandwidth Limit (MB):</label>
                                    <input name="bandwidth_limit" id="bandwidth_limit" type="text"
                                        class="form-control" placeholder="Bandwidth Limit..." required="">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Max Subdomains:</label>
                                    <input name="max_subdomains" id="max_subdomains" type="text" class="form-control"
                                        placeholder="Max Subdomains..." required="">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Max Parked Domains:</label>
                                    <input name="max_parked_domains" id="max_parked_domains" type="text"
                                        class="form-control" placeholder="Max Parked Domains...">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Max Addon Domains:</label>
                                    <input name="max_addon_domains" id="max_addon_domains" type="text"
                                        class="form-control" placeholder="Max Addon Domains..." required="">
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Language:</label>
                                    <select name="language" id="language" class="form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="vi" selected="selected">Tiếng Việt</option>
                                        <option value="ar">Tiếng A-rập (العربية)</option>
                                        <option value="bg">Tiếng Bun-ga-ri (български)</option>
                                        <option value="cs">Tiếng Séc (čeština)</option>
                                        <option value="da">Tiếng Đan Mạch (dansk)</option>
                                        <option value="de">Tiếng Đức (Deutsch)</option>
                                        <option value="el">Tiếng Hy Lạp (Ελληνικά)</option>
                                        <option value="en">Tiếng Anh (English)</option>
                                        <option value="es">Tiếng Tây Ban Nha (español)</option>
                                        <option value="es_419">Tiếng Tây Ban Nha (Mỹ La tinh) (español
                                            latinoamericano)
                                        </option>
                                        <option value="es_es">Tiếng Tây Ban Nha (I-bê-ri) (español de España)
                                        </option>
                                        <option value="fi">Tiếng Phần Lan (suomi)</option>
                                        <option value="fil">Tiếng Philipin (Filipino)</option>
                                        <option value="fr">Tiếng Pháp (français)</option>
                                        <option value="he">Tiếng Hê-brơ (עברית)</option>
                                        <option value="hu">Tiếng Hung-ga-ri (magyar)</option>
                                        <option value="i_cpanel_snowmen">☃ cPanel Snowmen ☃ - i_cpanel_snowmen
                                        </option>
                                        <option value="i_en">i_en</option>
                                        <option value="id">Tiếng In-đô-nê-xia (Bahasa Indonesia)</option>
                                        <option value="it">Tiếng Ý (italiano)</option>
                                        <option value="ja">Tiếng Nhật (日本語)</option>
                                        <option value="ko">Tiếng Hàn Quốc (한국어)</option>
                                        <option value="ms">Tiếng Ma-lay-xi-a (Bahasa Melayu)</option>
                                        <option value="nb">Tiếng Na Uy (Bokmål) (norsk bokmål)</option>
                                        <option value="nl">Tiếng Hà Lan (Nederlands)</option>
                                        <option value="no">Tiếng Na Uy (Norwegian)</option>
                                        <option value="pl">Tiếng Ba Lan (polski)</option>
                                        <option value="pt">Tiếng Bồ Đào Nha (português)</option>
                                        <option value="pt_br">Tiếng Bồ Đào Nha (Braxin) (português do Brasil)
                                        </option>
                                        <option value="ro">Tiếng Ru-ma-ni (română)</option>
                                        <option value="ru">Tiếng Nga (русский)</option>
                                        <option value="sl">Tiếng Xlô-ven (slovenščina)</option>
                                        <option value="sv">Tiếng Thụy Điển (svenska)</option>
                                        <option value="th">Tiếng Thái (ไทย)</option>
                                        <option value="tr">Tiếng Thổ Nhĩ Kỳ (Türkçe)</option>
                                        <option value="uk">Tiếng U-crai-na (українська)</option>
                                        <option value="zh">Tiếng Trung Quốc (中文)</option>
                                        <option value="zh_cn">Tiếng Trung Quốc (Trung Quốc) (中文（中国）)</option>
                                        <option value="zh_tw">Tiếng Trung Quốc (Đài Loan) (中文（台湾）)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>cPanel Module:</label>
                                    <select name="cpanel_module" id="cpanel_module" class="form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="jupiter" selected="">Jupiter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" selected>Hoạt động</option>
                                <option value="0">Không hoạt động</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary w-100" type="submit">Thêm mới</button>
                        </div>
                    </form>
                </div>
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
                } = await axios.post('{{ route('admin.hosting.packages.delete') }}', {
                    id
                })

                Swal.fire('Thành công', result.message, 'success').then(() => {
                    window.location.reload();
                })
            } catch (error) {
                Swal.fire('Thất bại', $catchMessage(error), 'error')
            }
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
