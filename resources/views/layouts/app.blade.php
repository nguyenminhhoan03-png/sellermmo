@php use App\Helpers\Helper; @endphp
@include('layouts.header')
@include('layouts.nav') 
@yield('content')
@include('layouts.footer')
@if ($errors->any())
<script>
        showMessage('{{ $errors->first() }}','error')
    </script>
@endif                            
@if (session('success'))
    <script>
        $swal('success','{{ session('success') }}')
    </script>
@elseif (session('error'))
    <script>
         showMessage('{{ session('error') }}','error')
    </script>
@endif
@yield('scripts')