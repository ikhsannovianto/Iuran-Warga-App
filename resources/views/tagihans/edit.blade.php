@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold my-4">{{ __('Edit Tagihan') }}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('tagihans.update', $tagihan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id_warga" class="form-label">{{ __('Nama Warga') }}</label>
                            <select name="id_warga" id="id_warga" class="form-control" required>
                                @foreach($wargas as $warga)
                                    <option value="{{ $warga->id }}" {{ $warga->id == $tagihan->id_warga ? 'selected' : '' }}>
                                        {{ $warga->nama }} - {{ $warga->rt->nama_rt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bulan" class="form-label">{{ __('Bulan') }}</label>
                            <select name="bulan" id="bulan" class="form-control" required>
                                @foreach(range(1, 12) as $bulan)
                                    <option value="{{ $bulan }}" {{ $bulan == $tagihan->bulan ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tahun" class="form-label">{{ __('Tahun') }}</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" value="{{ $tagihan->tahun }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_tagihan" class="form-label">{{ __('Jumlah Tagihan') }}</label>
                            <input type="number" name="jumlah_tagihan" id="jumlah_tagihan" class="form-control" value="{{ $tagihan->jumlah_tagihan }}" required>
                        </div>

                        <div class="mb-0 text-center">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Simpan') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3 text-center">
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('tagihans.index') }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        @else
                            <a href="{{ route('usertagihans.index') }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        @endif
                </div>
        </div>
    </div>
</div>
@endsection
