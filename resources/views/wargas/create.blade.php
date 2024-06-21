@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold my-4">{{ __('Tambah Warga Baru') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('wargas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">{{ __('Nama') }}</label>
                            <input type="text" class="form-control" name="nama" id="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">{{ __('Alamat') }}</label>
                            <input type="text" class="form-control" name="alamat" id="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">{{ __('Nomor Telepon') }}</label>
                            <input type="text" class="form-control" name="no_telp" id="no_telp">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="id_rt" class="form-label">{{ __('RT') }}</label>
                            <select class="form-control" name="id_rt" id="id_rt" required>
                                @foreach($rts as $rt)
                                    <option value="{{ $rt->id }}">{{ $rt->nama_rt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-0 text-center">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Tambah') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3 text-center">
                <a href="{{ route('wargas.index') }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection