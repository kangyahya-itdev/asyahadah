@extends('layouts.users')
@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col s3">
        <a href="{{ url()->previous() }}">&lt; Back</a>
        </div>
        <div class="col s9">

        </div>
    </div>
    <div class="row">
        <div class="card-panel">
            <div class="card-content">
                <span class="card-title">Riwayat Pesanan</span>
                <table class="bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Komisi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $loop->parent->iteration }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td class="center">{{ $item->quantity }}</td>
                                    <td>{{ $item->product->getFormattedPriceAttribute() }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $item->product->commissionProducts->personal_commission }}%
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td>{{($order->status == "Pending Payment") ? 'Bayar' : '-'}}</td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="7" class="center">Tidak ada riwayat pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
