@extends('layouts.users')
@section('content')
<!-- Balance Section -->
    <div class="container">
      <!-- Profile Section -->
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <div class="card">
                <div class="card-image">
                    <img src="{{ $user->profile_picture ?? asset('public/images/profile/default.jpg') }}" alt="Profile Picture" class="circle responsive-img profile-img">
                </div>
                <div class="card-content center">
                    <h5>{{ $user->name }}</h5>
                    <p>📞 {{ $user->handphone }}</p>
                    <p>✉️ {{ $user->email }}</p>
                </div>
                <div class="card-action center">
                    <a href="{{ route('user_area.profile.edit_profile') }}" class="btn waves-effect waves-light blue">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About Me Section -->
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <ul class="collection with-header">
                <li class="collection-header"><h5>About Me</h5></li>
                <li class="collection-item">🕒 Joined on: {{ $user->created_at->format('d M Y') }}</li>
                <li class="collection-item">🔗 Referral Code: {{ $user->referral_code ?? 'No Referral Code available' }}</li>
                <li class="collection-item">👤 Referred By: {{ $user->referredBy->name ?? 'No Referred By available' }}</li>
            </ul>
        </div>
    </div>

    <!-- Wallet Section -->
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <ul class="collection with-header">
                <li class="collection-header"><h5>Wallet</h5></li>
                <li class="collection-item">💰 Saldo Wallet: Rp {{ number_format($user->wallet->balance ?? 0, 2, ',', '.') }}</li>
                <li class="collection-item">💸 Total Komisi: Rp {{ number_format($user->commissions->sum('amount') ?? 0, 2, ',', '.') }}</li>
            </ul>
        </div>
    </div>

    <!-- Settings Section -->
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <ul class="collection with-header">
                <li class="collection-header"><h5>Settings</h5></li>
                <li class="collection-item">📜 Bio: {{ $user->bio ?? 'No bio available' }}</li>
                <li class="collection-item">🕒 Joined on: {{ $user->created_at->format('d M Y') }}</li>
            </ul>
        </div>
    </div>

    <!-- Rekening Section -->
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <ul class="collection with-header">
                <li class="collection-header"><h5>Rekening Penarikan</h5></li>

                @if(isset($user->rekenings))
                    <li class="collection-item">🔢 Nomor Rekening: {{ $user->rekenings->rekening_no ?? 'No rekening available' }}</li>
                    <li class="collection-item">🏦 Bank/E-Wallet: {{ $user->rekenings->rekening_bank ?? 'No Bank available' }}</li>
                    <div class="center">
                        <a href="{{ route('user_area.profile.edit_rekening') }}" class="btn waves-effect waves-light blue">Edit Rekening</a>
                    </div>
                @else
                    <li class="collection-item">Belum ada rekening yang terdaftar</li>
                    <div class="center">
                        <a href="{{ route('user_area.profile.add_rekening') }}" class="btn waves-effect waves-light blue">Tambah Rekening</a>
                    </div>
                @endif
            </ul>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <div class="card-action center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn red">Logout</button>
                </form>
            </div>
        </div>
    </div>
  </div>
@endsection

@push('style')
<style>
    .profile-img {
        width: 150px;
        height: 150px;
        margin-top: 0px;
        border: 3px solid white;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush