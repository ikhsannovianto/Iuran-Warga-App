@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-lg-6 col-md-8 mb-4">
            <div class="card border-0 rounded-lg p-4 animate__animated animate__fadeIn shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold my-4">Selamat Datang di Aplikasi <br>Iuran Warga</h3>
                </div>
                <div class="card-body">
                    <p class="lead text-center mb-4">Aplikasi ini membantu Anda dalam mengelola iuran warga dengan lebih efisien dan teratur.</p>
                    
                    <!-- ADD HERE -->
                    @if (Auth::check())
                        @if (Auth::user()->role == 'admin')
                            <div class="text-center mt-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                    <i class="bi bi-house-door"></i> Menuju Dashboard
                                </a>
                            </div>
                        @else
                            <div class="text-center mt-4">
                                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                                    <i class="bi bi-house-door"></i> Menuju Dashboard
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right"></i> Login untuk Mengakses Dashboard
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-4 d-none d-md-block">
            <img src="{{ asset('images/bg-illustration.png') }}" alt="Illustration" class="img-fluid rounded hover-animate">
        </div>
    </div>
</div>

<!-- Add animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<!-- Custom CSS for hover effects -->
<style>
    .hover-animate {
        transition: transform 0.3s ease;
    }

    .hover-animate:hover {
        transform: scale(1.05);
    }

    .card {
        background-color: #f8f9fa; /* Background color */
    }

    .card-header {
        border: none; /* Remove border */
    }

    .card-header h3 {
        font-size: 24px; /* Font size */
    }

    .card-body {
        padding: 1.5rem; /* Padding */
    }

    .lead {
        color: #6c757d; /* Text color */
    }

    /* Footer style */
    footer {
        background-color: transparent; /* Background color */
        color: #adb5bd; /* Text color */
        text-align: center; /* Center align text */
        padding: 20px 0; /* Padding */
        font-size: 14px; /* Font size */
    }
</style>

<footer>
    &copy; {{ date('Y') }} Kelompok 7. All rights reserved.
</footer>
@endsection
