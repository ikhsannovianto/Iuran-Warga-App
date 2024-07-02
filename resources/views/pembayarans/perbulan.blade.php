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
<div class="container">
    <h1 class="text-center mb-4">Riwayat Pembayaran per Bulan</h1>
    
    <div class="text-center mb-4">
        <a href="{{ route('pembayarans.perbulan') }}" class="btn btn-outline-primary d-inline-block me-2">
            <i class="bi bi-calendar"></i> Per Bulan
        </a>
        <a href="{{ route('pembayarans.perorang') }}" class="btn btn-outline-primary d-inline-block me-2">
            <i class="bi bi-person"></i> Per Orang
        </a>
    </div>

    <!-- Dropdown untuk memilih bulan -->
    <form action="{{ route('pembayarans.perbulan') }}" method="GET" class="mb-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <select name="bulan" class="form-select" onchange="this.form.submit()">
                    <option value="">Pilih Bulan</option>
                    @foreach(range(1, 12) as $bulan)
                        <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
    
    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Warga</th>
                            <th class="text-center">RT</th>
                            <th class="text-center">Tagihan</th>
                            <th class="text-center">Untuk Bulan</th>
                            <th class="text-center">Jumlah Bayar</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Metode Pembayaran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayarans as $pembayaran)
                        <tr>
                            <td class="text-center">{{ $pembayaran->warga->nama }}</td>
                            <td class="text-center">{{ $pembayaran->warga->rt->nama_rt }}</td>
                            <td class="text-center">
                                @if($pembayaran->warga->tagihans->isNotEmpty())
                                    {{ number_format($pembayaran->warga->tagihans->first()->jumlah_tagihan, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">{{ DateTime::createFromFormat('!m', $pembayaran->bulan)->format('F') }}</td>
                            <td class="text-center">{{ number_format($pembayaran->jumlah_dibayar, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $pembayaran->tanggal_bayar }}</td>
                            <td class="text-center">{{ $pembayaran->metode_pembayaran }}</td>
                            <td class="text-center">
                                <!-- Tombol Edit -->
                                <a href="{{ route('pembayarans.edit', $pembayaran->id) }}" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil-square"></i> Edit</a>
                                <!-- Tombol Delete -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal{{ $pembayaran->id }}">
                                    <i class="bi bi-trash3"></i> Hapus
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="deleteConfirmationModal{{ $pembayaran->id }}" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel{{ $pembayaran->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content shadow">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteConfirmationModalLabel{{ $pembayaran->id }}">Konfirmasi Penghapusan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data pembayaran ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('pembayarans.destroy', $pembayaran->id) }}" method="POST" class="d-inline">
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

    <!-- Tombol Lakukan Pembayaran dan Kembali ke Dashboard -->
    <div class="text-center mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-primary d-inline-block">
            <i class="bi bi-house-door"></i> Kembali ke Dashboard
        </a>
        <a href="{{ route('pembayarans.export', ['bulan' => request('bulan')]) }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Download Excel
        </a>
    </div>
</div>
@endsection
