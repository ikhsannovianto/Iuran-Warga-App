@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">{{ __('Laporan Pembayaran') }}</h1>

    <!-- Button Kembali ke Dashboard -->
    <div class="text-center mb-5">
        @if (Auth::user()->role == 'admin')
            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                <i class="bi bi-house-door"></i> {{ __('Kembali ke Dashboard') }}
            </a>
        @else
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                <i class="bi bi-house-door"></i> {{ __('Kembali ke Dashboard') }}
            </a>
        @endif
    </div>

    <div class="text-center mb-5">
        <a href="{{ route('laporan_pembayaran.export') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> {{ __('Export to Excel') }}
        </a>
        <a href="{{ route('laporan.pembayaran.export.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> {{ __('Download PDF') }}
        </a>
    </div>

    <div class="row mb-4 g-4">
        <!-- Card Total Pendapatan -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-cash-coin fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">{{ __('Total Pendapatan') }}</h5>
                    <h2 class="text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <!-- Card Jumlah Pembayaran per Metode -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-wallet2 fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">{{ __('Jumlah Pendapatan per Metode') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Metode Pembayaran') }}</th>
                                    <th>{{ __('Total Pembayaran (Rp)') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembayaranPerMetode as $data)
                                    <tr>
                                        <td>{{ ucfirst($data->metode_pembayaran) }}</td>
                                        <td>{{ number_format($data->total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 g-4">
        <!-- Card Total Pendapatan per Bulan -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar2-week fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">{{ __('Total Pendapatan per Bulan') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Bulan') }}</th>
                                    <th>{{ __('Total Pendapatan (Rp)') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendapatanPerBulan as $data)
                                    <tr>
                                        <td>{{ $data['nama_bulan'] }}</td>
                                        <td>{{ number_format($data['total'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Pembayaran per RT -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-house-door fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">{{ __('Total Pendapatan per RT') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('RT') }}</th>
                                    <th>{{ __('Total Pendapatan (Rp)') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($totalPembayaranPerRT as $data)
                                    <tr>
                                        <td>{{ $data->nama_rt }}</td>
                                        <td>{{ number_format($data->total_pembayaran, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
