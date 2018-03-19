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
        <link href="{{ asset('frontend/css/jasny-bootstrap.css')}}" rel="stylesheet">
        <link href="{{ asset('frontend/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/owl-carousel/owl.theme.default.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/owl-carousel/owl.theme.green.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/fancyhome.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/pages.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/enhanced.css') }}" rel="stylesheet">
        <link href="{{ asset('https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i') }}" rel="stylesheet">
        <!--Dynamic StyleSheets added from a view would be pasted here-->
        @yield('styles')
    </head>
    <body>
        <input type="hidden" name="hidAbsUrl" id="hidAbsUrl" value="{{URL::to('/')}}" />
        <!-- end of navbar -->
        <div id="loadingDiv"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/489.gif' ?>" class="loading-gif"></div>

        @yield('content')


        <!-- Mainly scripts -->

        <script type="text/javascript" src="{{ asset('frontend/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.js')}}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/jQuery.fileinput.js')}}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/cleave.min.js')}}"></script>

        <script type="text/javascript" src="{{ asset('frontend/js/webjs/commonweb.js')}}"></script>
        <!-- Input Mask-->
        <script src="{{ asset('frontend/js/jasny-bootstrap.js')}}"></script>



        <script type="text/javascript">

$(document).on('change', '.selectinput', function () {
    var data = $(this).val();
    if (data == 'customOption') {
        $(this).hide();
        $(this).attr('disabled', 'disabled');
        $('.inputtext').show();
        $('.inputtext').removeAttr('disabled');
    }

});
$(document).on('blur', '.inputtext', function () {
    var data = $(this).val();
    if (data == '' || data.trim() == '') {
        $(this).hide();
        $(this).attr('disabled', 'disabled');
        $('.selectinput').show();
        $('.selectinput').removeAttr('disabled');
    }
});
        </script>
        @yield('scripts')



    </body>
</html>

