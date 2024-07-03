@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="d-flex justify-content-center my-3">
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm rounded-pill mb-5" role="alert" style="max-width: 600px; background-color: #d4edda; color: #155724;">
            <i class="bi bi-check-circle-fill fs-4 me-2 text-success"></i>
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

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold my-4">{{ __('Informasi Pengguna') }}</h3>
                </div>
                @if(isset($datauser))
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <h5>{{ $judul }}</h5>
                    </div>
                    <div class="mb-4">
                        <strong>Nama:</strong>
                        <span class="ms-2">{{ $datauser['name'] }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Email:</strong>
                        <span class="ms-2">{{ $datauser['email'] }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Status:</strong>
                        <span class="ms-2">{{ $datauser['role'] }}</span>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('edit_datauser') }}" class="btn btn-warning me-2"><i class="bi bi-pencil-square"></i> Edit</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                        @if($datauser['role'] == 'admin')
                            <a href="{{ route('listuser') }}" class="btn btn-info ms-2"><i class="bi bi-list"></i> Daftar Pengguna</a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @if(isset($datauser))
    <div class="row justify-content-center mt-4">
        <div class="col-md-6 text-center">
            @if ($datauser['role'] == 'admin')
                <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Dashboard</a>
            @else
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Dashboard</a>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus akun?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('delete_datauser') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya. Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(function () {
                    alert.remove();
                }, 500);
            }
        }, 5000);
    });
</script>

@endsection
