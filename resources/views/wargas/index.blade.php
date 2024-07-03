@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Manajemen Warga</h1>
    @if (session('success'))
        <div class="d-flex justify-content-center my-3">
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm rounded-pill mb-5" role="alert" style="max-width: 600px; background-color: #d4edda; color: #155724;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <script>
            setTimeout(function() {
                var alert = document.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }
            }, 5000);
        </script>
    @endif
    <div class="row justify-content-between mb-3">
        <div class="col-md-6">
            <a href="{{ route('wargas.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle-dotted"></i> Tambah Warga</a>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('wargas.export') }}" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Download Excel</a>
            <a href="{{ route('wargas.export.pdf') }}" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
        </div>
    </div>
    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">No Telp</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">RT</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wargas as $warga)
                        <tr>
                            <td class="text-center">{{ $warga->nama }}</td>
                            <td class="text-center">{{ $warga->alamat }}</td>
                            <td class="text-center">{{ $warga->no_telp }}</td>
                            <td class="text-center">{{ $warga->email }}</td>
                            <td class="text-center">{{ $warga->rt ? $warga->rt->nama_rt : 'Tidak ada RT' }}</td>
                            <td class="text-center">
                                <a href="{{ route('wargas.edit', $warga->id) }}" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil-square"></i> Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal{{ $warga->id }}">
                                    <i class="bi bi-trash3"></i> Hapus
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="deleteConfirmationModal{{ $warga->id }}" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel{{ $warga->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content shadow">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteConfirmationModalLabel{{ $warga->id }}">Konfirmasi Penghapusan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data warga ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('wargas.destroy', $warga->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
                <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Dashboard</a>
    </div>
</div>
@endsection
