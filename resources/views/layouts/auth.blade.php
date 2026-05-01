@php use App\Helpers\Helper; @endphp
@include('layouts.header')
@yield('content')
@if ($errors->any())
<script>
        $swal('error','{{ $errors->first() }}')
    </script>
@endif                            
@if (session('success'))
    <script>
        $swal('success','{{ session('success') }}')
    </script>
@elseif (session('error'))
    <script>
          $swal('error','{{ session('error') }}')
    </script>
@endif
@yield('scripts')
