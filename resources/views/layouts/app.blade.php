<!doctype html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <title>App Name - @yield('title')</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
        
    </head>
    <body>
        @section('sidebar')
        <header class="header">
            <div class="header-container">
                <div class="header-body">
                <div class="nav-item">
                    <a href='/logic/check'>
                        <button type="button" class="nav-btn" >Check</button>
                    </a>
                </div>
                <div class="nav-item"> 
                    <a href='/sites'>
                         <button type="button" class="nav-btn" >Sites</button>
                    </a>
                </div>
                <div class="nav-item"> 
                    <a href='/links'>
                         <button type="button" class="nav-btn" >Links</button>
                    </a>
                </div>
                <div class="nav-item"> 
                    <a href='/value'>
                         <button type="button" class="nav-btn" >Value</button>
                    </a>
                </div>
                </div>
            </div>
        </header>
        @show
 
        <div class="container">
            <div class="panel-body">
                @yield('content')
            </div>
            
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src={{ asset('js/web.js') }}></script>
</html>