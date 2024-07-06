<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/iuranwargalogo.png') }}" type="image/x-icon">

    <style>
        /* Font */
        html, body {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
        }

        /* Additional CSS for Navbar */
        .navbar {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 0.75rem 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            padding: 0;
        }

        .navbar-brand img {
            max-height: 50px;
            margin-right: 12px;
            transition: transform 0.5s;
        }

        .navbar-brand-text {
            font-weight: 700;
            font-size: 1.4rem;
            color: #333;
            transition: color 0.3s ease;
            letter-spacing: 0.5px;
        }

        @keyframes shake {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            50% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
            100% { transform: rotate(0deg); }
        }

        .navbar-brand:hover img {
            animation: shake 0.5s ease-in-out;
        }

        .navbar-brand-text:hover {
            color: #007bff;
        }

        .navbar-nav .nav-link {
            color: #000000;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border-radius: 10px;
            margin: 0 5px;
            position: relative;
            overflow: hidden;
        }

        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #007bff;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .navbar-nav .nav-link:hover::before,
        .navbar-nav .nav-link:focus::before {
            transform: translateX(0);
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            color: #007bff;
            background-color: rgba(0,123,255,0.1);
            transform: translateY(-2px);
        }

        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 0, 0, 0.5)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 10px;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            display: block;
            visibility: hidden;
        }

        .dropdown-menu.show {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .dropdown-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background-color: #007bff;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .dropdown-item:hover::before {
            transform: translateX(0);
        }

        .dropdown-item:hover {
            background-color: rgba(0,123,255,0.1);
            transform: translateX(5px);
            color: #007bff;
            border-radius: 5px;
        }

        body {
            padding-top: 70px;
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
                    <ul class="navbar-nav ms-auto">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function handleNavbarTransparency() {
            var navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255,255,255,0.95)';
                navbar.style.boxShadow = '0 2px 15px rgba(0,0,0,0.1)';
            } else {
                navbar.style.background = 'rgba(255,255,255,0.8)';
                navbar.style.boxShadow = 'none';
            }
        }

        window.addEventListener('scroll', handleNavbarTransparency);

        document.addEventListener('DOMContentLoaded', function() {
            handleNavbarTransparency();

            // Custom dropdown animation
            var dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('show.bs.dropdown', function() {
                    var menu = this.querySelector('.dropdown-menu');
                    menu.classList.add('animated-dropdown');
                });
                dropdown.addEventListener('hide.bs.dropdown', function() {
                    var menu = this.querySelector('.dropdown-menu');
                    menu.classList.remove('animated-dropdown');
                });
            });
        });

        // Ensure font is loaded
        document.fonts.ready.then(function () {
            document.body.style.visibility = 'visible';
        });
    </script>
</body>
</html>