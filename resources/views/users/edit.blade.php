@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold my-4">{{ __('Edit Data Pengguna') }}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('update_datauser') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nama') }}</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">{{ __('Status') }}</label>
                            <input type="text" id="role" name="role" class="form-control" value="{{ $user->role }}" readonly>
                        </div>

                        <div class="mb-0 text-center">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3 text-center">
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        @endif
                </div>
        </div>
    </div>
</div>
@endsection
