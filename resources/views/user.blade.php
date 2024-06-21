@extends('layouts.app')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold my-4">{{ __('Informasi Pengguna') }}</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <strong>Nama:</strong>
                        <span class="ms-2">{{$datauser['name']}}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Email:</strong>
                        <span class="ms-2">{{$datauser['email']}}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Status:</strong>
                        <span class="ms-2">{{$datauser['role']}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-6 text-center">
            @if ($datauser['role'] == 'admin')
                <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Dashboard</a>
            @else
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Dashboard</a>
            @endif
        </div>
    </div>
</div>
@endsection
