<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Bootstrap Admin App + jQuery">
        <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
        <title>DealsEnRoute - Admin Panel</title>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('vendor/admin/fontawesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/admin/simple-line-icons/css/simple-line-icons.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/admin/animate.css/animate.min.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/admin/weather-icons/css/weather-icons.min.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/admin/datatables-colvis/css/dataTables.colVis.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/admin/datatables/media/css/dataTables.bootstrap.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/admin/jquery-ui/themes/smoothness/jquery-ui.min.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/admin/dataTables.fontAwesome/index.css')}}">
        <link rel="stylesheet" href="{{ asset('css/admin/bootstrap.css')}}" id="bscss">
        <link rel="stylesheet" href="{{ asset('css/admin/app.css')}}" id="maincss">
        <link rel="stylesheet" href="{{ asset('css/admin/custom.css')}}">
         
    </head>
    <body>
        <div class="wrapper">
            <!-- top navbar-->
            <header class="topnavbar-wrapper">
                <!-- START Top Navbar-->
                <nav role="navigation" class="navbar topnavbar">
                    <!-- START navbar header-->
                    <div class="navbar-header">
                        <a href="#/" class="navbar-brand">
                            <div class="brand-logo">
                                <img src="{{ asset('img/admin/logo.png')}}" alt="App Logo" class="img-responsive">
                            </div>
                            <div class="brand-logo-collapsed">
                                <img src="{{ asset('img/admin/logo-single.png')}}" alt="App Logo" class="img-responsive">
                            </div>
                        </a>
                    </div>
                    <!-- END navbar header-->
                    <!-- START Nav wrapper-->
                    <div class="nav-wrapper">
                        <!-- START Left navbar-->
                        <ul class="nav navbar-nav">
                            <li>
                                <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                                <a href="#" data-trigger-resize="" data-toggle-state="aside-collapsed" class="hidden-xs">
                                    <em class="fa fa-navicon"></em>
                                </a>
                                <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                                <a href="#" data-toggle-state="aside-toggled" data-no-persist="true" class="visible-xs sidebar-toggle">
                                    <em class="fa fa-navicon"></em>
                                </a>
                            </li>
                        </ul>
                        <!-- END Left navbar-->
                        <!-- START Right Navbar-->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- START user name-->
                            <li class="dropdown dropdown-list user-name">
                                <a href="dashboard.html" data-toggle="dropdown">
                                    <em class="icon-user"></em> Admin
                                </a>
                                <!-- START Dropdown menu-->
                                <ul class="dropdown-menu animated flipInX">
                                    <li>
                                        <!-- START list group-->
                                        <div class="list-group">
                                            <!-- last list item-->
                                            <!--                                 <a href="#" class="list-group-item">
                                                                                <small>My Profile</small>
                                                                             </a>
                                                                             <a href="#" class="list-group-item">
                                                                                <small>Change Password</small>
                                                                             </a>-->
                                            <a href="{{ url('/admin/logout') }}" class="list-group-item"
                                               onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out"></i>  Logout
                                            </a>

                                            <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                        <!-- END list group-->
                                    </li>
                                </ul>
                                <!-- END Dropdown menu-->
                            </li>
                            <!-- END Alert menu-->
                        </ul>
                        <!-- END Right Navbar-->
                    </div>
                    <!-- END Nav wrapper-->
                </nav>
                <!-- END Top Navbar-->
            </header>
            <!-- sidebar-->
            <aside class="aside">
                <!-- START Sidebar (left)-->
                <div class="aside-inner">
                    <nav data-sidebar-anyclick-close="" class="sidebar">
                        <!-- START sidebar nav-->
                        <ul class="nav">

                            <!-- Iterates over all sidebar items-->
                            <li class="">
                                <a href="{{ asset('admin/home') }}" title="Dashboard">
                                    <em class="icon-speedometer"></em>
                                    <span>Dashboard</span>
                                </a>

                            </li>
                            <li class="">
                                <a href="{{ asset('admin/userlist') }}" title="Users">
                                    <em class="icon-people"></em>
                                    <span>Users</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ asset('admin/vendorlist') }}" title="Businesses">
                                    <em class="icon-briefcase"></em>
                                    <span>Businesses</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ asset('admin/categories') }}" title="Packages">
                                    <em class="fa fa-inbox"></em>
                                    <span>Categories</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ asset('admin/reported-content') }}" title="Reported Content">
                                    <em class="icon-docs"></em>
                                    <span>Reported Content</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ asset('admin/city') }}" title="Cities">
                                    <em class="fa fa-building-o"></em>
                                    <span>Cities</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="{{ asset('admin/payments') }}" title="Payments">
                                    <em class="fa fa-money"></em>
                                    <span>Payments</span>
                                </a>
                            </li>
                        </ul>
                        <!-- END sidebar nav-->
                    </nav>
                </div>
                <!-- END Sidebar (left)-->
            </aside>

            <!-- Main section-->
            <section>
                <!-- Page content-->
                <div class="content-wrapper">
                    <h3>
                        Payments
                        <small class="sub-title">
                        
                            <div id="success-alert" style="margin-top: -28px; display: none;" class="pull-right alert alert-success" >
                            <strong>Success!</strong> Invoice sent successfully.
                        </div>
                            </small>
                    </h3>
                    
                    <div class="container-fluid">
                        <!-- START DATATABLE 1-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <script type="text/javascript">
                                            function pdf(){
                                            $('#is_pdf').val('1');
                                            $('#pay_list').submit();
                                            $('#is_pdf').val('0');
                                            }
                                        </script>
                                        <form method="get" id="pay_list">
                                            <input type="hidden" value="0" name="is_pdf" id="is_pdf">
                                            <div class="col-lg-4 col-md-2 col-sm-12 col-xs-12 text-right mb-sm-15 pull-right">
                                                <button type="submit" class="pull-left btn btn-danger btn-oval">Search</button>
                                                <button type="button" class="btn btn-primary btn-oval" onclick="pdf()">Export PDF</button>

                                            </div>
                                            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 pull-left">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label">Filter</label>
                                                        <div class="col-md-3 col-sm-3 col-xs-12 mb-xs-15">
                                                            <select name="vendor" class="form-control m-b">
                                                                <option value="" @if($vendor_val == "")selected @endif>Payee</option>
                                                                @foreach($vendor_list as $row)
                                                                <option value="{{$row->id}}" @if($vendor_val == $row->id)selected @endif>{{$row->vendor_name ?:'-'}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 col-xs-12 mb-xs-15">
                                                            <select name="payment_type" class="form-control m-b">
                                                                <option value="" @if($payment_type_val == "") selected @endif>Payment Type</option>
                                                                @foreach($payment_type as $row)
                                                                <option value="{{$row->payment_type}}" @if($payment_type_val == $row->payment_type)selected @endif>{{$row->payment_type}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 col-sm-3 col-xs-12 mb-xs-15">
                                                            <select name="payment_status" class="form-control m-b">
                                                                <option value="" @if($payment_status_val == "") selected @endif>payment status</option>
                                                                @foreach($payment_status as $row)
                                                                <option value="{{$row->payment_status}}" @if($payment_status_val == $row->payment_status)selected @endif>{{$row->payment_status}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 col-md-10 col-sm-12 mt-15">
                                                <div class="row">
                                                    <div class="form-group date-rang mb-0 clearfix">
                                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label">DateTimePicker</label>
                                                        <div id="datetimepicker1" class="col-md-4 col-sm-4 col-xs-12 input-group date first">
                                                            <input name="date_start" type="text" class="form-control datepicker" value="{{$date_start_val}}" onclick="setZindex()">
                                                        </div>
                                                        <label class="col-lg-1 col-md-1 col-sm-1 col-xs-12 control-label text-center">To</label>
                                                        <div id="datetimepicker1" class="col-md-4 col-sm-4 col-xs-12 mb-15 input-group date">
                                                            <input name="date_end" type="text" value="{{$date_end_val}}" class="form-control datepicker" onclick="setZindex()">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-xs-12 mt-15">
                                            <div class="table-responsive user-management">
                                                @if(count($paylist) > 0)
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Payee</th>
                                                            <th>Paid Date</th>
                                                            <th>Amount</th>
                                                            <th>Type</th>
                                                            <th>Transaction ID</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($paylist as $row)
                                                        <tr>
                                                            <td>{{$row->vendor_name}}</td>
                                                            <td>{{$row->created_at}}</td>
                                                            <td>$ {{$row->payment_amount}}</td>
                                                            <td>{{$row->payment_type}}</td>
                                                            <td>{{$row->transaction_id}}</td>
                                                            <td><span class="text-success">{{$row->payment_status}}</span></td>
                                                            <td style="cursor: pointer;" onclick="resend('{{$row->invoice}}','{{$row->email}}')">Resend Invoice</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                {{ $paylist->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
                                                @else
                                                <span>No data Found</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Page footer-->
            <footer>
                <span>&copy; 2018 - DealsEnRoute</span>
            </footer>
        </div>
<!--        <form id="resend_form" action="" method="get">
            <input type="text" id="invoice" name="invoice">
            <input type="text" id="email" name="email">
        </form>-->
        <script>
            function resend(inv, mail){
                $.ajax({
                    url: "{{ asset('/admin/Resend')}}",
                    data: {invoice : inv,email : mail},
                    dataType: "json",
                    cache: false,
                    success: function(html){
                        console.log(html);
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                            $("#success-alert").slideUp(500);
                        });
                    }
                });
            }
        </script>
        <!-- =============== VENDOR SCRIPTS ===============-->
        <script src="{{ asset('vendor/admin/modernizr/modernizr.custom.js')}}"></script>
        <script src="{{ asset('vendor/admin/jquery/dist/jquery.js')}}"></script>
        <script src="{{ asset('vendor/admin/jquery-ui/jquery-ui.js')}}"></script>
        <script src="{{ asset('vendor/admin/bootstrap/dist/js/bootstrap.js')}}"></script>
        <script src="{{ asset('vendor/admin/jQuery-Storage-API/jquery.storageapi.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables/media/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables-colvis/js/dataTables.colVis.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables/media/js/dataTables.bootstrap.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/dataTables.buttons.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.bootstrap.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.colVis.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.flash.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.html5.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.print.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables-responsive/js/dataTables.responsive.js')}}"></script>
        <script src="{{ asset('vendor/admin/datatables-responsive/js/responsive.bootstrap.js')}}"></script>
        <!-- =============== APP SCRIPTS ===============-->
        <script src="{{ asset('js/admin/app.js')}}"></script>
        <script src="{{ asset('js/admin/cusom.js')}}"></script>
       
<script type="text/javascript">
            $(document).ready(function () {
                $(".datepicker").datepicker();
                $("#success-alert").hide();
                });
                function setZindex() {
                $("#ui-datepicker-div").css("z-index", "9999");
            }
        </script>
    </body>
</html>