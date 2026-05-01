@extends('admin.layouts.master')
@section('title', 'Quản lý API Bank')
@section('content')
<div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
    <svg class="svg-warning" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem"
        fill="#000000">
        <path d="M0 0h24v24H0z" fill="none"></path>
        <path
            d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z">
        </path>
    </svg>
    (manual) là loại link cron thanh toán bằng cách nạp tiền.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
</div>
<div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
    <svg class="svg-warning" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem"
        fill="#000000">
        <path d="M0 0h24v24H0z" fill="none"></path>
        <path
            d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z">
        </path>
    </svg>
    (transfer) là loại link cron thanh toán theo hình thức chuyển khoản.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
</div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">AutoBank | {{ $modifiedUrl }} | Vietcombank</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.recharge.apibank.update', ['type' => 'dvr_vietcombank']) }}"
                        class="axios-form" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">API Token {{ $modifiedUrl }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" id="api_token_1" name="api_token"
                                        value="{{ $dvr_vietcombank['api_token'] ?? '' }}">
                                    <button type="button" id="show_token_1" class="btn btn-danger"
                                        onclick="toggleTokenVisibility('1')">Show</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="link_cron" class="form-label">Link Cron (manual)</label>
                            <input type="text" class="form-control" id="link_cron" name="link_cron"
                                value="{{ route('cron.deposit.check', ['type' => 'vietcombank']) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="link_transfer" class="form-label">Link Cron (transfer)</label>
                            <input type="text" class="form-control" id="link_transfer" name="link_transfer"
                                value="{{ route('cron.deposit.transfer', ['type' => 'vietcombank']) }}" readonly>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" type="submit">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">AutoBank | {{ $modifiedUrl }} | TPBank</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.recharge.apibank.update', ['type' => 'dvr_tpbank']) }}" class="axios-form"
                        method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">API Token {{ $modifiedUrl }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" id="api_token_2" name="api_token"
                                        value="{{ $dvr_tpbank['api_token'] ?? '' }}">
                                    <button type="button" id="show_token_2" class="btn btn-danger"
                                        onclick="toggleTokenVisibility('2')">Show</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="link_cron" class="form-label">Link Cron (manual)</label>
                            <input type="text" class="form-control" id="link_cron" name="link_cron"
                                value="{{ route('cron.deposit.check', ['type' => 'tpbank']) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="link_transfer" class="form-label">Link Cron (transfer)</label>
                            <input type="text" class="form-control" id="link_transfer" name="link_transfer"
                                value="{{ route('cron.deposit.transfer', ['type' => 'tpbank']) }}" readonly>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" type="submit">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">AutoBank | {{ $modifiedUrl }} | Acb</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.recharge.apibank.update', ['type' => 'dvr_acb']) }}" class="axios-form"
                        method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">API Token {{ $modifiedUrl }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" id="api_token_3" name="api_token"
                                        value="{{ $dvr_acb['api_token'] ?? '' }}">
                                    <button type="button" id="show_token_3" class="btn btn-danger"
                                        onclick="toggleTokenVisibility('3')">Show</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="link_cron" class="form-label">Link Cron (manual)</label>
                            <input type="text" class="form-control" id="link_cron" name="link_cron"
                                value="{{ route('cron.deposit.check', ['type' => 'acb']) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="link_transfer" class="form-label">Link Cron (transfer)</label>
                            <input type="text" class="form-control" id="link_transfer" name="link_transfer"
                                value="{{ route('cron.deposit.transfer', ['type' => 'acb']) }}" readonly>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" type="submit">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">AutoBank | {{ $modifiedUrl }} | MBBank</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.recharge.apibank.update', ['type' => 'dvr_mbbank']) }}"
                        class="axios-form" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">API Token {{ $modifiedUrl }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" id="api_token_4" name="api_token"
                                        value="{{ $dvr_mbbank['api_token'] ?? '' }}">
                                    <button type="button" id="show_token_4" class="btn btn-danger"
                                        onclick="toggleTokenVisibility('4')">Show</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="link_cron" class="form-label">Link Cron (manual)</label>
                            <input type="text" class="form-control" id="link_cron" name="link_cron"
                                value="{{ route('cron.deposit.check', ['type' => 'mbbank']) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="link_transfer" class="form-label">Link Cron (transfer)</label>
                            <input type="text" class="form-control" id="link_transfer" name="link_transfer"
                                value="{{ route('cron.deposit.transfer', ['type' => 'mbbank']) }}" readonly>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" type="submit">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">AutoBank | {{ $modifiedUrl }} | BIDV</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.recharge.apibank.update', ['type' => 'dvr_bidv']) }}"
                        class="axios-form" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">API Token {{ $modifiedUrl }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" id="api_token_5" name="api_token"
                                        value="{{ $dvr_bidv['api_token'] ?? '' }}">
                                    <button type="button" id="show_token_5" class="btn btn-danger"
                                        onclick="toggleTokenVisibility('5')">Show</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="link_cron" class="form-label">Link Cron (manual)</label>
                            <input type="text" class="form-control" id="link_cron" name="link_cron"
                                value="{{ route('cron.deposit.check', ['type' => 'bidv']) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="link_transfer" class="form-label">Link Cron (transfer)</label>
                            <input type="text" class="form-control" id="link_transfer" name="link_transfer"
                                value="{{ route('cron.deposit.transfer', ['type' => 'bidv']) }}" readonly>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" type="submit">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <h4 class="card-title">AutoBank | {{ $modifiedUrl }} | MoMo</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.recharge.apibank.update', ['type' => 'dvr_momo']) }}"
                        class="axios-form" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">API Token {{ $modifiedUrl }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" id="api_token_6" name="api_token"
                                        value="{{ $dvr_momo['api_token'] ?? '' }}">
                                    <button type="button" id="show_token_6" class="btn btn-danger"
                                        onclick="toggleTokenVisibility('6')">Show</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="link_cron" class="form-label">Link Cron (manual)</label>
                            <input type="text" class="form-control" id="link_cron" name="link_cron"
                                value="{{ route('cron.deposit.check', ['type' => 'momo']) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="link_transfer" class="form-label">Link Cron (transfer)</label>
                            <input type="text" class="form-control" id="link_transfer" name="link_transfer"
                                value="{{ route('cron.deposit.transfer', ['type' => 'momo']) }}" readonly>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" type="submit">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <h4 class="card-title">AutoBank | {{ $modifiedUrl }} | THESIEURE</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.recharge.apibank.update', ['type' => 'dvr_tsr']) }}"
                        class="axios-form" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label class="form-label">API Token {{ $modifiedUrl }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" id="api_token_7" name="api_token"
                                        value="{{ $dvr_tsr['api_token'] ?? '' }}">
                                    <button type="button" id="show_token_7" class="btn btn-danger"
                                        onclick="toggleTokenVisibility('7')">Show</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="link_cron" class="form-label">Link Cron (manual)</label>
                            <input type="text" class="form-control" id="link_cron" name="link_cron"
                                value="{{ route('cron.deposit.check', ['type' => 'tsr']) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="link_transfer" class="form-label">Link Cron (transfer)</label>
                            <input type="text" class="form-control" id="link_transfer" name="link_transfer"
                                value="{{ route('cron.deposit.transfer', ['type' => 'tsr']) }}" readonly>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" type="submit">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
      <div class="card custom-card">
        <div class="card-header justify-content-between">
          <h4 class="card-title">Notification | Telegram</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.recharge.apibank.update', ['type' => 'telegram']) }}" class="axios-form" method="POST">
              @csrf
             <div class="mb-3 row">
               <div class="col-md-4">
                <label for="bot_token" class="form-label">BOT Token</label>
                <input type="text" class="form-control" id="bot_token" name="bot_token" value="{{ $telegram['bot_token'] ?? '' }}">
              </div>
              <div class="col-md-4">
                <label for="chat_id" class="form-label">ChatID Nhận</label>
                <input type="text" class="form-control" id="chat_id" name="chat_id" value="{{ $telegram['chat_id'] ?? '' }}">
              </div>
              <div class="col-md-4">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-select" id="status" name="status">
                  <option value="1" {{ ($telegram['status'] ?? 0) == 1 ? 'selected' : '' }}>Bật</option>
                  <option value="0" {{ ($telegram['status'] ?? 0) == 0 ? 'selected' : '' }}>Tắt</option>
                </select>
              </div>
            </div>
            <div class="mb-3 text-end">
              <button class="btn btn-primary" type="submit">Cập Nhật</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    </div>
 <script>
 function toggleTokenVisibility(id) {
    var input = document.getElementById('api_token_' + id);
    var button = document.getElementById('show_token_' + id);
    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = 'Hide';
    } else {
        input.type = 'password';
        button.textContent = 'Show';
    }
}
</script>   
@endsection
