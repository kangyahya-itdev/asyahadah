@extends('layouts.front')

@section('content')
<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <br><br>
        <h1 class="header center green-text">Login</h1>
        <div class="row center">
            <h5 class="center-align green-text">Masukkan data yang valid!</h5>
            <div class="row">
                @if (session('error'))
                    <div class="red-text center-align">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="green-text center-align">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">smartphone</i>
                            <input id="handphone" type="tel" name="handphone" value="{{ old('handphone') }}">
                            <label for="handphone">Handphone</label>
                            @error('handphone')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input id="password" type="password" name="password">
                            <label for="password">Password</label>
                            @error('password')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button type="submit" class="btn btn-primary">Masuk</button>
                        </div>
                        <p>Belum punya akun? <a href='{{ route("register") }} '>Register</a></p>
                    </div>
                </form>
            </div>
        </div>
        <br><br>
    </div>
</div>
@endsection
