<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

        {{-- Configured Stylesheets --}}
        @include('adminlte::plugins', ['type' => 'css'])

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(app()->version() >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    <style>
        html, body {
            height: 100%;
            width: 100%;
            /* background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;*/
        }
        body {
            height: 100%;
            background-image: url({{asset('storage/img/SIVOC.jpeg')}});
            
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            
        }
    
        */
        
    </style>

    {{-- Favicon --}}
    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

</head>

<body>

    <div class="container-fluid">
        
        <div>
            @if (Route::has('login'))
                <div  style="margin-left: 95%; margin-top: 10px; ">
                    @auth
                        <a href="{{ url('/home') }}" style="color: white; font-size:15px;">Home</a>
                    @else
                    <a href="{{ route('login') }}" style="color: white; font-size:15px;"><button class="btn btn-primary">Login</button></a>

                        @if (Route::has('register'))
                            <!--<a href="{{ route('register') }}">Register</a> -->
                        @endif
                    @endauth
                </div>
            @endif

            <div role="group" aria-label="Basic example" style="margin-top: 550px; padding-inline: 30px;">
                @foreach ($buttons as $button)
                    
                <a href="{{asset('storage/Documents/welcome/{{$button->name}}')}}" target="_blank" font-size:12px;"><button class="btn btn-outline-{{$button->color}}"> <b>{{$button->name}}</b></button></a>
                @endforeach

                <a href="{{asset('storage/Documents/welcome/SIVOC.jpeg')}}" target="_blank" font-size:12px;"><button class="btn btn-outline-primary"> <b>Misión</b></button></a>
                <a href="{{asset('storage/Documents/welcome/VISION.pdf')}}" target="_blank" font-size:12px;"><button><b>Visión</b></button></a>
                <a href="{{asset('storage/Documents/welcome/POLITICA DE CALIDAD.pdf')}}" target="_blank" font-size:12px;"><button><b>Politica de Calidad</b></button></a>
                <a href="{{asset('storage/Documents/welcome/MAPA DE PROCESOS.pdf')}}" target="_blank" font-size:12px;"><button><b>Mapa de procesos</b></button></a>
                <a href="{{asset('storage/Documents/welcome/POLITICAS SIVOC.pdf')}}" target="_blank" font-size:12px;"><button><b>Objetivos de Calidad</b></button></a>
                <a href="{{asset('storage/Documents/welcome/INFORMATE DEL COVID-19.pdf')}}" target="_blank" font-size:12px;"><button><b>COVID 19</b></button></a>
                <a href="{{asset('storage/Documents/welcome/BRIGADA DE EMERGENCIA.pdf')}}" target="_blank" font-size:12px;"><button><b>Brigadad de Emergencia</b></button></a>
                <a href="{{asset('storage/Documents/welcome/PROXIMOS EVENTOS.pdf')}}" target="_blank" font-size:12px;"><button><b>Próximos eventos</b></button></a>
                <a href="{{asset('storage/Documents/welcome/SIVOC.jpeg')}}" target="_blank" font-size:12px;"><button class="btn btn-outline-primary"> <b>Misión</b></button></a>
                <a href="{{asset('storage/Documents/welcome/VISION.pdf')}}" target="_blank" font-size:12px;"><button><b>Visión</b></button></a>
                <a href="{{asset('storage/Documents/welcome/POLITICA DE CALIDAD.pdf')}}" target="_blank" font-size:12px;"><button><b>Politica de Calidad</b></button></a>
                <a href="{{asset('storage/Documents/welcome/MAPA DE PROCESOS.pdf')}}" target="_blank" font-size:12px;"><button><b>Mapa de procesos</b></button></a>
                <a href="{{asset('storage/Documents/welcome/POLITICAS SIVOC.pdf')}}" target="_blank" font-size:12px;"><button><b>Objetivos de Calidad</b></button></a>
                <a href="{{asset('storage/Documents/welcome/INFORMATE DEL COVID-19.pdf')}}" target="_blank" font-size:12px;"><button><b>COVID 19</b></button></a>
                <a href="{{asset('storage/Documents/welcome/BRIGADA DE EMERGENCIA.pdf')}}" target="_blank" font-size:12px;"><button><b>Brigadad de Emergencia</b></button></a>
                <a href="{{asset('storage/Documents/welcome/PROXIMOS EVENTOS.pdf')}}" target="_blank" font-size:12px;"><button><b>Próximos eventos</b></button></a>
            </div>

            
        </div>
    </div>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

        {{-- Configured Scripts --}}
        @include('adminlte::plugins', ['type' => 'js'])
        <script src="{{ asset('vendor/myjs/general_functions.js') }}" ></script>

        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(app()->version() >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>

</html>
