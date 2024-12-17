<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" /> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .toast-success{
            background-color: #1f9e74 !important;
        }
        .toast-error{
            background-color: #BD362F !important;
        }
        .toast-info{
            background-color: #ddc642 !important;
        }
    </style>

    <!-- Toast CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    @yield('css')
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @yield('title')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if (Auth::user()->user_rol == 1)
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('merchant.index') }}">
                                    Registrar comerciante
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('merchant.how') }}">
                                    Lista de comerciantes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('payments.pending') }}">
                                    Captura de folios
                                </a>
                            </li>
                            {{-- <li class="nav-item dropdown" aria-current="page" >
                                <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                    Más
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Lista de locales</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Apercibimientos</a></li>
                                </ul>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('payment.how') }}">
                                    Pagos
                                </a>
                            </li>
                            {{-- <li class="nav-item dropdown" aria-current="page" >
                                <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                    Pagos
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('payment.how') }}">Lista de pagos</a></li>
                                </ul>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('report.index') }}">
                                    Reportes
                                </a>
                            </li>
                            <li class="nav-item dropdown" aria-current="page" >
                                <a class="nav-link dropdown-toggle" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" >
                                    Más opciones
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('inspectors.index') }}">Lista de inspectores</a></li>
                                    <li><a class="dropdown-item" href="{{ route('amounts.index') }}">Montos fiscales</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('tianguis.index') }}">Lista de tianguis</a></li>
                                    <li><a class="dropdown-item" href="{{ route('maket.index') }}">Lista de tianguis dados de baja</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('maket.index') }}">Lista de centros historicos</a></li>
                                    <li><a class="dropdown-item" href="{{ route('market.disabledList') }}">Lista de centros historicos dados de baja</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-uppercase" href="#" role="button" data-bs-toggle="dropdown" 
                                    aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>

        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"> </script>

        <!-- Toast js Library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
        <script>
            $(document).ready(function() {
                toastr.options.timeOut = 1000;
                toastr.options.closeButton = true;
                toastr.options.closeHtml = '<button><i class="icon-off"></i></button>';
                toastr.options.closeMethod = 'fadeOut';
                toastr.options.closeDuration = 300;
                toastr.options.closeEasing = 'swing';

                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @else 
                    toastr.info('Todo bien')
                @endif
            });

        </script>
        
        @yield('js')
    </div>

</body>
</html>
