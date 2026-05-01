@php use App\Helpers\Helper; @endphp
@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    CHỈNH SỬA LINK CRON
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" id="id" name="id" value="{{ $order->id }}">
                <form action="{{ route('admin.cron.list.update', ['id' => $order->id]) }}" method="POST" data-reload="1" enctype="multipart/form-data" class="default-form">
                    @csrf
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Liên kết cần CRON (<span class="text-danger">*</span>)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="{{ $order->url }}" id="url" name="url" required="">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Vòng lặp (<span class="text-danger">*</span>)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="{{ $order->second }}" name="second" id="second" required="">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Method</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="method" required="" disabled>
                                <option selected="" value="GET">GET</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Máy chủ</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="server" name="server" required="">
                                @foreach ($server as $servers )
                                <option value="{{ $servers->id }}" data-price="{{ $servers->price - ($servers->price * ($servers->ck / 100)) }}" @if ($order->id_server == $servers->id) selected @endif>{{ $servers->name }} - {{ number_format($servers->price) }}đ</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Trạng thái</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="status" name="status" required="">
                                <option @if ($order->status == 'hoatdong') selected @endif value="hoatdong" >Hoạt
                                    động</option>
                                <option value="tamdung" @if ($order->status == 'tamdung') selected @endif>Tạm dừng
                                </option>
                                <option value="hethan" @if ($order->status == 'hethan') selected @endif>Hết
                                    hạn</option>
                            </select>
                        </div>
                    </div>
                    <a type="button" class="btn btn-danger shadow-danger btn-wave waves-effect waves-light" href="{{ route('admin.cron.list') }}"><i class="fa fa-fw fa-undo me-1"></i>
                        Back</a>
                    <button type="submit" class="btn btn-primary shadow-primary btn-wave waves-effect waves-light"><i class="fa fa-fw fa-save me-1"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
