@extends('layouts.front')
@section('content')
<div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
      <h1 class="header center green-text">Asyahadah Store</h1>
      <div class="row center">
        <h5 class="header col s12 light">Temukan pengalaman berbelanja yang berbeda bersama kami di Asyahadah Store! Kami hadir dengan berbagai produk berkualitas tinggi dan harga terjangkau untuk memenuhi segala kebutuhan Anda.</h5>
        <h5 class="center-align green-text">Kenapa Harus Pilih Asyahadah Store?</h5>
        <ul class="collection">
            <li class="collection-item">
            <i class="material-icons green-text">check_circle</i> Produk berkualitas dengan pilihan beragam
            </li>
            <li class="collection-item">
            <i class="material-icons green-text">check_circle</i> Harga ramah di kantong
            </li>
            <li class="collection-item">
            <i class="material-icons green-text">check_circle</i> Pelayanan ramah dan responsif
            </li>
            <li class="collection-item">
            <i class="material-icons green-text">check_circle</i> Promo menarik setiap bulannya!
            </li>
            <li class="collection-item">
            <i class="material-icons green-text">check_circle</i> Dapat Komisi Setiap kali pembelian produk!
            </li>
        </ul>
        </p>
        Mari jadi bagian dari keluarga Asyahadah Store dan nikmati pengalaman belanja yang aman, nyaman, dan memuaskan.
        Jangan sampai ketinggalan, yuk <a href="{{ route('register') }}" id="download-button" class="btn-large waves-effect waves-light green">Bergabung</a> sekarang juga!
        </h6>
      </div>
      <br><br>
    </div>
  </div>
  @endsection