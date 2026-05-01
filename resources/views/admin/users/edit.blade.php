@php use App\Helpers\Helper;
     use Illuminate\Support\Carbon;
     use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')

<div class="row gx-5">
    <div class="col-12">
        <div class="mt-4 mt-md-0">
            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-addCredit"
                class="btn btn-sm btn-wave btn-success me-1 mb-3 push">
                <i class="fa fa-fw fa-plus"></i> Cộng số dư
            </button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-removeCredit"
                class="btn btn-sm btn-wave btn-danger me-1 mb-3 push">
                <i class="fa fa-fw fa-minus"></i> Trừ số dư
            </button>
        </div>
    </div>
    <div class="col-12">
        <div class="card custom-card shadow-none mb-4">
            <div class="card-body">
                <form action="{{ route('admin.users.update', ['id' => $row->id]) }}" method="POST" enctype="multipart/form-data" class="default-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Username (<span class="text-danger">*</span>)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{ $row->username }}"
                                        name="username" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Email (<span class="text-danger">*</span>)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" value="{{ $row->email }}"
                                        name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Mật Khẩu (<span class="text-danger">*</span>)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="text" class="form-control" value=""
                                        name="password">
                                </div>
                                <small>Nhập mật khẩu cần thay đổi, hệ thống sẽ tự động mã hóa (bỏ trống nếu không muốn thay đổi)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Họ Tên (<span class="text-danger">*</span>)</label>
                                <div class="input-group">
                                    <input type="name" class="form-control" value="{{ $row->name }}"
                                        name="name" required>
                                </div>
                                <small>Thay đổi tiền hiện thị cho người dùng</small>
                            
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Token (<span class="text-danger">*</span>)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" id="token_input"
                                        value="{{ $row->access_token }}" name="access_token" required>
                                    <button type="button" id="show_token" class="btn btn-danger"
                                        onclick="toggleTokenVisibility()">Show</button>
                                </div>
                                <script>
                                function toggleTokenVisibility() {
                                    var input = document.getElementById('token_input');
                                    var button = document.getElementById('show_token');
                                    if (input.type === 'password') {
                                        input.type = 'text';
                                        button.textContent = 'Hide';
                                    } else {
                                        input.type = 'password';
                                        button.textContent = 'Show';
                                    }
                                }
                                </script>
                                <small>Bảo mật thông tin này vì kẻ xấu có thể thực hiện đăng nhập tài khoản bằng
                                    Token</small>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Giới Thiệu</label>
                                <div class="input-group">
                                    <input type="gioi_thieu" class="form-control" value="{{ $row->gioi_thieu }}"
                                        name="gioi_thieu">
                                </div>
                                <small>Chỉ thấy khi người dùng này là cộng tác viên</small>
                            
                            </div>
                        </div>                    
                        <div class="col-md-3">
                            <div class="mb-4">
                                <label class="form-label">Chức Vụ Role (<span
                                        class="text-danger">*</span>)</label>
                                <select class="form-control select2bs4" name="level">
                                    <option value="0" @if ($row->level == '0') selected @endif>User (Khách
                                        hàng)
                                    </option>
                                                                                <option value="1"
                                                                                @if ($row->level == '1') selected @endif>
                                        Super Admin (Admin Role)
                                    </option>
                                                                                <option value="2"
                                                                                @if ($row->level == '2') selected @endif>
                                        CTV (CTV Role)
                                    </option>
                                                                                                                        </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-4">
                                <div class="mb-4">
                                    <label class="form-label">Banned (<span
                                            class="text-danger">*</span>)</label>
                                    <select class="form-control select2bs4" name="banned">
                                        <option  value="1" @if ($row->banned == '1') selected @endif>
                                            Banned</option>
                                        <option  value="0" @if ($row->banned == '0') selected @endif>Live
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-4">
                                <div class="mb-4">
                                    <label class="form-label">ChatID Tele</label>
                                    <input type="text" class="form-control" name="chat_id" value="{{ $row->chat_id }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-4">
                                <div class="mb-4">
                                    <label class="form-label">Skill</label>
                                    <input type="text" class="form-control" name="skill" value="{{ $row->skill }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-4">
                                <label class="form-label">Ví chính</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-wallet"></i>
                                    </span>
                                    <input type="text" class="form-control"
                                        value="{{ number_format($row->balance) }}đ" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-4">
                                <label class="form-label">Ví chính CTV</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-wallet"></i>
                                    </span>
                                    <input type="text" class="form-control"
                                        value="{{ number_format($row->balance_ctv) }}đ" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-4">
                                <label class="form-label">Tổng tiền nạp</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-money-bill"></i>
                                    </span>
                                    <input type="text" class="form-control"
                                        value="{{ number_format($row->total_deposit) }}đ" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-4">
                                <label class="form-label">Số dư đã sử dụng</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bx bxs-wallet-alt"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{ number_format($row->total_deposit - $row->balance) }}đ" disabled="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Địa chỉ IP dùng để đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-wifi"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{ $row->ip }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Thiết bị đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-desktop"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{ $row->device }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Đăng ký tài khoản vào lúc</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{ $row->created_at }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Đăng nhập gần nhất vào lúc</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{ date('H:i:s d-m-Y',$row->time_request) }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a type="button" class="btn btn-danger" href="{{ route('admin.users.index') }}"><i
                            class="fa fa-fw fa-undo"></i> Back</a>
                    <button type="submit" name="action" value="info-users" class="btn btn-primary"><i class="bi bi-download"></i>
                        Save</button>
                </form>
            </div>
        </div>
    </div>
     

</div>
<div class="modal fade" id="modal-addCredit" tabindex="-1" aria-labelledby="modal-block-popout" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.users.update', ['id' => $row->id]) }}" method="POST" enctype="multipart/form-data" class="default-form">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel2"><i class="fa fa-plus"></i> CỘNG SỐ DƯ
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm"
                      role="alert">
                        Khi Bạn <b>Cộng Tiền</b>, số dư sẽ được cộng vào tài khoản user nhưng khi bạn chạy auto bank thì nó sẽ cộng thêm 1 lần nữa vui lòng cân nhắc trước khi sử.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                class="bi bi-x"></i></button>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Loại ví:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="wallet" id="walletSelect">
                                <option value="1">VÍ CHÍNH</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Amount:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="amount" id="amountInput"
                                placeholder="Nhập số tiền cần cộng" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label"
                            for="example-hf-email">Lý do (*):</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="reason"></textarea>
                        </div>
                    </div>
                    <center>Nhấn vào nút Submit để thực hiện cộng <b id="amountDisplay" style="color:red;">0</b> vào <b
                            id="walletDisplay">VÍ CHÍNH</b></center>
                </div>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var selectWallet = document.getElementById('walletSelect');
                    var amountInput = document.getElementById('amountInput');
                    var amountDisplay = document.getElementById('amountDisplay');
                    var walletDisplay = document.getElementById('walletDisplay');
                    var noticeDebit = document.getElementById('notice_debit');

                    // Hiển thị giá trị mặc định cho số tiền và loại ví
                    updateAmountDisplay();
                    updateWalletDisplay();

                    // Lắng nghe sự kiện input trên input số tiền
                    amountInput.addEventListener('input', function() {
                        updateAmountDisplay();
                    });


                    function updateAmountDisplay() {
                        // Lấy giá trị từ input
                        var inputValue = amountInput.value;

                        // Kiểm tra nếu giá trị rỗng hoặc không phải là số
                        if (!inputValue || isNaN(inputValue)) {
                            amountDisplay.textContent =
                                '0'; // Hiển thị 0 nếu không có giá trị hoặc giá trị không hợp lệ
                            return;
                        }

                        // Định dạng số tiền và hiển thị vào amountDisplay
                        var formattedAmount = formatNumber(inputValue);
                        amountDisplay.textContent = formattedAmount;
                    }

                    function formatNumber(value) {
                        return parseFloat(value).toLocaleString('vi-VN');
                    }

                    function updateWalletDisplay() {
                        // Hiển thị loại ví được chọn
                        walletDisplay.textContent = selectWallet.options[selectWallet.selectedIndex].text;
                    }
                });
                </script>



                <div class="modal-footer">
                    <button type="button" class="btn btn-hero btn-danger" data-bs-dismiss="modal"><i
                            class="fa fa-fw fa-times me-1"></i> Close</button>
                    <button type="submit" name="action" value="cong-tien" class="btn btn-hero btn-success"><i
                            class="fa fa-fw fa-plus me-1"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-removeCredit" tabindex="-1" aria-labelledby="modal-block-popout" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.users.update', ['id' => $row->id]) }}" method="POST" enctype="multipart/form-data" class="default-form">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel2"><i class="fa fa-minus"></i> Balance                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Loại ví:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="wallet" id="walletSelect2">
                                <option value="1">VÍ CHÍNH</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Amount</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="amount" id="amountInput2"
                                placeholder="Nhập số tiền cần trừ" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Reason</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="reason" id="reasonInput"></textarea>
                        </div>
                    </div>
                    <center>Nhấn vào nút Submit để thực hiện trừ <b id="amountDisplay2" style="color:red;">0</b> trong
                        <b id="walletDisplay2">VÍ CHÍNH</b>
                    </center>
                </div>

                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var selectWallet = document.getElementById('walletSelect2');
                    var amountInput = document.getElementById('amountInput2');
                    var amountDisplay = document.getElementById('amountDisplay2');
                    var walletDisplay = document.getElementById('walletDisplay2');

                    // Hiển thị giá trị mặc định cho số tiền
                    updateAmountDisplay();

                    // Lắng nghe sự kiện input trên input số tiền
                    amountInput.addEventListener('input', function() {
                        updateAmountDisplay();
                    });
                    // Lắng nghe sự kiện change trên select box chọn loại ví
                    selectWallet.addEventListener('change', function() {
                        updateWalletDisplay();
                    });

                    function updateAmountDisplay() {
                        // Lấy giá trị từ input
                        var inputValue = amountInput.value;

                        // Kiểm tra nếu giá trị rỗng hoặc không phải là số
                        if (!inputValue || isNaN(inputValue)) {
                            amountDisplay.textContent =
                                '0'; // Hiển thị 0 nếu không có giá trị hoặc giá trị không hợp lệ
                            return;
                        }

                        // Định dạng số tiền và hiển thị vào amountDisplay
                        var formattedAmount = formatNumber(inputValue);
                        amountDisplay.textContent = formattedAmount;
                    }

                    function updateWalletDisplay() {
                        // Hiển thị loại ví được chọn
                        walletDisplay.textContent = selectWallet.options[selectWallet.selectedIndex].text;
                    }

                    function formatNumber(value) {
                        return parseFloat(value).toLocaleString('vi-VN');
                    }
                });
                </script>
                <div class="modal-footer">
                    <button type="button" class="btn btn-hero btn-danger" data-bs-dismiss="modal"><i
                            class="fa fa-fw fa-times me-1"></i> Close</button>
                    <button type="submit" name="action" value="tru-tien" class="btn btn-hero btn-success"><i
                            class="fa fa-fw fa-minus me-1"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">Lịch sử giao dịch [2000 dòng gần nhất]</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar">
        <table class="display table table-bordered table-stripped text-nowrap datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>Tài khoản</th>
              <th>Giao dịch</th>
              <th>Mã giao dịch</th>
              <th>Số dư trước</th>
              <th>Số tiền</th>
              <th>Số dư sau</th>
              <th>Nội dung</th>
              <th>Trạng thái</th>
              <th>Thời gian</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($row->transactions()->orderBy('id', 'desc')->limit(2000)->get() as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->username }}</td>
                <td>{!! Helper::formatTransType($item->type) !!}</td>
                <td>{{ $item->code }}</td>
                <td>{{ number_format($item->balance_before) }}</td>
                <td>{{ $item->prefix . ' ' . number_format($item->amount) }}</td>
                <td>{{ number_format($item->balance_after) }}</td>
                <td class="text-wrap">{{ $item->content }} </td>
                <td>{!! Helper::formatStatus($item->status) !!}</td>
                <th>{{ $item->created_at }}</th>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">Nhật ký hoạt động [2000 dòng gần nhất]</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar">
        <table class="display table table-bordered table-stripped text-nowrap datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>Tài khoản</th>
              <th>Nội dung</th>
              <th>Dữ liệu</th>
              <th>Địa chỉ IP</th>
              <th>Thời gian</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($row->histories()->orderBy('id', 'desc')->limit(2000)->get() as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ User::getUser($item->user_id, 'username') }}</td>
                <td>{{ $item->description }}</td>
                <td>-</td>
                <td>{{ $item->ip }}</td>
                <td>{{ $item->created_at }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div> 
@endsection
@section('scripts')

@endsection
