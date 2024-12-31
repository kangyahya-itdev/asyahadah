<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Asyahadah Store</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="{{ asset('public/css/materialize.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="{{ asset('public/css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  @include('partials.nav')
  @yield('content')
  @include('partials.footer')
  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="{{asset('public/js/materialize.js')}}"></script>
  <script src="{{asset('public/js/init.js')}}"></script>
  <script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyD86kkWvTkvv1nsdk29fowO8eyTs_ImBKM",
    authDomain: "asyahadahstore.firebaseapp.com",
    projectId: "asyahadahstore",
    storageBucket: "asyahadahstore.firebasestorage.app",
    messagingSenderId: "217571555470",
    appId: "1:217571555470:web:55566c9325226bbabeb1df",
    measurementId: "G-DWJRYW9EXY"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>
  </body>
</html>
