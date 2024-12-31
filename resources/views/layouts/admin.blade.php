<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('public/css/materialize.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/css/style.css')}}">
  <title>{{ $title }}</title>
</head>
<body>
<!-- NAVBAR -->
  @include('partials.header')
  <!-- END_NAVBAR -->
  <!-- MAIN -->
  @yield('content')
  <!-- END_MAIN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="{{asset('public/js/materialize.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @stack('script')
   <script>
  $(document).ready(function(){
    $('.sidenav').sidenav();
    $(".dropdown-trigger").dropdown();
    $('.modal').modal();
    var w = $(this).width();
    if(w > 973) {
      $('.calendar').removeAttr('id').removeAttr('tabindex').removeAttr('style');
      $('.event-today').removeAttr('id').removeAttr('tabindex').removeAttr('style');
      $('.calendar').removeClass('modal');
      $('.event-today').removeClass('modal');
    } else {
      $('.calendar').attr('id', 'calendar');
      $('.event-today').attr('id', 'event-today');
      $('.calendar').addClass('modal');
      $('.event-today').addClass('modal');
    }
  });
   </script>
</body>
</html>