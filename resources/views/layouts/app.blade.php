<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ auth()->user() ? auth()->user()->api_token : '' }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app" v-cloak>
        <nav class="navbar navbar-expand-md navbar-light bg-light rounded">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @include('layouts.nav')
                </ul>

                <ul class="navbar-nav ml-auto">
                    @guest
                        <li><a class="nav-link" href="{{ route('login') }}">{{ __('login') }}</a></li>
                    @else
                        <!-- <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="text" placeholder="{{ __('search') }}">
                        </form> -->

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <main class="py-3">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>

        <footer class="container-fluid footer" style="text-align: center;">
            <div class="border-top pt-2 pb-2">
                &copy; 2018 {{ config('app.name', 'Laravel') }}
            </div>
        </footer>
    </div>
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
