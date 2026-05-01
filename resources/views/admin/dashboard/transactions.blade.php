@php 
     use App\Helpers\Helper;
     use App\Models\Product;
     use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'Biến động số dư')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">NHẬT KÝ THAY ĐỔI SỐ DƯ</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Số dư trước</th>
                <th>Số dư thay đổi</th>
                <th>Số dư hiện tại</th>
                <th>Thời gian</th>
                <th>Lý do</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
               <td><a class="text-primary" href="/users/edit/{{ $transaction->user_id }}"> [{{ $transaction->user_id }}] {{ User::getUser($transaction->user_id, 'name') }}</a></td>
               </td>
                <td class="text-right">
                    <span class="badge bg-success-gradient">{{ number_format($transaction->balance_before) }}đ</span>
                </td>
                <td class="text-right"><span class="badge bg-danger-gradient">{{ $transaction->prefix . ' ' . number_format($transaction->amount) }}đ</span></td>
                <td class="text-right"><span class="badge bg-primary-gradient">{{ number_format($transaction->balance_after) }}đ</span>
                </td>
                <td><span class="badge bg-light text-dark" data-bs-toggle="tooltip" title="{{ Helper::formatTimeAgo($transaction->created_at) }}">{{ $transaction->created_at }}</span></td>
                <td><i>{{ $transaction->content }}</i></td>
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