@extends('layouts.admin')
@section('content')
<main>
    <div class="container">
      <div class="row">
        <!-- DASHBOARD -->
        <div class="col s12 l12 dashboard">
          <div class="card">
            <div class="card-content">
              <div class="card-title">
                Orders
              </div>
              <table width=100% id='order-table' class='table stripped'>
                <thead>
                  <tr>
                    <th width='2%' class='center'>
                      No
                    </th>
                    <th  class='center'>
                      Product
                    </th>
                    <th class='center'>
                      Quantity
                    </th>
                    <th class='center'>
                      Price
                    </th>
                    <th class='center'>
                      Total Price
                    </th>
                    <th class='center'>
                      Buyer Commission
                    </th>
                    <th class='center'>
                      Referral Commission
                    </th>
                    <th class='center'>
                      Status
                    </th>
                    <th class='center'>
                      Date
                    </th>
                    <th class='center'>
                      Buyer
                    </th>
                  </tr>
                </thead>
                <tbody>
                @foreach($orders as $ord)
                @foreach($ord->orderItems as $item)
                <tr>
                    <td class='center'>{{$loop->parent->iteration}}</td>
                    <td>{{$item->product->name}}</td>
                    <td class='center'>{{$item->quantity}}</td>
                    <td class="center">{{$item->product->formatted_price}}</td>
                    <td class="center">RP. {{ number_format($ord->total_price, 0, ',', '.') }}</td>
                    <td class="center">{{$item->product->commissionProducts->personal_commission}}</td>
                    <td class="center">{{$item->product->commissionProducts->referral_commission}}</td>
                    <td class="center">{{$ord->status}}</td>
                    <td class="center">{{ $ord->created_at->translatedFormat('l, d F Y') }}</td>
                    <td class="center">{{$ord->user->name}}</td>
                </tr>
                @endforeach
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- END_DASHBOARD -->
      </div>
    </div>
  </main>
  @endsection
  @push('script')
  <script>
    $(document).ready(function() {
    $('#order-table').DataTable({
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