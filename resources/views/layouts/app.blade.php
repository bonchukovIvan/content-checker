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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
    </head>
    <body>
        @section('sidebar')
        <header class="header">
            <div class="header-container">
                <div class="header-body">
                <div class="nav-item">
                    <a href='/'>
                    <i class="fa fa-home"></i>
                        <button type="button" class="nav-btn" >Home</button>
                    </a>
                </div>
                <div class="nav-item"> 
                    <a href='/sites'>
                    <i class="fa fa-link"></i>
                         <button type="button" class="nav-btn" >Sites</button>
                    </a>
                </div>
                <div class="nav-item"> 
                    <a href='/values'>
                    <i class="fa fa-copy"></i>
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
</html>