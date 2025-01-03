@extends('layouts.front')

@section('content')
<div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
      <h1 class="header center green-text">Register</h1>
      <div class="row center">
        <h5 class="center-align green-text">Masukan Data yang valid!</h5>
        <div class='row'>
            @if(session('success'))
                <span class="green-text">{{ session('success') }}</span>
            @endif
            @if(session('error'))
                <span class="red-text">{{ session('error') }}</span>
            @endif 
        <form action="{{route('register')}}" method="post">
            @csrf
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">smartphone</i>
                    <input id="text_telephone" type="tel" name="text_telephone" class="validate" value="{{ old('text_telephone') }}">
                    <label for="text_telephone">Handphone</label>
                    @error('text_telephone')
                        <span class="red-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class='row'>
                <div class="input-field col s12">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="text_name" type="text" name="text_name" class="validate" value="{{ old('text_name') }}">
                    <label for="text_name">Nama Lengkap</label>
                    @error('text_name')
                        <span class="red-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class='row'>
                <div class="input-field col s12">
                    <i class="material-icons prefix">mail</i>
                    <input id="text_mail" type="email" name="text_mail" class="validate" value="{{ old('text_mail') }}">
                    <label for="text_mail">Email</label>
                    @error('text_mail')
                        <span class="red-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class='row'>
                <div class="input-field col s12">
                    <i class="material-icons prefix">lock</i>
                    <input id="text_password" type="password" name="text_password" class="validate" value="{{ old('text_password') }}">
                    <label for="text_password">Password</label>
                    @error('text_password')
                        <span class="red-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class='row'>
                <div class="input-field col s12">
                    <i class="material-icons prefix">lock</i>
                    <input id="text_password_confirmation" type="password" name="text_password_confirmation" class="validate" value="{{ old('text_password_confirmation') }}">
                    <label for="text_password_confirmation">Konfirmasi Password</label>
                    @error('text_password_confirmation')
                        <span class="red-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class='row'>
                <div class="input-field col s12">
                    <i class="material-icons prefix">code</i>
                    <input id="kode_referral" type="text" name="kode_referral" class="validate" value="{{ old('kode_referral', $kode_referral) }}" readonly>
                    <label for="kode_referral">Kode Referral</label>
                    @error('kode_referral')
                        <span class="red-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class='row'>
                <div class='input-field col s12'>
                    <input type="submit" class='btn btn-primary' value="Gabung">
                </div>
                <p>Sudah punya akun? <a href='{{ route("login") }} '>Login</a></p>
            </div>
          </form>
        </div>
      </div>
      <br><br>
    </div>
  </div>
  @endsection