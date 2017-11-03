<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
       <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Deals en Route | Dashboard</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo \Config::get('app.url') . '/public/frontend/img/favicon.png' ?>">
	<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href="{{ asset('https://fonts.googleapis.com/css?family=Muli:400,300')}}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/fontawesome/font-awesome.css') }}"  />
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/chartist-plugin-tooltip.css') }}" />
	<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}"/>
	<link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('frontend/css/paper-dashboard.css') }}"/>
	<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />
       <!--Dynamic StyleSheets added from a view would be pasted here-->
        @yield('styles')
    </head>
    <body>
        <input type="hidden" name="hidAbsUrl" id="hidAbsUrl" value="{{URL::to('/')}}" />
        <!-- end of navbar -->
        <div id="loadingDiv"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/489.gif' ?>" class="loading-gif"></div>
     <div class="wrapper">
		<div class="sidebar" data-background-color="white" data-active-color="success">
			<div class="sidebar-wrapper">
				<div class="logo"> <a href="index.html"> <img alt="" width="60" src="img/logo.png"> </a> </div>
				<ul class="nav nav1" id="groupTab">
					<li class="active"> <a data-toggle="tab" href="#dashboard"> <i class="icon fa fa-dashboard"></i>
          <p>Dashboard</p>
          </a> </li>
					<li> <a data-toggle="tab" href="#create"> <i class="icon fa fa-tag"></i>
          <p>Create Coupon</p>
          </a> </li>
					<li> <a data-toggle="tab" href="#settings"> <i class="icon fa fa-cog"></i>
          <p>Settings</p>
          </a> </li>
					<li> <a data-toggle="tab" href="#contact"> <i class="icon fa fa-envelope"></i>
          <p>Contact Us</p>
          </a> </li>
				</ul>
			</div>
		</div>
		<div class="main-panel">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar bar1"></span> <span class="icon-bar bar2"></span> <span class="icon-bar bar3"></span> </button>
						<p class="navbar-brand">Hello, User Name</p>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon fa fa-user"></i>
              <p>User</p>
              <b class="caret"></b> </a>
								<ul class="dropdown-menu">
											<li>  <a href="{{ url('/vendor/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Sign Out
                                        </a>

                                        <form id="logout-form" action="{{ url('/vendor/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
        
        @yield('content')
      <footer class="footer">
				<div class="container-fluid">
					<div class="copyright pull-right"> &copy;
						<script>
							document.write(new Date().getFullYear())

						</script>, All Rights Reserved. </div>
				</div>
			</footer>
		</div>
	</div>

        <!-- Mainly scripts -->
	<!--=============================Core JS Files=============================-->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.js')}}"></script>
	<script type="text/javascript">
		jQuery('#groupTab a').click(function(e) {
			e.preventDefault();
			jQuery(this).tab('show');
		});

		// store the currently selected tab in the hash value
		jQuery("ul.nav1 a").on("shown.bs.tab", function(e) {
			var id = jQuery(e.target).attr("href").substr(1);
			window.location.hash = id;
		});

		// on load of the page: switch to the currently selected tab
		var hash = window.location.hash;
		jQuery('#groupTab a[href="' + hash + '"]').tab('show');

	</script>
       <script type="text/javascript" src="{{ asset('frontend/js/webjs/commonweb.js')}}"></script>
       
       
        @yield('scripts')
    </body>
</html>

