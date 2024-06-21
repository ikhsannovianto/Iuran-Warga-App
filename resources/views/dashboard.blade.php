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
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-8">
            <div class="card border-0 rounded-lg p-5 shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold my-4">Dashboard Iuran Warga</h3>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">
                        <div class="col">
                            <div class="card h-100 border-0 rounded-3 shadow">
                                <div class="card-body text-center">
                                    <i class="bi bi-people fs-1 text-primary mb-3"></i>
                                    <h5 class="card-title">Manajemen RT</h5>
                                    <a href="{{ route('rts.index') }}" class="btn btn-primary">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 rounded-3 shadow">
                                <div class="card-body text-center">
                                    <i class="bi bi-person fs-1 text-primary mb-3"></i>
                                    <h5 class="card-title">Manajemen Warga</h5>
                                    <a href="{{ route('wargas.index') }}" class="btn btn-primary">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 rounded-3 shadow">
                                <div class="card-body text-center">
                                    <i class="bi bi-credit-card fs-1 text-primary mb-3"></i>
                                    <h5 class="card-title">Riwayat Tagihan Warga per Bulan</h5>
                                    <a href="{{ route('tagihans.index') }}" class="btn btn-primary">Lihat</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 rounded-3 shadow">
                                <div class="card-body text-center">
                                    <i class="bi bi-cash-coin fs-1 text-primary mb-3"></i>
                                    <h5 class="card-title">Riwayat Pembayaran</h5>
                                    <a href="{{ route('pembayarans.perbulan') }}" class="btn btn-primary">Lihat</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 rounded-3 shadow">
                                <div class="card-body text-center">
                                    <i class="bi bi-file-earmark-bar-graph fs-1 text-primary mb-3"></i>
                                    <h5 class="card-title">Laporan Pembayaran</h5>
                                    <a href="{{ route('laporan_pembayaran.index') }}" class="btn btn-primary">Lihat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
