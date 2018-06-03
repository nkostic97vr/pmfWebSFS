<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="author" content="Nikola Kostić">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="{{ asset("favicon.ico") }}">

        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/fontawesome-all.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @yield("styles")

        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>

        <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>

        @yield('scripts')

        @if (Session::has('message'))
            <script>
                $(function() {
                    toastr.options.closeButton = true;
                    const type = "{{ Session::get('level') }}";
                    const message = "{{ Session::get('message') }}";
                    switch (type) {
                        case 'info': toastr.info(message); break;
                        case 'warning': toastr.warning(message); break;
                        case 'success': toastr.success(message); break;
                        case 'error': toastr.error(message); break;
                    }
                });
            </script>
        @endif

    </head>

    <body>
        <div id="top"></div>

        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <li><a class="nav-link" href="{{ route('front.users.index') }}">Korisnici</a></li>
                            @guest
                                <!-- Authentication Links -->
                                @yield('nav-guest')
                                <li><a class="nav-link" href="{{ route('login') }}">{{ __('auth.login') }}</a></li>
                                <li><a class="nav-link" href="{{ route('register') }}">{{ __('auth.register') }}</a></li>
                            @else
                                @yield('nav-auth')
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name ?? Auth::user()->username }} <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('front.users.show', ['profile' => Auth::user()->username]) }}">
                                            <i class="fas fa-user"></i> Profil
                                        </a>
                                        <a class="dropdown-item" href="#" id="btn-messages" data-newmessages="0">
                                            <i class="fas fa-envelope"></i> Nema novih poruka
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> {{ __('auth.logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4 main-container">
                @yield('content')
            </main>

        </div>

    </body>

</html>
