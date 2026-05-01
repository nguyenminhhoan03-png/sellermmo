@php 
     use App\Helpers\Helper;
     use App\Models\Product;
     use App\Models\User;
@endphp
@extends('admin.layouts.master')
@section('title', 'Nhật ký hoạt động')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">NHẬT KÝ HOẠT ĐỘNG</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Hành động</th>
                <th>Thời gian</th>
                <th>Địa chỉ IP</th>
            </tr>
          </thead>
          <tbody>
            @foreach($logs as $log)
            <tr>
              <td>{{ $log->id }}</td>
              <td><a class="text-primary" href="/users/edit/{{ $log->user_id }}"> [{{ $log->user_id }}] {{ User::getUser($log->user_id, 'name') }}</a></td>
              <td>{{ $log->action }}</td>
              <td>{{ $log->created_at }}</td>
              <td>{{ ($log->ip) }}</td>
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