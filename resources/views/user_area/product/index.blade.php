@extends('layouts.users')
@section('content')
<!-- Balance Section -->
<div class="container">
    <br> 
    <div class="row">
        <div class="col s9">

        </div>
        <div class="col s3 right">
            <a href="{{route('user_area.product.history')}}" class="right">
                History
            </a>
        </div>
    </div>
    <div class="row">
        <table class="responsive-table highlight striped" id="table-product" width="100%">
            <thead>
                <tr class="light-green lighten-1">
                    <th>No</th>
                    <th>Product</th>
<<<<<<< HEAD
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Komisi</th>
=======
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Commission</th>
>>>>>>> 41834b0182400a900590fb0560dfd6a57709c194
                </tr>
            </thead>
            <tbody>
                @forelse($products as $prod)
                <tr data-product-id="{{ $prod->id }}">
                    <td class="light-green lighten-1">{{ $loop->iteration }}</td>
                    <td>{{ $prod->name }}</td>
                    <td>{{ $prod->stock }}</td>
                    <td>{{ $prod->formatted_price }}</td>
                    <td>{{ number_format($prod->price * 0.01, 2) }}</td>
                </tr>
                @empty
                <tr>
<<<<<<< HEAD
                    <td colspan="5" class="center">Tidak Ada Data</td>
=======
                    <td colspan="5" class="center">No products available</td>
>>>>>>> 41834b0182400a900590fb0560dfd6a57709c194
                </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>
    <div id="action" class="row" style="display:none">
    <div class="col s12 m12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title" id="product-name">Product Name</span>
                    <p>Stock: <span id="product-stock"></span></p>
                    <p>Price: <span id="product-price"></span></p>
                    <p>Commission: <span id="product-commission"></span></p>
                </div>
                <div class="card-action">
                    <button id="btn-buy" class="btn waves-effect waves-light green col s6 m6">Beli</button>
                    <button id="btn-pay" class="btn waves-effect waves-light blue col s6 m6">Bayar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Buy -->
<div id="modal-buy" class="modal">
    <div class="modal-content">
        <h4>Buy Product</h4>
        <div class="divider"></div>
        <div class="card-panel light-green lighten-5">
            <div class="row">
                <div class="col s6">
                    <p><strong>Product:</strong></p>
                </div>
                <div class="col s6 right-align">
                    <p id="modal-buy-product-name"></p>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <p><strong>QTY:</strong></p>
                </div>
                <div class="col s6 right-align">
                    <p class="range-field">
                        <input type="number" id="qty" value='1' />
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <p><strong>Price:</strong></p>
                </div>
                <div class="col s6 right-align">
                    <input readonly type="text" id="modal-buy-product-price">
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <p><strong>Total Price:</strong></p>
                </div>
                <div class="col s6 right-align">
                    <p id="modal-buy-total-product-price"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="modal-close btn red">Cancel</button>
        <button id="confirm-buy" class="btn green">Confirm</button>
    </div>
</div>

<!-- Modal for Pay -->
<div id="modal-pay" class="modal">
    <div class="modal-content">
        <h4 class="center-align">Payment Confirmation</h4>
        <div class="divider"></div>
        <div class="row">
            <div class="col s12">
                <p class="flow-text center-align">Are you sure you want to proceed with payment for this product?</p>
            </div>
        </div>
        <div class="card-panel light-green lighten-5">
            <div class="row">
                <div class="col s6">
                    <p><strong>Product:</strong></p>
                </div>
                <div class="col s6 right-align">
                    <p id="modal-pay-product-name"></p>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <p><strong>Price:</strong></p>
                </div>
                <div class="col s6 right-align">
                    <p id="modal-pay-product-price"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="modal-close btn red">Cancel</button>
        <button id="confirm-pay" class="btn blue">Pay Now</button>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#table-product').DataTable();

        const modalBuy = M.Modal.init(document.querySelector('#modal-buy'));
        const modalPay = M.Modal.init(document.querySelector('#modal-pay'));
        // Handle row click
        $('#table-product tbody').on('click', 'tr', function() {
            if ($(this).find('td').length === 1) return; // Abaikan baris kosong
            // Ambil data dari baris yang diklik
            const productName = $(this).find('td:eq(1)').text(); // Kolom ke-2
            const stock = $(this).find('td:eq(2)').text(); // Kolom ke-3
            const price = $(this).find('td:eq(3)').text(); // Kolom ke-4
            const commission = $(this).find('td:eq(4)').text(); // Kolom ke-5

            // Isi data ke dalam div kosong
            $('#product-name').text(productName);
            $('#product-stock').text(stock);
            $('#product-price').text(price);
            $('#product-commission').text(commission);
            // Tampilkan div kosong
            $('#action').fadeIn();
        });

        // Handle button actions
        $('#btn-buy').on('click', function() {
            const productName = $('#product-name').text();
            if (!productName) {
                M.toast({html: 'Please select a product first!', classes: 'red'});
                return;
            }
            let price = $('#product-price').text();
            const stock = parseInt($('#product-stock').text()) || 0;
            if (stock <= 0) {
                M.toast({html: 'Stock is unavailable!', classes: 'red'});
                return;
            }
            $('#modal-buy-product-name').text(productName);
            $('#qty').attr('max', stock).val(1); // Reset qty ke 1
            $('#modal-buy-product-price').val(price);
            $('#modal-buy-total-product-price').text(price);
            modalBuy.open();
        });
        
        $('#qty').on('input', function() {
            const price = parseFloat($('#modal-buy-product-price').val().replace('Rp ', '').replace(/\./g, '')) || 0;
            const stock = parseInt($(this).attr('max')) || 0;
            let qty = parseInt($(this).val()) || 1;

            if (qty > stock) {
                qty = stock;
                $(this).val(stock);
                M.toast({html: 'Quantity cannot exceed stock!', classes: 'red'});
            } else if (qty < 1) {
                qty = 1;
                $(this).val(1);
                M.toast({html: 'Quantity must be at least 1!', classes: 'red'});
            }

            const totalPrice = price * qty;
            $('#modal-buy-total-product-price').text(totalPrice.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
        });


        $('#btn-pay').on('click', function() {
            const productName = $('#product-name').text();
            const price = $('#product-price').text();
            // Fill modal with product data
            $('#modal-pay-product-name').text(productName);
            $('#modal-pay-product-price').text(price);

            // Open Pay Modal
            modalPay.open();
        });

        $('#confirm-buy').on('click', function() {
            const productName = $('#modal-buy-product-name').text();
            const quantity = parseInt($('#qty').val());
            const price = parseFloat($('#modal-buy-product-price').val().replace('Rp ', '').replace(/\./g, ''));

            // Ambil product ID (jika menggunakan ID untuk ke backend)
            const productId = $('#table-product tbody tr').filter(function() {
                return $(this).find('td:eq(1)').text() === productName;
            }).data('product-id'); // Pastikan Anda memiliki `data-product-id` di elemen tr.

            if (!productId || quantity < 1 || isNaN(price)) {
                M.toast({html: 'Invalid data. Please try again!', classes: 'red'});
                return;
            }

            $.ajax({
                url: "{{route('user_area.set.order')}}",
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity,
                    _token: $('meta[name="csrf-token"]').attr('content') // Token CSRF Laravel
                },
                beforeSend: function() {
                    $('#confirm-buy').prop('disabled', true).text('Processing...');
                },
                success: function(response) {
                    M.toast({html: response.message, classes: 'green'});
                    modalBuy.close();

                    // Refresh stock display or table
                    const stockCell = $('#table-product tbody tr').filter(function() {
                        return $(this).find('td:eq(1)').text() === productName;
                    }).find('td:eq(2)');

                    const newStock = parseInt(stockCell.text()) - quantity;
                    stockCell.text(newStock);

                    $('#action').fadeOut();
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'An error occurred.';
                    M.toast({html: error, classes: 'red'});
                },
                complete: function() {
                    $('#confirm-buy').prop('disabled', false).text('Confirm');
                }
            });
        });
    });
</script>
@endpush
