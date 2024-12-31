@extends('layouts.users')
@section('content')
<!-- Balance Section -->
<div class="container">
    <div class="balance-card z-depth-2">
      <h6><i class='material-icons'>account_balance_wallet</i>Saldo Wallet</h6>
      <h4>{{ number_format($user->wallet->balance ?? 0, 2, ',', '.')}}</h4>
      <h6><i class='material-icons'>money</i>Saldo Komisi</h6>
      <h5>{{ number_format($user->commissions->sum('amount') ?? 0, 2, ',', '.')}}</h5>
      <div class="row">
        <div class="col s12 menu-item">
          <a href="#" class="btn green">Withdrawal</a>
          <a href="{{route('user_area.topup')}}" class="btn orange">Top Up</a>
        </div>
      </div>
    </div>
    <!-- Quick Access Menu -->
    <!-- Feature Section -->
  </div>
@endsection