<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/iuranwargalogo.png') }}" type="image/x-icon">

    <style>
        /* Font */
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');

        * {
            font-family: DM-Sans;
        }

        /* Additional CSS for Navbar */
        .navbar {
            background: linear-gradient(180deg, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0.5) 50%, rgba(255,255,255,0) 100%); /* Gradient background */
            backdrop-filter: blur(10px); /* Blur effect */
            transition: background 0.3s ease; /* Smooth transition effect */
            box-shadow: none; /* No Shadow */
        }

        .navbar-brand img {
            max-height: 80px; /* Logo height */
            margin-right: 0px; /* Margin to separate image from text */
            transition: transform 0.5s; /* Smooth transition effect for transform property */
        }

        .navbar-brand-text {
            font-weight: bold; /* Font weight */
            transition: transform 0.5s; /* Smooth transition effect for transform property */
        }

        .navbar-brand:hover img,
        .navbar-brand-text:hover {
            animation: shake 1s ease; /* Shake animation on hover */
        }

        /* Shake Animation Keyframes */
        @keyframes shake {
            0% { transform: translateX(0); }
            10%, 90% { transform: translateX(-5px); }
            20%, 80% { transform: translateX(5px); }
            30%, 50%, 70% { transform: translateX(-5px); }
            40%, 60% { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }

        .navbar-nav .nav-link {
            color: #333333; /* Text color */
            font-weight: bold; /* Font weight */
        }

        .navbar-nav .nav-link:hover {
            color: #007bff; /* Text color on hover */
        }

        .navbar-toggler {
            border: none; /* Remove border */
            outline: none; /* Remove outline */
        }

        .navbar-toggler-icon {
            background-color: #333333; /* Toggler icon color */
        }

        .navbar-toggler:focus .navbar-toggler-icon {
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); /* Focus outline */
        }

        /* Additional CSS for Navbar fixed-top */
        body {
            padding-top: 56px; /* Height of the fixed navbar */
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/iuranwargalogo.png') }}" alt="{{ config('app.name', 'Laravel') }}">
                    <span class="navbar-brand-text">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('/user') }}">Akun</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    // Function to handle navbar transparency on scroll
    function handleNavbarTransparency() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.style.background = 'linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 50%, rgba(255,255,255,0.8) 100%)';
        } else {
            navbar.style.background = 'linear-gradient(180deg, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0.5) 50%, rgba(255,255,255,0) 100%)';
        }
    }

    // Event listener for scroll event
    window.addEventListener('scroll', handleNavbarTransparency);

    // Call handleNavbarTransparency() when the document is loaded
    document.addEventListener('DOMContentLoaded', function() {
        handleNavbarTransparency();
    });
</script>

</body>
</html>
