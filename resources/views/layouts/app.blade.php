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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS for TNB Theme -->
    <style>
        body {
            background-color: white;
            color: #f5f5f5; /* Light text color */
        }
        .card {
            background-color: #23272a; /* Slightly lighter dark color for cards */
        }
        .btn-primary {
            background-color: #007bff; /* Blue button color */
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-color: #004085;
        }
        .btn-danger {
            background-color: #d9534f; /* Red button color */
            border-color: #d43f3a;
        }
        .btn-danger:hover {
            background-color: #c9302c; /* Darker red on hover */
            border-color: #ac2925;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #292b2c; /* Alternating row color */
        }
        .nav-link {
            color: #007bff; /* Blue color for nav links */
        }
        .nav-link.active {
            color: #f5f5f5; /* Light color when selected */
        }
        .nav-link:hover {
            color: #d9534f; /* Red color on hover */
        }
        .navbar {
            background-color: floralwhite; /* Dark navbar background */
        }
        .navbar-brand {
            color: #d9534f; /* Red brand color */
        }
        .navbar-toggler {
            border-color: #007bff; /* Blue color for toggler */
        }

        .badge-available {
            background-color: #28a745; /* Green */
            color: white;
        }

        .badge-in-use {
            background-color: #ffc107; /* Yellow */
            color: black;
        }

        .badge-damage {
            background-color: #dc3545; /* Red */
            color: white;
        }

        .badge-secondary {
            background-color: #6c757d; /* Grey */
            color: white;
        }

    </style>
</head>
<body>
<div id="app">
    @auth
        <nav class="navbar navbar-expand-lg sticky-top" data-bs-theme="light">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    <img src="{{ asset('images/energyLogo.png') }}" alt="Logo" style="height: 30px; margin-right: 10px;">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="nav nav-underline">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="{{ route('asset.index') }}" role="button" aria-expanded="false">Assets</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('asset.index') }}">View All Assets</a></li>
                                <li><a class="dropdown-item" href="{{ route('requests.create') }}">Request Assets</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="{{ route('transactions.index') }}" role="button" aria-expanded="false">Transaction</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('transactions.index') }}">View History</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="{{ route('requests.index') }}" role="button" aria-expanded="false">Request</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('requests.index') }}">View All Requests</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="{{ route('category.index') }}" role="button" aria-expanded="false">Category</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('category.index') }}">View All Category</a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav">
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
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> <!-- Font Awesome logout icon -->
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
            </div>
        </nav>
    @endauth
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
