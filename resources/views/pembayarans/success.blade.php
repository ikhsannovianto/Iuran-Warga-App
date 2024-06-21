@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-success text-white text-center">
                    <h3 class="fw-bold my-4">{{ __('Pembayaran Berhasil') }}</h3>
                </div>

                <div class="card-body">
                    <div class="alert alert-success text-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ __('Pembayaran telah berhasil diproses.') }}
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('userpembayarans.perbulan') }}" class="btn btn-primary d-inline-block me-2">
                            <i class="bi bi-receipt"></i> {{ __('Lihat Riwayat Pembayaran') }}
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary d-inline-block">
                            <i class="bi bi-house-door"></i> {{ __('Kembali ke Dashboard') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
