<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo \Config::get('app.url') . '/public/frontend/img/favicon.png' ?>">
        <title>@yield('title')</title>
        <!-- common css -->
        <link href="{{ asset('frontend/fonts/fontawesome/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/pages.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/fancyhome.css') }}" rel="stylesheet">
        <link href="{{ asset('https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i') }}" rel="stylesheet">
        <!--Dynamic StyleSheets added from a view would be pasted here-->
        @yield('styles')
    </head>
    <body class="pages pages-homepage">
        <div id="loadingDiv"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/489.gif' ?>" class="loading-gif"></div>
        <div class="errorpopup">
             @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert" style="display: none" >
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ Session::get('success') }}
        </div>  
           @endif
 @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ Session::get('error') }}
        </div>  
  @endif
        </div>
        <div class="base-wrapper">
            <nav class="navbar nav">
                <div class="wrapper"> <a class="logo smooth-scroll" href="#"></a></div>
            </nav>

            <!-- end of navbar -->
            @yield('content')
            @include('frontend/modal/login')
            
            @include('frontend/footer/footer_main')
            <!-- Mainly scripts -->
            <script src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js') }}"></script>
            <script src="{{ asset('frontend/js/bootstrap.js') }}"></script>
            <script type="text/javascript" src="{{ asset('frontend/js/webjs/commonweb.js')}}"></script>
            <script type="text/javascript" src="{{ asset('frontend/js/webjs/login.js')}}"></script>
             <script type="text/javascript" src="{{ asset('frontend/js/webjs/forget.js')}}"></script>
            @yield('scripts')
           

    </body>
</html>

