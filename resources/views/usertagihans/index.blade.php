@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Riwayat Tagihan</h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Dashboard</a>

        <form action="{{ route('usertagihans.index') }}" method="GET" class="d-inline">
            <select name="bulan" class="form-select" onchange="this.form.submit()">
                <option value="">Pilih Bulan</option>
                @foreach(range(1, 12) as $bulan)
                    <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
