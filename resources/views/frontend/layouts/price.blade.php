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
     
        <link href="{{ asset('https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i') }}" rel="stylesheet">
        <!--Dynamic StyleSheets added from a view would be pasted here-->
        @yield('styles')
    </head>
    <body class="price-page">
        <header class="header">
		<div>
			<div class="header-logo">
				<a href="#" class="logo"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/logo.png' ?>"</a>
			</div>
		</div>
	</header>
        <input type="hidden" name="hidAbsUrl" id="hidAbsUrl" value="{{URL::to('/')}}" />
        @yield('content')
      

        <!-- Mainly scripts -->

        <script type="text/javascript" src="{{ asset('frontend/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.js')}}"></script>     
        <script type="text/javascript" src="{{ asset('frontend/js/webjs/commonweb.js')}}"></script>
        <!-- Input Mask-->
        <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
    
      
           @if (Session::has('success'))
                <script type="text/javascript">
                     setFlashSuccessNotification();
                </script>
        @endif
          @if (Session::has('error'))   
                <script type="text/javascript">
                    setFlashErrorNotification();
                </script>
        @endif


        @yield('scripts')


       
    </body>
</html>

