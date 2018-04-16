<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Deals en Route | Dashboard</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo \Config::get('app.url') . '/public/frontend/img/favicon.png' ?>">
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
       <!-- timepicker plugin-->   
      <link href="{{ asset('frontend/plugin/timepicker/jquery.timepicker.css')}}" rel="stylesheet">
<link href="{{ asset('frontend/plugin/timepicker/lib/site.css')}}" rel="stylesheet">

    </head>

    <body>
        @if($hoursmsg == true)
        <div class="hoursofoperationalert">
            <div class="errormessage">Please Add Hours Of Operations</div>
            <div class="errobuttons">
                <a class="btn btn-sm btn-create" id="addhours">Add Now</a>
                <a class="btn btn-sm btn-create "id="remindmelater">Remind Me Later</a>
            </div>
        </div>   
        @endif
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
   
            <!-- <div class="alert alert-success alert-dismissible" role="alert"  >
                <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button>
                fgfdgdggdfgg
            </div> -->  
         
           
        
        </div>
           

            @include('frontend/sidebar/sidebar')
            @yield('content')   
            @include('frontend/modal/createcoupon')

        </div>
        <!--=============================Core JS Files=============================-->

        <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

        <script type="text/javascript" src="{{ asset('frontend/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/webjs/commonweb.js')}}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/cleave.min.js') }}"></script>
        <!-- timepicker plugin-->   
        <script type="text/javascript" src="{{ asset('frontend/plugin/timepicker/jquery.timepicker.js') }} "></script>
	<script type="text/javascript" src="{{ asset('frontend/plugin/timepicker/lib/bootstrap-datepicker.js') }} "></script>
        <script type="text/javascript" src="{{ asset('frontend/plugin/timepicker/lib/site.js') }} "></script>
        <script src="http://jonthornton.github.io/Datepair.js/dist/datepair.js"></script>
	<script src="http://jonthornton.github.io/Datepair.js/dist/jquery.datepair.js"></script>
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


            //Initialize tooltips
            jQuery('.nav-tabs-step > li a[title]').tooltip();


            //Wizard
            jQuery('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                var $target = jQuery(e.target);

                if ($target.parent().hasClass('disabled')) {
                    return false;
                }
            });


            jQuery('#groupTab a').click(function (e) {

                e.preventDefault();
                jQuery(this).tab('show');
            });

            // store the currently selected tab in the hash value
            jQuery("ul.nav1 a").on("shown.bs.tab", function (e) {

                e.preventDefault();
                var id = jQuery(e.target).attr("href").substr(1);
                window.location.hash = id;
            });

            // on load of the page: switch to the currently selected tab
            var hash = window.location.hash;

            jQuery('#groupTab a[href="' + hash + '"]').tab('show');


        </script>
        <script type="text/javascript" src="{{  asset('frontend/js/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/jquery.easypiechart.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/chartist.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap-table.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/paper-dashboard.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/chartist-plugin-tooltip.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/demo.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/webjs/commonweb.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/jasny-bootstrap.js')}}"></script>

        <script type="text/javascript" src="{{ asset('frontend/js/webjs/dashboard.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/webjs/settings.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/webjs/couponlist.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/custom.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ \Config::get('googlemaps.key') }}&libraries=drawing,places&callback=initCallback"
        async defer></script>

        @yield('scripts')
    </body>

</html>
