@extends('layouts.users')
@section('content')
<!-- Balance Section -->
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
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3"><a href="#instant-method" aria-controls="instant-method" class='active'>Instant</a></li>
                <li class="tab col s3"><a class="active" href="#other-method" aria-controls="other-method">Other Method</a></li>
            </ul>
        </div>
        <div id="instant-method" class="col s12">
            <div class="row">
                <div class="col s12 m6">
                    <div class="card ">
                        <div class="card-content">
                            <span class="card-title" style="margin-bottom: 20px;">Pilih Jumlah</span>
                            @php
                                $amounts = [20000, 50000, 100000, 150000];
                            @endphp
                            <div class='row' style="margin-top: 10px;">
                            @foreach($amounts as $amount)
                                <div class='col s3 m3'>
                                    <button class='btn waves-effect waves-light' onclick="setAmount({{$amount}})">{{ number_format($amount, 0, ',', '.') }}</button>
                                </div>
                            @endforeach
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="number" id="manual-amount" placeholder="Masukkan jumlah nominal" min="10000">
                                    <label for="manual-amount">Jumlah Manual</label>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button class="btn waves-effect waves-light modal-trigger" onclick="showBankDetails()" data-target="bank-modal">Top Up Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="other-method" class="col s12">
        <div class="row">
            <div class="col s12 m6">
                <div class="card ">
                    <div class="card-content">
                        <span class="card-title center">Coming Soon</span>
                        <p class="center">Metode pembayaran lain akan segera tersedia. Stay tuned!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="upload-form" class="row" style="display: none;">
        <div class="col s12 m6 offset-m3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Unggah Bukti Transfer</span>
                    <form id="proof-upload-form" method="POST" enctype="multipart/form-data">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <!-- Input Nominal -->
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="number" id="uploaded-amount" name="amount" readonly>
                                <label for="uploaded-amount">Jumlah Transfer</label>
                            </div>
                        </div>

                        <!-- Input File Bukti Transfer -->
                        <div class="row">
                            <div class="file-field input-field col s12">
                                <div class="btn">
                                    <span>Upload</span>
                                    <input type="file" id="proof-image" name="proof_image" accept="image/*" required>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Unggah bukti transfer">
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="row">
                            <div class="col s12">
                                <button class="btn waves-effect waves-light" type="submit">Kirim Bukti</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col s12'>
            <div class='card'>
                <div class='card-content'>
                    <span class='card-title'>History</span>
                    <table class='table table-sm bordered'>
                        <thead>
                            <tr>
                                <th>
                                    NO
                                </th>
                                <th>
                                    Jumlah
                                </th>
                                <th>Bukti</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topups as $item)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $item->amount }}
                                </td>
                                <td>
                                    <a href="#">
                                        <img src="{{ asset('storage/app/public/' . $item->proof_image) }}"  alt="" width='50px'>
                                    </a>
                                </td>
                                <td>
                                    {{ $item->created_at }}
                                </td>
                                <td>
                                    @if ($item->status === 'pending')
                                        <span class="badge yellow black-text">Menunggu Konfirmasi Admin</span>
                                    @elseif ($item->status === 'confirmed')
                                        <span class="badge green white-text">Dikonfirmasi</span>
                                    @elseif ($item->status === 'rejected')
                                        <span class="badge red white-text">Ditolak</span>
                                    @else
                                        <span class="badge grey white-text">{{ $item->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='5'>
                                    Tidak Ada History
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="bank-modal" class="modal">
    <div class="modal-content">
        <h4>Detail Top Up</h4>
        <p>Silakan transfer ke nomor rekening berikut:</p>
        <p><strong>Nomor Rekening:</strong> <span id="bank-account-number">1234-5678-9012</span></p>
        <p><strong>Atas Nama:</strong> <span id="account-name">PT Asyahadah Store</span></p>
        <p><strong>Jumlah:</strong> Rp <span id="amount-display"></span></p>
    </div>
    <div class="modal-footer">
    <button class="modal-close btn waves-effect waves-light" onclick="showUploadForm()">Tutup</button>
    </div>
</div>

@endsection
@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Materialize modal
        var elems = document.querySelectorAll('.modal');
        M.Modal.init(elems);
    });
    function showBankDetails() {
        const amount = document.getElementById('manual-amount').value;

        if (!amount || amount < 10000) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Masukkan jumlah nominal minimal 10.000!',
            });
            return;
        }

        // Tampilkan nominal di modal
        document.getElementById('amount-display').textContent = parseInt(amount).toLocaleString();

        // Informasi bank (dapat diganti dengan data dinamis dari backend jika diperlukan)
        const bankAccount = "1234-5678-9012";
        const accountName = "PT Asyahadah Store";

        // Set informasi bank dan atas nama
        document.getElementById('bank-account-number').textContent = bankAccount;
        document.getElementById('account-name').textContent = accountName;

        document.getElementById('uploaded-amount').value = amount;
        // Tampilkan modal
        const modal = M.Modal.getInstance(document.getElementById('bank-modal'));
        modal.open();
    }
    $(document).ready(function(){
        $('.tabs').tabs();
    });
    function setAmount(amount) {
        document.getElementById('manual-amount').value = amount;
    }
    document.querySelector('form').addEventListener('submit', function (e) {
        document.getElementById('manual-amount-hidden').value = document.getElementById('manual-amount').value;
    });

    function topUpNow() {
        const amount = document.getElementById('manual-amount').value;

        if (!amount || amount < 10000) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Masukkan jumlah nominal minimal 10.000!',
            });
            return;
        }

        Swal.fire({
            icon: 'success',
            title: 'Top Up Berhasil',
            text: `Anda telah melakukan top up sebesar Rp ${parseInt(amount).toLocaleString()}.`,
        });
    }
    function showUploadForm() {
        const form = document.getElementById('upload-form');
        form.style.display = 'block';
    }
</script>
@endpush