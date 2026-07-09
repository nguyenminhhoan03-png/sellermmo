@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')
<div class="card custom-card">
    <div class="card-header justify-content-between">
        <div class="card-title">{{ $pageTitle }}</div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr class="bg-light">
                        <th>#ID</th>
                        <th>Tài khoản</th>
                        <th>Thông tin Shop & Liên hệ</th>
                        <th>Câu hỏi phụ</th>
                        <th>Danh mục bán</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                    <tr>
                        <td>{{ $app->id }}</td>
                        <td>
                            @if($app->user)
                                <span class="badge bg-primary">{{ $app->user->username }}</span><br>
                                <small class="text-muted">{{ $app->user->email }}</small>
                            @else
                                <span class="text-danger">Không xác định</span>
                            @endif
                        </td>
                        <td>
                            <div class="mb-1"><strong>Tên Shop:</strong> <span class="text-success">{{ $app->shop_name ?? 'Chưa cập nhật' }}</span></div>
                            <div class="mb-1"><strong>Liên hệ:</strong> <span class="text-info">{{ $app->contact_phone }}</span></div>
                            <div class="mb-1">
                                @if($app->contact_facebook)
                                    <a href="{{ $app->contact_facebook }}" target="_blank" class="btn btn-xs btn-outline-primary py-0 px-1 me-1"><i class="fab fa-facebook"></i> Facebook</a>
                                @endif
                                @if($app->contact_telegram)
                                    <span class="badge bg-info"><i class="fab fa-telegram"></i> {{ $app->contact_telegram }}</span>
                                @endif
                            </div>
                            <div class="text-wrap" style="max-width: 250px;"><small class="text-muted">{{ $app->description }}</small></div>
                        </td>
                        <td>
                            <ul class="list-unstyled mb-0 fs-7">
                                <li>- Đội nhóm: <strong>{{ $app->team == 'yes' ? 'Có (' . $app->team_members . ' TV)' : 'Không' }}</strong></li>
                                <li>- Trùng Acc Sàn: <strong>{{ $app->other_account == 'yes' ? 'Có' : 'Không' }}</strong></li>
                                <li>- Bán nơi khác: <strong>{{ $app->market_account == 'yes' ? 'Có' : 'Không' }}</strong></li>
                            </ul>
                        </td>
                        <td>
                            @if(is_array($app->work_category))
                                @foreach($app->work_category as $catKey)
                                    @php $cat = App\Models\Product::CATEGORIES[$catKey] ?? null; @endphp
                                    <span class="badge bg-secondary mb-1">{{ $cat ? $cat['label'] : $catKey }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if($app->status == '0')
                                <span class="badge bg-warning text-dark">Chờ Duyệt</span>
                            @elseif($app->status == '1')
                                <span class="badge bg-success">Đã Duyệt</span>
                            @else
                                <span class="badge bg-danger">Từ Chối</span>
                            @endif
                        </td>
                        <td><small>{{ $app->created_at }}</small></td>
                        <td>
                            @if($app->status == '0')
                            <form action="{{ route('admin.sellers.approve') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $app->id }}">
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Bạn chắc chắn muốn duyệt cho người dùng này thành Người Bán?')">Duyệt</button>
                            </form>
                            <form action="{{ route('admin.sellers.reject') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $app->id }}">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn từ chối?')">Từ Chối</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
