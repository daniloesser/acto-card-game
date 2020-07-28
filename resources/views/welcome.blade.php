<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
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
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <main class="py-4">
            <!--News card-->
            <div class="card border-primary mb-4 text-center hoverable">
                <div class="card-body">
                    <!--Grid row-->
                    <div class="row">

                        <!--Grid column-->
                        <div class="col-md-4 offset-md-1 mx-3 my-3">
                            <!--Featured image-->
                            <div class="view overlay hm-white-slight" style="padding-top: 50px;">
                                <img
                                    src="https://mma.prnewswire.com/media/996465/ACTO_Technologies__Inc__ACTO_and_Teleflex_Collaboration_Leads_to.jpg"
                                    class="img-fluid" alt="ACTO LOGO">
                                <a>
                                    <div class="mask"></div>
                                </a>
                            </div>
                        </div>
                        <!--Grid column-->

                        <!--Grid column-->
                        <div class="col-md-7 text-left ml-3 mt-3">
                            <!--Excerpt-->
                            <a href="" class="green-text">
                                <h6 class="font-bold pb-1"><i class="fa fa-desktop"></i> ACTO</h6>
                            </a>
                            <h4 class="mb-4"><strong>Take Home Assignment</strong></h4>
                            <p> A Simple card game created with great technologies:</p>
                            <ul>
                                <li><i>Laradock</i></li>
                                <li><i>Laravel</i></li>
                                <li><i>Passport</i></li>
                                <li><i>thePHPLeague/fractal</i></li>
                                <li><i>VueJs</i></li>
                            </ul>
                            <p> by <a><strong>Danilo Esser</strong></a>, <i>July 2020</i><br></p>
                            <a class="btn btn-lg btn-success offset-3" href="{{ route('login') }}"> Start playing</a>
                        </div>
                        <!--Grid column-->
                    </div>
                    <!--Grid row-->
                </div>
            </div>
            <!--News card-->
        </main>
    </div>
</div>
</body>
</html>
