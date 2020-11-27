<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cymatrax') }}</title>

    <!-- Scripts -->

    <script>
        var APP_URL = '{{URL::to("/")}}';
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            var userSelection = document.getElementsByClassName('getdur');

            for (var i = 0; i < userSelection.length; i++) {
                (userSelection[i]).click();
            }

            var total_duration = 0;

            setTimeout(() => {
                var total = 0;
                for (var i = 0; i < userSelection.length; i++) {
                    total = $("#duration_in_sec" + i).val();
                    total_duration = total_duration + parseFloat(total);
                }
                var minutes = Math.floor(total_duration / 60);
                var seconds = Math.floor(total_duration % 60);

                var per_sec_cost = 1 / 60;

                total_cost = per_sec_cost * total_duration;

                $("#total-duration").html(minutes + ' min ' + seconds + ' sec')
                $("#total-cost").html(total_cost.toFixed(2) + '$')

            }, 1000);

        });
    </script>

    <script src="{{asset('assets/dropzone/dist/dropzone.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/dropzone/dist/dropzone.css')}}"/>


    <script src="{{ asset('public/js/app.js') }}" defer></script>
    <script src="{{ asset('public/js/component.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">


    <!-- sweet aleart -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <!-- Include a polyfill for ES6 Promises (optional) for IE11 -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>


</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Cymatrax') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ __('Service') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}"> {{ __('Register') }}</a>
                            </li>
                        @endif

                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ __('Service') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href='{{URL::to("file/fetch")}}'>{{ __('My Account') }}</a>
                        </li>
                        <li class="nav-item">
                        <!-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                            </a> -->

                            <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"> -->
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Sign Out') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>


                            <!-- </div> -->
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
</body>
</html>
