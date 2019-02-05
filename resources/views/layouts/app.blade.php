<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .table th {
            border-top: none;
        }
    </style>
</head>
<body>
    <div id="app">

        @auth
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            Здравствуйте, {{ auth()->user()->name }}.<br>
                            Баланс вашего счета: ${{ price_format(auth()->user()->balance) }}
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav pr-4 ml-auto">

                            @if(request()->routeIs('admin'))
                                <a href="{{ route('index') }}">Главная</a>
                            @else
                                <a href="{{ route('admin') }}">Admin</a>
                            @endif

                        </ul>
                        <ul class="navbar-nav">
                            <form id="login-form" action="{{ route('login') }}" method="POST">
                                @csrf

                                @include('parts.user_list', [
                                    'form' => 'login-form',
                                    'default' => 'Сменить пользователя',
                                ])
                            </form>
                        </ul>
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
