@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Manajemen Pengguna</h1>

    @if (session('success'))
        <div class="d-flex justify-content-center my-3">
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm rounded-pill" role="alert" style="max-width: 600px; background-color: #d4edda; color: #155724;">
                <i class="bi bi-check-circle-fill me-2" style="font-size: 1.5rem;"></i>
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
            <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Dashboard</a>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('create_listuser') }}" class="btn btn-primary"><i class="bi bi-plus-circle-dotted"></i> Tambah Pengguna</a>
            <div class="btn-group ms-2">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-arrow-up"></i> Import
                </button>
                <div class="dropdown-menu p-3">
                    <form action="{{ route('import.users') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-file-earmark-arrow-up"></i> Import</button>
                    </form>
                </div>
            </div>
            <a href="{{ route('export.users') }}" class="btn btn-success ms-2"><i class="bi bi-file-earmark-excel"></i> Download Excel</a>
        </div>
    </div>

    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Password (Hash)</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-light' : '' }}">
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">{{ Str::limit($user->password, 10, '...') }}</td>
                            <td class="text-center">{{ $user->role }}</td>
                            <td class="text-center">
                                <a href="{{ route('edit_datauser', $user->id) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal{{ $user->id }}">
                                    <i class="bi bi-trash3"></i> Hapus
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="deleteConfirmationModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content shadow">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteConfirmationModalLabel{{ $user->id }}">Konfirmasi Penghapusan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus pengguna ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('deletelist_datauser', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Ya. Hapus</button>
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
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
