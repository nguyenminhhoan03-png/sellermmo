@php 
     use App\Helpers\Helper;
     use App\Models\Product;
     use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'Lịch Sử Mua Mã Nguồn')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="mb-3 text-end">
    <a href="{{ route('admin.manguon.index') }}" class="btn btn-outline-primary me-2"><i class="fas fa-plus"></i> {{ __('Thêm Mã Nguồn') }}</a>
  </div>

  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">Danh sách Mã Nguồn</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('Người Dùng') }}</th>
              <th>{{ __('Loại mã nguồn') }}</th>
              <th>{{ __('Mã giao dịch') }}</th>
              <th>{{ __('Số tiền') }}</th>
              <th>{{ __('Ngày mua') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($history as $historys)
            <tr>
              <td>{{ $historys->id }}</td>
              <td><a class="text-primary" href="/users/edit/{{ $historys->user_id }}"> [{{ $historys->user_id }}] {{ User::getUser($historys->user_id, 'name') }}</a></td>
              <td>{{ Product::getCode($historys->product_id, 'name') }}</td>
              <td>{{ $historys->trans_id }}</td>
              <td>{{ formatCurrency($historys->price) }}</td>
              <td>{{ $historys->created_at }}</td>
            </tr> 
             @endforeach 
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
@endsection
@section('scripts')
<script>
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