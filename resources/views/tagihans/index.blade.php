@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Riwayat Tagihan</h1>

    <!-- Alert Success -->
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

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Dashboard</a>

        <form action="{{ route('tagihans.index') }}" method="GET" class="d-inline">
            <select name="bulan" class="form-select" onchange="this.form.submit()">
                <option value="">Pilih Bulan</option>
                @foreach(range(1, 12) as $bulan)
                    <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}
                    </option>
                @endforeach
            </select>
        </form>
        
        <a href="{{ route('tagihans.export') }}" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Ekspor ke Excel</a>
        <a href="{{ route('tagihans.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle-dotted"></i> Tambah Tagihan</a>
    </div>

    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Nama Warga</th>
                            <th class="text-center">RT</th>
                            <th class="text-center">Tagihan untuk Bulan</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Jumlah Tagihan</th>
                            <th class="text-center">Total Terbayar</th>
                            <th class="text-center">Belum Terbayar</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporan as $data)
                        <tr>
                            <td class="text-center">{{ $data['warga'] }}</td>
                            <td class="text-center">{{ $data['rt'] }}</td>
                            <td class="text-center">{{ date('F', mktime(0, 0, 0, $data['tagihan']->bulan, 1)) }}</td>
                            <td class="text-center">{{ $data['tagihan']->tahun }}</td>
                            <td class="text-center">Rp {{ number_format($data['jumlah_tagihan'], 0, ',', '.') }}</td>
                            <td class="text-center">Rp {{ number_format($data['total_terbayar'], 0, ',', '.') }}</td>
                            <td class="text-center">Rp {{ number_format($data['belum_terbayar'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ ucwords(strtolower($data['status'])) }}</td>
                            <td class="text-center">
                                <a href="{{ route('tagihans.edit', $data['tagihan']->id) }}" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil-square"></i> Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal{{ $data['tagihan']->id }}">
                                    <i class="bi bi-trash3"></i> Hapus
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="deleteConfirmationModal{{ $data['tagihan']->id }}" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel{{ $data['tagihan']->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content shadow">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteConfirmationModalLabel{{ $data['tagihan']->id }}">Konfirmasi Penghapusan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data tagihan ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('tagihans.destroy', $data['tagihan']->id) }}" method="POST" class="d-inline">
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
        </div>
    </div>
</div>
@endsection