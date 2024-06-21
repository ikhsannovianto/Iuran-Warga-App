@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Riwayat Pembayaran per Bulan</h1>
    
    <div class="text-center mb-4">
        <a href="{{ route('userpembayarans.perbulan') }}" class="btn btn-outline-primary d-inline-block me-2">
            <i class="bi bi-calendar"></i> Per Bulan
        </a>
        <a href="{{ route('userpembayarans.perorang') }}" class="btn btn-outline-primary d-inline-block me-2">
            <i class="bi bi-person"></i> Per Orang
        </a>
    </div>

    <!-- Dropdown untuk memilih bulan -->
    <form action="{{ route('userpembayarans.perbulan') }}" method="GET" class="mb-4">
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
                            <th class="text-center">Pembayaran untuk Bulan</th>
                            <th class="text-center">Jumlah Dibayar</th>
                            <th class="text-center">Tanggal Bayar</th>
                            <th class="text-center">Metode Pembayaran</th>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali ke Dashboard -->
    <div class="text-center mt-4">
        <a href="{{ route('pembayarans.create') }}" class="btn btn-success d-inline-block me-2">
            <i class="bi bi-credit-card"></i> Lakukan Pembayaran
        </a>
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary d-inline-block">
            <i class="bi bi-house-door"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
