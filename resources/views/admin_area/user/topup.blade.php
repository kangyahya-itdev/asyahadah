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
                Top Up Users
              </div>
              <table width=100% id='topups-table' class='table stripped'>
                <thead>
                  <tr>
                    <th width='2%' class='center'>
                      No
                    </th>
                    <th  class='center'>
                      Name
                    </th>
                    <th class='center'>
                      Jumlah
                    </th>
                    <th class='center'>
                      Bukti
                    </th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class='center'>
                        Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                @foreach($topups as $item)
                <tr>
                    <td class='center'>{{$loop->iteration}}</td>
                    <td>{{$item->user->name}}</td>
                    <td>{{$item->amount}}</td>
                    <td>
                    <img src="{{ asset('storage/app/public/' . $item->proof_image) }}" 
                        alt="{{ $item->user->name }}" 
                        width="100px" height="100px" 
                        style="cursor: pointer;" 
                        class="materialboxed" 
                        data-target="modal{{$item->id}}">
                        <div id="modal{{$item->id}}" class="modal">
                            <div class="modal-content">
                                <h5>Bukti Transfer: {{ $item->user->name }}</h5>
                                <div class="center-align">
                                    <!-- Gambar Full Size -->
                                    <img src="{{ url('storage/app/public/'.$item->proof_image) }}" 
                                        alt="{{ $item->user->name }}" 
                                        class="responsive-img" 
                                        style="max-height: 80vh;">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!-- Tombol Download -->
                                <a href="{{ url('public/'.$item->proof_image) }}" 
                                download 
                                class="waves-effect waves-light btn blue">Download</a>
                                <a href="#!" class="modal-close waves-effect waves-light btn grey">Close</a>
                            </div>
                        </div>
                    </td>
                    <td class='center'>@if($item->status === 'pending')
                        <!-- Tombol Confirm -->
                        <a href="{{ route('admin.topups.confirm', ['id' => $item->id]) }}" class="btn green">
                            Confirm
                        </a>
                        <!-- Tombol Reject -->
                        <a href="{{ route('admin.topups.reject', ['id' => $item->id]) }}" class="btn red">
                            Reject
                        </a>
                    @else
                        <!-- Jika status bukan pending -->
                        <span class="badge {{ $item->status === 'confirmed' ? 'green' : 'red' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    @endif</td>
                    <td class='center'>{{$item->created_at}}</td>
                    <td>
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
    $('#topups-table').DataTable({
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
                          url: `topups/destroy/${id}`,
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

  document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Modal
        var modals = document.querySelectorAll('.modal');
        M.Modal.init(modals);
        var materialboxed = document.querySelectorAll('.materialboxed');
        M.Materialbox.init(materialboxed);
    });
  </script>
  @endpush