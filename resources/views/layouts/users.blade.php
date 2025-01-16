<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title }}</title>
  <!-- Import Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- Import MaterializeCSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
  <link rel="manifest" href="{{ asset('public/manifest.json') }}">

  <style>
    body {
      background-color: #e3f2fd;
      padding-bottom: 70px; /* Tambahkan padding agar konten tidak tertutup navbar */
    }
    .header {
      background-color: #1976d2;
      color: white;
      padding: 20px;
      text-align: center;
    }
    .balance-card {
      background-color: green;
      color: white;
      padding: 20px;
      border-radius: 8px;
      margin-top: 20px;
      text-align: center;
    }
    .menu-item {
      text-align: center;
      padding: 10px;
    }
    .menu-item i {
      font-size: 2rem;
      color: #1e88e5;
    }
    .menu-label {
      color: #1e88e5;
      font-size: 0.9rem;
    }
    .feature-item {
      text-align: center;
      color: #1e88e5;
      padding: 10px;
    }
    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
      background-color: white;
      border-top: 1px solid #e0e0e0;
    }
    .bottom-nav ul {
      margin: 0;
    }
    .bottom-nav li a {
      color: #fff;
    }
    .bottom-nav li a.active, .bottom-nav li a.active i {
      color: #1e88e5; /* Ubah warna ikon dan teks pada item aktif */
      font-weight: bold;
    }
  </style>
  @stack('style')
</head>
<body>

  @include('user_area.partials.nav')
  @yield('content')
  @include('user_area.partials.bottom')

  <!-- Import Materialize JavaScript -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Materialize JS -->
  <script src="{{asset('public/js/materialize.js')}}"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @stack('script')
  <script>
    $(document).ready(function(){
        $('.sidenav').sidenav();
    });
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            M.toast({html: '{{ session('success') }}', classes: 'green'});
        @endif
        @if(session('error'))
            M.toast({html: '{{ session('error') }}', classes: 'red'});
        @endif
    });
  </script>
</body>
</html>
