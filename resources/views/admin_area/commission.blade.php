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
                Commission
                <span class='right'><a class='btn' href="{{route('admin.commissions.insert')}}"><i class='material-icons'>add</i> </a></span>
              </div>
              <table width=100% id='commission-table' class='table stripped center'>
                <thead>
                  <tr class='center'>
                    <th width='2%' class='center'>
                      No
                    </th>
                    <th  class='center'>
                      Product
                    </th>
                    <th class='center'>
                      Price
                    </th>
                    <th class='center'>
                      Self Commission
                    </th>
                    <th class='center'>
                      Referral Commission
                    </th>
                    <th class='center' width='20%'>
                      Aksi
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($commissions as $com)
                  <tr>
                    <td class='center'>{{$loop->iteration}}</td>
                    <td>{{ $com->product ? $com->product->name : 'Produk tidak tersedia' }} </td>
                    <td>Rp. {{ $com->product ? number_format($com->product->price, 0) : 0 }} </td>
                    <td class ='right'>Rp. {{ $com->product ? number_format($com->product->price * $com->personal_commission, 0) : 0 }} ({{ $com->personal_commission }}%)</td>
                    <td class="center"> Rp. {{ $com->product ? number_format($com->product->price * $com->referral_commission, 0) : 0 }} ({{ $com->referral_commission }}%)</td>
                    <td class='right'>
                      <a href="{{route('admin.commissions.insert', ['id' => $com->id])}}" class='btn green'>Edit</a>
                      <button type="button" class="btn red btn-delete" data-id="{{ $com->id }}">Hapus</button>
                    </td>
                  </tr>
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
    $('#commission-table').DataTable({
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
  $('.btn-delete').on('click', function(){
    const id = $(this).data('id');
    Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform AJAX request to delete
                    $.ajax({
                          url: `commissions/destroy/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire(
                                'Berhasil!',
                                'Data berhasil dihapus.',
                                'success'
                            ).then(() => {
                                // Reload the page after successful delete
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        }
                    });
                }
            });
  });
  </script>
  @endpush