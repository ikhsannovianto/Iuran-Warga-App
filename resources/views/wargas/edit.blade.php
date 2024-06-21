@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold my-4">{{ __('Edit Data Warga') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('wargas.update', $warga->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama" class="form-label">{{ __('Nama') }}</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="{{ $warga->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">{{ __('Alamat') }}</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" value="{{ $warga->alamat }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">{{ __('No Telp') }}</label>
                            <input type="text" id="no_telp" name="no_telp" class="form-control" value="{{ $warga->no_telp }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $warga->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="id_rt" class="form-label">{{ __('RT') }}</label>
                            <select class="form-control" name="id_rt" id="id_rt" required>
                                @foreach($rts as $rt)
                                    <option value="{{ $rt->id }}" {{ $warga->id_rt == $rt->id ? 'selected' : '' }}>{{ $rt->nama_rt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-0 text-center">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Update') }}</button>
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
