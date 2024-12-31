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
                Users
              </div>
              <table width=100% id='users-table' class='table stripped'>
                <thead>
                  <tr>
                    <th width='2%' class='center'>
                      No
                    </th>
                    <th  class='center'>
                      Name
                    </th>
                    <th class='center'>
                      Handphone
                    </th>
                    <th class='center'>
                      Email
                    </th>
                    <th>Role</th>
                    <th>
                        Referral Code
                    </th>
                    <th class='center'>
                        Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                @foreach($users as $item)
                <tr>
                    <td class='center'>{{$loop->iteration}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->handphone}}</td>
                    <td>{{$item->email}}</td>
                    <td class='center'>{{strtoupper($item->role)}}</td>
                    <td>{{$item->referral_code}}</td>
                    <td>
                    <a href="{{route('admin.users', ['id' => $item->id])}}" class='btn green'>Edit</a>
                    <button type="button" class="btn red btn-delete" data-id="{{ $item->id }}">Hapus</button>
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
    $('#users-table').DataTable({
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