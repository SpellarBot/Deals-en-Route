<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Deals en Route | Dashboard</title>
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
        <link href="{{ asset('frontend/fonts/poppins.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
        <link rel='stylesheet' type='text/css' href="{{ asset('https://fonts.googleapis.com/css?family=Muli:400,300') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/fontawesome/font-awesome.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/chartist-plugin-tooltip.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/css/paper-dashboard.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />
        <link href="{{ asset('frontend/css/jasny-bootstrap.css')}}" rel="stylesheet">
        <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css')}}" rel="stylesheet">
        
    </head>

    <body>
        <input type="hidden" name="hidAbsUrl" id="hidAbsUrl" value="{{URL::to('/')}}" />
        <div id="loadingDiv"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/489.gif' ?>" class="loading-gif"></div>

        <div class="wrapper">

            <div class="errorpopup">
               
                <div class="alert-fade alert-success custom-alert"  style="display: none">
                <div class="alert  alert-success alert-dismissable" role="alert"  >
                    <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <div class="tick-mark-circle"></div>
                    <div class="alert-content">
                        <h3 class="success-text">Success</h3>
                        <div class="successmessage"> </div>
                    </div>
                    <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
                </div>
            </div>
              
                <div class="alert-fade alert-danger custom-alert" style="display: none">
                <div class="alert alert-danger alert-dismissable" role="alert"  >
                    <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <div class="close-circle"></div>
                    <div class="alert-content">
                        <h3 class="success-text">Failed</h3>
                         <div class="errormessage"> </div>
                    </div>
                    <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
                </div>
                </div>
               
            </div>

            @include('frontend/sidebar/editcouponsidebar')
            <div class="main-panel">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar bar1"></span> <span class="icon-bar bar2"></span> <span class="icon-bar bar3"></span> </button>
                            <p class="navbar-brand">Hello, {{ Auth::user()->vendorDetail->vendor_name }} </p>
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon fa fa-user"></i>
                                        <p>User</p>
                                        <b class="caret"></b> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('vendor.logout') }}"
                                               onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">
                                                Sign Out
                                            </a>

                                            <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                @yield('content')  
                @include('frontend/footer/footer_dash')
            </div>
        </div>
        <!--=============================Core JS Files=============================-->

        <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

        <script type="text/javascript" src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js') }}"></script>
       

        <!--=============================Card Details=============================-->
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
         


            $(document).ready(function () {
                //Initialize tooltips
                jQuery('.nav-tabs-step > li a[title]').tooltip();


                //Wizard
                jQuery('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                    var $target = jQuery(e.target);

                    if ($target.parent().hasClass('disabled')) {
                        return false;
                    }
                });


            });
           

            // store the currently selected tab in the hash value
            $("ul.nav1 a").on("shown.bs.tab", function (e) {

                e.preventDefault();
                var id = $(e.target).attr("href").substr(1);
                window.location.hash = id;
            });

            // on load of the page: switch to the currently selected tab
            var hash = window.location.hash;

            $('#groupTab a[href="' + hash + '"]').tab('show');


        </script>
        <script type="text/javascript" src="{{  asset('frontend/js/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap-table.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/paper-dashboard.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/demo.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/webjs/commonweb.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/jasny-bootstrap.js')}}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/webjs/couponlist.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ \Config::get('googlemaps.key') }}&libraries=drawing,places&callback=initCallback"
        async defer></script>
        @yield('scripts')
    </body>

</html>
