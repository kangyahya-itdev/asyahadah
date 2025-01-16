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
                                    <td>
                                        @if($order->status == "Pending Payment")
                                            <button class="btn blue btn-pay" data-id="{{ $order->id }}">Bayar</button>
                                        @else
                                            <span class='badge green'> {{ $order->status }} </span>
                                        @endif
                                    </td>
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
<div id="modal-payment-confirmation" class="modal">
    <div class="modal-content">
        <h5>Konfirmasi Pembayaran</h5>
        <p>Saldo Anda: <strong>Rp {{ number_format(Auth::user()->wallet->balance, 0, ',', '.') }}</strong></p>
        <p>Total Pembayaran: <strong id="modal-total-payment"></strong></p>
        <p>Apakah Anda yakin ingin melanjutkan pembayaran untuk pesanan ini?</p>
    </div>
    <div class="modal-footer">
        <button id="confirm-payment" class="btn green modal-close">Ya, Bayar</button>
        <button class="btn grey modal-close">Batal</button>
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
  document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi modal
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);

    // Tombol Bayar diklik
    document.querySelectorAll('.btn-pay').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const orderId = this.getAttribute('data-id');
            const totalPaymentText = this.closest('tr').querySelector('td:nth-child(5)').innerText;
            const totalPayment = parseInt(totalPaymentText.replace(/[^0-9]/g, ''), 10); // Ambil angka dari teks
            const balanceText = '{{ Auth::user()->wallet->balance }}'; // Ambil saldo dari server-side
            const balance = parseInt(balanceText, 10);

            document.getElementById('confirm-payment').setAttribute('data-id', orderId);
            document.getElementById('modal-total-payment').innerText = totalPaymentText;

            // Periksa apakah saldo mencukupi
            const confirmButton = document.getElementById('confirm-payment');
            if (balance < totalPayment) {
                confirmButton.setAttribute('disabled', 'disabled');
            } else {
                confirmButton.removeAttribute('disabled');
            }

            const modal = document.querySelector('#modal-payment-confirmation');
            const instance = M.Modal.getInstance(modal);
            instance.open();
        });
    });

    // Tombol konfirmasi pembayaran diklik
    document.getElementById('confirm-payment').addEventListener('click', function () {
        const orderId = this.getAttribute('data-id');

        fetch("{{ route('user_area.set.pay', ':id') }}".replace(':id', orderId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({}),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire('Berhasil!', 'Pembayaran berhasil diproses.', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
            });
    });
});



</script>
@endpush