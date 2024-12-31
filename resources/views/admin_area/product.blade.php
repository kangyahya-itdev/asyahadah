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
                Product
                <span class='right'><a class='btn' href="{{route('admin.product.add')}}"><i class='material-icons'>add</i> </a></span>
              </div>
              <table width=100% id='product-table' class='table stripped'>
                <thead>
                  <tr>
                    <th width='2%' class='center'>
                      No
                    </th>
                    <th  class='center'>
                      Product
                    </th>
                    <th class='center'>
                      Harga
                    </th>
                    <th class='center'>
                      Stok
                    </th>
                    <th class='center' width='20%'>
                      Aksi
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($product as $prod)
                  <tr>
                    <td class='center'>{{$loop->iteration}}</td>
                    <td>{{$prod->name}}</td>
                    <td class ='right'>{{$prod->price}}</td>
                    <td class="center">{{$prod->stock}}</td>
                    <td class='right'>
                      <a href="{{route('admin.product.add', $prod->id)}}" class='btn green'>Edit</a>
                      <button type="button" class="btn red btn-delete" data-id="{{ $prod->id }}">Hapus</button>
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
    $('#product-table').DataTable({
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
  // Sweetalert for delete

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
                        url: `/admin/product/delete/${id}`,
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