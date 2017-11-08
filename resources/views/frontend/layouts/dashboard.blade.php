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
    </head>

    <body>
        <input type="hidden" name="hidAbsUrl" id="hidAbsUrl" value="{{URL::to('/')}}" />
        <div id="loadingDiv"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/489.gif' ?>" class="loading-gif"></div>
       
        <div class="wrapper">
           
                  <div class="errorpopup">
                <div class="alert alert-success alert-dismissible" role="alert" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="successmessage"> </div>
                </div>  
                <div class="alert alert-danger alert-dismissible" role="alert" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <div class="errormessage"> </div>
                </div>  
            </div>
             
            @include('frontend/sidebar/sidebar')
            @yield('content')   
        </div>
        <!--=============================Core JS Files=============================-->

        <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

        <script type="text/javascript" src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript">
            jQuery('#groupTab a').click(function (e) {
                e.preventDefault();
                jQuery(this).tab('show');
            });

            // store the currently selected tab in the hash value
            jQuery("ul.nav1 a").on("shown.bs.tab", function (e) {
                var id = jQuery(e.target).attr("href").substr(1);
                window.location.hash = id;
            });

            // on load of the page: switch to the currently selected tab
            var hash = window.location.hash;
            jQuery('#groupTab a[href="' + hash + '"]').tab('show');

        </script>
        <script type="text/javascript" src="{{ asset('frontend/js/jQuery.fileinput.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/example.js')}}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/cleave.min.js') }}"></script>

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

                $('input[type="tel"]').keyup(function () {
                    $(this).val($(this).val().replace(/(\d{1})\-?(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3-$4'))
                });

                new Cleave('.cardNumber', {
                    creditCard: true,
                    onCreditCardTypeChanged: function (type) {
                        document.querySelector('.type').innerHTML = '<i class="fa fa-cc- ' + type + ' fa-fw fa-2x active" aria-hidden="true"></i>';
                    }
                });


                new Cleave('.expiry', {
                    date: true,
                    datePattern: ['m', 'y']
                });
            });

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
         <script type="text/javascript" src="{{ asset('frontend/js/jquery.pjax.js') }}"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
      
        <script type="text/javascript">
            jQuery(document).ready(function () {
                //Initialize tooltips
                jQuery('.nav-tabs-step > li a[title]').tooltip();

                //Wizard
                jQuery('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

                    var $target = jQuery(e.target);

                    if ($target.parent().hasClass('disabled')) {
                        return false;
                    }
                });

                jQuery(".next-step").click(function (e) {

                    var $active = jQuery('.wizard .nav-tabs-step li.active');
                    $active.next().removeClass('disabled');
                    nextTab($active);

                });
                jQuery(".prev-step").click(function (e) {

                    var $active = jQuery('.wizard .nav-tabs-step li.active');
                    prevTab($active);

                });
            });

            function nextTab(elem) {
                jQuery(elem).next().find('a[data-toggle="tab"]').click();
            }

            function prevTab(elem) {
                jQuery(elem).prev().find('a[data-toggle="tab"]').click();
            }

        </script>

        <!--=============================Date Picker=============================-->
        <script type="text/javascript">
            $('.datepicker').datetimepicker({
                format: 'MM/DD/YYYY', //use this format if you want the 12hours timpiecker with AM/PM toggle
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove'
                }
            });

        </script>

        <!--=============================Line Chart=============================-->
        <script type="text/javascript">
            $(document).ready(function () {
                var dataWeekly = {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
                    series: [
                        [25, 50, 100, 80, 75]
                    ]
                };
                var optionsWeekly = {
                    showPoint: true,
                    lineSmooth: true,
                    height: "320px",
                    axisX: {
                        showGrid: false,
                        showLabel: true
                    },
                    axisY: {
                        offset: 40,
                    },
                    low: 0,
                    high: 'auto',
                    height: "320px"
                };
                var line2 = Chartist.Line('#chartWeekly', dataWeekly, optionsWeekly);

                var dataMonthly = {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    series: [
                        [10, 40, 100, 80, 75, 90, 10, 40, 100, 80, 75, 105]
                    ]
                };
                var optionsMonthly = {
                    showPoint: true,
                    lineSmooth: true,
                    height: "320px",
                    axisX: {
                        showGrid: false,
                        showLabel: true
                    },
                    axisY: {
                        offset: 40,
                    },
                    low: 0,
                    high: 'auto',
                    height: "320px"
                };

                var line1 = Chartist.Line('#chartMonthly', dataMonthly, optionsMonthly);

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
                    line1.update();
                    line2.update();
                });
            });

        </script>

        <!--=============================Pie Chart=============================-->
        <script type="text/javascript">
            $('#chartunder18').easyPieChart({
                lineWidth: 4,
                size: 70,
                scaleColor: false,
                trackColor: 'rgba(57,89,153,.25)',
                barColor: '#395999',
                animate: ({
                    duration: 5000,
                    enabled: true
                })

            });

            $('#chart18-34').easyPieChart({
                lineWidth: 4,
                size: 70,
                scaleColor: false,
                trackColor: 'rgba(244,235,102,.25)',
                barColor: '#f4eb66',
                animate: ({
                    duration: 5000,
                    enabled: true
                })

            });

            $('#chart35-50').easyPieChart({
                lineWidth: 4,
                size: 70,
                scaleColor: false,
                trackColor: 'rgba(70,185,109,.25)',
                barColor: '#46b96d',
                animate: ({
                    duration: 5000,
                    enabled: true
                })

            });

            $('#chartabove50').easyPieChart({
                lineWidth: 4,
                size: 70,
                scaleColor: false,
                trackColor: 'rgba(79,168,222,.25)',
                barColor: '#4fa8de',
                animate: ({
                    duration: 5000,
                    enabled: true
                })

            });

            $('#charttotal').easyPieChart({
                lineWidth: 12,
                size: 200,
                scaleColor: false,
                trackColor: 'rgba(70,85,109,.25)',
                barColor: '#46b96d',
                animate: ({
                    duration: 5000,
                    enabled: true
                })

            });

        </script>

        <!--=============================Bar Chart=============================-->
        <script type="text/javascript">
            var data = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                series: [
                    [120, 120, 120, 120, 120, 120, 120, 120, 120, 120, 120, 120],
                    [325, 320, 350, 300, 250, 325, 320, 350, 300, 250, 350, 250],
                    [240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240]
                ]
            };

            var options = {
                seriesBarDistance: 15,
                axisX: {
                    showGrid: false
                },
                height: "250px"
            };

            var responsiveOptions = [
                ['screen and (max-width: 767px)', {
                        seriesBarDistance: 8,
                        axisX: {
                            labelInterpolationFnc: function (value) {
                                return value[0];
                            }
                        }
                    }]
            ];

            var bar1 = Chartist.Bar('#chartCoupons', data, options, responsiveOptions);

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
                bar1.update();
            });

        </script>
        <!--============================= Pjax =============================-->
        <script type="text/javascript">
            $(document).ready(function () {

                // does current browser support PJAX
                if ($.support.pjax) {
           
                    $.pjax.defaults.timeout = 200000; // time in milliseconds
                }
            });
            
        </script>
        @yield('scripts')
    </body>

</html>
