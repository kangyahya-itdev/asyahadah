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
                <table class="responsive-table bordered striped highlight" width='100%' id='history-table'>
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Produk</td>
                            <td>Jumlah</td>
                            <td>Harga</td>
                            <td>Total</td>
                            <td>Status</td>
                            <td>Komisi</td>
                            <td>Tanggal</td>
                            <td>Aksi</td>
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
                                    <td>Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $item->product->commissionProducts->personal_commission }}%
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td>{{($order->status == "Pending Payment") ? 'Bayar' : $order->status}}</td>
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
@push('script')
<script>
    $(document).ready(function() {
    $('#history-table').DataTable({
      "paging": true,
      "ordering": true,
      "language": {
        "lengthMenu": "Tampilkan _MENU_ entri per halaman",
        "zeroRecords": "Data tidak ditemukan",
        "info": "Menampilkan _START_ ke _END_ dari _TOTAL_ entri",
        "infoEmpty": "Tidak ada entri tersedia",
        "infoFiltered": "(difilter dari _MAX_ total entri)",
        "search": "Cari:",
        "paginate": {
          "next": "Berikutnya",
          "previous": "Sebelumnya"
        }
      }
    });
  });
</script>
@endpush