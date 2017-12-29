<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
	  
	<title>DealsEnRoute Landing Page</title>
          <link rel="icon" type="image/gif" href="images/favico.gif">
	  <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
          <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')}}">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <body>
         <!--navbar-->
           <nav class="navbar navbar-default navbar-fixed-top">
            <div class="logo-container hidden-sm hidden-xs">
            	<div class="static-logo"></div>
            </div>
            <div class="logo-container mobile visible-sm visible-xs">
        		<div class="static-logo black"></div>
        	</div>
        	<div class="social-show-container">
        		<a class="social-open" href="#">
        			<span class="hidden-xs">FOLLOW US</span> 
        			<i class="icon icon-follow"></i>
        		</a>
        	</div>
           </nav>
            <!-- end of navbar -->
            @yield('content')
         
            <script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js')}}"></script>
            <script src="{{ asset('frontend/js/jquery-2.1.4.js')}}"></script>
            <script src="{{ asset('frontend/js/ScrollMagic.js')}} "></script>
            <script src="{{ asset('frontend/js/jquery.ScrollMagic.js')}} "></script>
	 <script src="{{ asset('frontend/js/typed.min.js')}} "></script>
	 <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/typeit/4.2.3/typeit.min.js')}} "></script>
	 <script src="{{ asset('frontend/js/typing-slide-loop2.js')}} "></script>
          <script src="{{ asset('frontend/js/jquery.typist.min.js')}} "></script>
          <script src="{{ asset('frontend/js/hammer.min.js')}} "></script>
          <script src="{{ asset('frontend/js/jMouseWheel-1.0.min.js')}} "></script>
          <script src="{{ asset('frontend/js/velocity.min.js')}} "></script>
          <script src="{{ asset('frontend/js/velocity.ui.min.js')}} "></script>
        <script src="{{ asset('frontend/js/vertical-slider.js')}} "></script>
        <script src="{{ asset('frontend/js/lightslider.js')}} "></script>
        <script src="{{ asset('frontend/js/main.js')}} "></script>
    </body>
</html>

