<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Styles -->

        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
        <!-- Toastr style -->
        <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

        <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
        <script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
        {{--  <script src="{{ asset('jquery-2.1.1.js') }}" onload="window.$ = window.jQuery = module.exports;"></script>  --}}

        @yield('styles')

    </head>

    <body>
        <input type="hidden" name="hidAbsUrl" id="hidAbsUrl" value="{{URL::to('/')}}" />
            <div id="wrapper">

            @include('admin/sidebar/sidebar')


    <div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">

         <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome to Deals en route.</span>
            </li>


            <li>
                <a href="{{ url('/admin/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                             <i class="fa fa-sign-out"></i>  Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
            </li>
        </ul>

    </nav>
</div>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-10">  <h2><?php $routes=\Request::route()->getName(); $ex=explode('.',$routes); echo $ex[0]; ?></h2>
                <ol class="breadcrumb">


                                    @if(empty(Request::segments()))

                                    @else
                                    @for($i = 1; $i <= count(Request::segments()); $i++)

                                    <li class=""> <a href="{{ URL::to( implode("/",array_slice(Request::segments($i),0,$i)))}}">
                                    <strong>  {{ucwords(Request::segment($i))}} </strong>
                                    </a> </li>@endfor
                                    @endif
                </ol>
        </div>
    </div>
           <div class="wrapper wrapper-content animated fadeInRight">
                        @yield('content')
                    </div>


            </div>
        </div>



        <!-- Mainly scripts -->
          <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
        <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>


        <!-- Data picker -->
        <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

     
        
        <!-- SUMMERNOTE
       <script src="{{ asset('js/plugins/summernote/summernote.min.js') }}"></script>
        -->
        <!-- datatables -->
        <script src= "{{ asset('js/plugins/jeditable/jquery.jeditable.js') }}"></script>
        <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
        <!-- Custom and plugin javascript -->
        <script src="{{ asset('js/inspinia.js') }}"></script>
        <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

       <!-- Toastr -->
        <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

        <script src="{{ asset('js/jquery.blockUI.js') }}"></script>

        <script src="{{ asset('js/lodash.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        <script src="{{ asset('js/commonweb.js') }}"></script><!-- Input Mask-->
        <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
         <!-- Select2 -->
       <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
     
        @yield('scripts')

        @if (Session::has('message') && !empty(Session::get('message')))

                <script type="text/javascript">
                    var toasterMessage = '{{Session::get("message")}}';

                    var objMessageToastNotication = {
                        message: toasterMessage
                    };
                   setToastNotification(objMessageToastNotication);
                </script>

        @endif
    </body>
</html>

