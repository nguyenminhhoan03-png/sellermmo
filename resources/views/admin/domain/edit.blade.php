@php use App\Helpers\Helper; @endphp
@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')
  <div class="card custom-card">
    <div class="card-body">
      <form action="{{ route('admin.domain.update', ['id' => $domain->id]) }}" method="POST" data-reload="1" enctype="multipart/form-data" class="default-form">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Tên miền</label>
          <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $domain->name) }}" required>
        </div>
        <div class="mb-3 card bg-secondary mode_form"></div>
        <div class="mb-3 row">
          <div class="col-md-4">
            <label for="price" class="form-label">Giá gốc</label>
            <input type="number" class="form-control" name="price" id="price" value="{{ old('price', $domain->price) }}" required>
          </div>
          <div class="col-md-4">
            <label for="sale" class="form-label">Phần trăm giảm giá (%)</label>
            <input type="number" class="form-control" name="sale" id="sale" value="{{ old('sale', $domain->sale) }}" required>
          </div>
          <div class="col-md-4">
            <label for="extend_price" class="form-label">Phần trăm giảm giá (%)</label>
            <input type="number" class="form-control" name="extend_price" id="extend_price" value="{{ old('extend_price', $domain->extend_price) }}" required>
          </div>
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Trạng thái</label>
          <select class="form-control" id="status" name="status">
            <option value="1" @if (old('status', $domain->status) == 1) selected @endif>Hoạt động</option>
            <option value="0" @if (old('status', $domain->status) == 0) selected @endif>Không hoạt động</option>
          </select>
        </div>
        <div class="mb-3">
          <button class="btn btn-primary w-100" type="submit">Cập nhật</button>
        </div>
      </form>
    </div>
  </div>
@endsection
