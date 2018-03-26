<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Bootstrap Admin App + jQuery">
        <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
        <title>DealsEnRoute - Admin Panel</title>
        <link rel="shortcut icon" href="{{ asset('img/admin/favicon.ico') }}" type="image/x-icon">
        <!-- =============== VENDOR STYLES ===============-->
        <!-- FONT AWESOME-->
        <link rel="stylesheet" href="{{ asset('vendor/admin/fontawesome/css/font-awesome.min.css') }}">
        <!-- SIMPLE LINE ICONS-->
        <link rel="stylesheet" href="{{ asset('vendor/admin/simple-line-icons/css/simple-line-icons.css') }}">
        <!-- ANIMATE.CSS-->
        <link rel="stylesheet" href="{{ asset('vendor/admin/animate.css/animate.min.css') }}">
        <!-- WHIRL (spinners)-->
        <link rel="stylesheet" href="{{ asset('vendor/admin/whirl/dist/whirl.css') }}">
        <!-- CHOSEN-->
        <link rel="stylesheet" href="{{ asset('vendor/admin/chosen_v1.2.0/chosen.min.css') }}">
        <!-- =============== PAGE VENDOR STYLES ===============-->
        <!-- WEATHER ICONS-->
        <link rel="stylesheet" href="{{ asset('vendor/admin/weather-icons/css/weather-icons.min.css') }}">
        <!-- DATATABLES-->
        <link rel="stylesheet" href="{{ asset('vendor/admin/datatables-colvis/css/dataTables.colVis.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/admin/datatables/media/css/dataTables.bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/admin/dataTables.fontAwesome/index.css') }}">
        <!-- =============== BOOTSTRAP STYLES ===============-->
        <link rel="stylesheet" href="{{ asset('css/admin/bootstrap.css')}}" id="bscss">
        <!-- =============== APP STYLES ===============-->
        <link rel="stylesheet" href="{{ asset('css/admin/app.css')}}" id="maincss">
        <!-- =============== APP STYLES ===============-->
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
                            <li class="active">
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
                            <li class="">
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
                        Categories
                        <small class="sub-title">
                            @if($msg)
                             <div id="success-alert" style="margin-top: -28px; display: none;" class="pull-right alert alert-success" >
                                        <strong>Success!</strong> {{$msg}}
                                    </div>
                            @endif
                        </small>

                    </h3>
                    <div class="container-fluid cities-content-wrapper">
                        <!-- Nav Tabs -->
                        <div class="row">
                            <div class="col-lg-12 mb-30">
                                <ul role="tablist" class="nav nav-tabs">
                                    <li role="presentation" class="active"><a href="#activeCities" aria-controls="home" role="tab" data-toggle="tab">Active Categories</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- START DATATABLE 1-->
                        <!-- Tabs Content -->
                        <div class="tab-content clearfix">
                            <!-- Active Cities Content -->
                            <div id="activeCities" role="tabpanel" class="tab-pane active">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- START DATATABLE 1-->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="col-lg-8 col-lg-offset-2 col-md-12 col-xs-12">
                                                                <div class="table-responsive user-management cities-table">
                                                                    <table id="users" class="table table-striped table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Category Name</th>
                                                                                <th>Category Logo</th>
                                                                                <th class="text-center">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($category_list_active as $row)
                                                                            <tr>
                                                                                <td>{{$row->category_name}}</td>
                                                                                <td>
                                                                                    @if($row->category_image)
                                                                                    <img height="50px" width="50px" src='{{$row->category_image}}'> 
                                                                                    @else
                                                                                    No image uploaded
                                                                                    @endif
                                                                                </td>
                                                                                <td class="text-center"><a onclick="delete_city('{{$row->category_id}}','{{$row->category_name}}');" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                                                            </tr>
                                                                            @endforeach

                                                                        </tbody>
                                                                    </table>
                                                                    <script type="text/javascript">
                                                                        function delete_city(id,name){
                                                                            $('#cat_id').val(id);
                                                                            $('#cat_name').val(name);
                                                                            $('#name').val(name);
                                                                            $('#myModal').modal('show');
                                                                            $('#city_name').html(name);
                                                                            $("#accept1").attr("href","{{ url('/admin/deactiveCategory') }}" + "/" +id);
                                                                        }
                                                                    </script>
                                                                    {{ $category_list_active->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
        <!-- =============== VENDOR SCRIPTS ===============-->
        <!-- MODERNIZR-->
        <script src="{{ asset('vendor/admin/modernizr/modernizr.custom.js') }}"></script>
        <!-- MATCHMEDIA POLYFILL-->
        <script src="{{ asset('vendor/admin/matchMedia/matchMedia.js') }}"></script>
        <!-- JQUERY-->
        <script src="{{ asset('vendor/admin/jquery/dist/jquery.js') }}"></script>
        <!-- BOOTSTRAP-->
        <script src="{{ asset('vendor/admin/bootstrap/dist/js/bootstrap.js') }}"></script>
        <!-- STORAGE API-->
        <script src="{{ asset('vendor/admin/jQuery-Storage-API/jquery.storageapi.js') }}"></script>
        <!-- JQUERY EASING-->
        <script src="{{ asset('vendor/admin/jquery.easing/js/jquery.easing.js') }}"></script>
        <!-- ANIMO-->
        <script src="{{ asset('vendor/admin/animo.js/animo.js') }}"></script>
        <!-- SLIMSCROLL-->
        <script src="{{ asset('vendor/admin/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <!-- SCREENFULL-->
        <script src="{{ asset('vendor/admin/screenfull/dist/screenfull.js') }}"></script>
        <!-- LOCALIZE-->
        <script src="{{ asset('vendor/admin/jquery-localize-i18n/dist/jquery.localize.js') }}"></script>
        <!-- RTL demo-->
        <script src="{{ asset('js/admin/demo/demo-rtl.js') }}"></script>
        <!-- =============== PAGE VENDOR SCRIPTS ===============-->
        <!-- SPARKLINE-->
        <script src="{{ asset('vendor/admin/sparkline/index.js') }}"></script>
        <!-- FLOT CHART-->
        <script src="{{ asset('vendor/admin/flot/jquery.flot.js') }}"></script>
        <script src="{{ asset('vendor/admin/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
        <script src="{{ asset('vendor/admin/flot/jquery.flot.resize.js') }}"></script>
        <script src="{{ asset('vendor/admin/flot/jquery.flot.pie.js') }}"></script>
        <script src="{{ asset('vendor/admin/flot/jquery.flot.time.js') }}"></script>
        <script src="{{ asset('vendor/admin/flot/jquery.flot.categories.js') }}"></script>
        <script src="{{ asset('vendor/admin/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
        <!-- EASY PIE CHART-->
        <script src="{{ asset('vendor/admin/jquery.easy-pie-chart/dist/jquery.easypiechart.js') }}"></script>
        <!-- MOMENT JS-->
        <script src="{{ asset('vendor/admin/moment/min/moment-with-locales.min.js') }}"></script>
        <!-- DEMO-->
        <script src="{{ asset('js/admin/demo/demo-flot.js') }}"></script>
        <!-- DATATABLES-->
        <script src="{{ asset('vendor/admin/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/admin/datatables-colvis/js/dataTables.colVis.js') }}"></script>
        <script src="{{ asset('vendor/admin/datatables/media/js/dataTables.bootstrap.js') }}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/dataTables.buttons.js') }}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.bootstrap.js') }}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.colVis.js') }}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.flash.js') }}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.html5.js') }}"></script>
        <script src="{{ asset('vendor/admin/datatables-buttons/js/buttons.print.js') }}"></script>
        <script src="{{ asset('vendor/admin/datatables-responsive/js/dataTables.responsive.js') }}"></script>
        <script src="{{ asset('vendor/admin/datatables-responsive/js/responsive.bootstrap.js') }}"></script>
        <!-- CHOSEN-->
        <script src="{{ asset('vendor/admin/chosen_v1.2.0/chosen.jquery.min.js') }}"></script>
        <!-- =============== APP SCRIPTS ===============-->
        <script src="{{ asset('js/admin/app.js') }}"></script>
        <!--<script src="{{ asset('js/admin//cusom.js') }}"></script>-->
        <script>
                                                                    $(document).ready(function () {

                                                                    $('.chosen-select').chosen({
                                                                    placeholder_text_multiple: "Select Cities or City"
                                                                    });
                                                                    });
                                                                    function action(id, name,status,email) {
                                                                    $('#cat_id').val(id);
                                                                    $('#cat_name').html(name);
                                                                    $('#name').val(name);
                                                                    $('#email').val(email);
                                                                    $('#myModal').modal('show');
                                                                        if(status == 0){
                                                                            $('#comment').show();
                                                                            $('#reject').show();
                                                                            $('#logo').hide();
                                                                            $('#accept').hide();
                                                                        }else{
                                                                            $('#comment').hide();
                                                                            $('#reject').hide();
                                                                            $('#logo').show();
                                                                            $('#accept').show();
                                                                        }
                                                                    }
                                                                    function category(status){
                                                                        if($('#cat_name').val() == '' && status == '1'){
                                                                            $('#file_error').css('display','block');
                                                                        }else{                                                                            
                                                                            $('#status').val(status);
                                                                            $('#category').submit();
                                                                        }
                                                                    }
                                                                     $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                                                                        $("#success-alert").slideUp(500);
                                                                    });

        </script>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Category Details</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="category" action="{{ url('/admin/categotyStatus') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" id="cat_id" name="cat_id">
                            <div class="form-group" id="comment">
                                <label for="pwd">Category Name:</label>
                                <input id="cat_name" name="cat_name" class="form-control"></textarea>
                            </div>
                            <div class="form-group" id="logo">
                                <label for="pwd">Category Logo:</label>
                                <input id="file_img"  name="logo" type="file" class="form-control">
                                
                                <span id="file_error"  style="display: none;color: red;">Please Select Image</span>
                            </div>
                            <input type="hidden" name="status" id="status">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger pull-right" onclick="category('0')" id="reject" type="button" style="margin-left: 10px;">Reject</button>
                        <button class="btn btn-primary pull-right" onclick="category('1')" id="accept" type="button" >Accept</button>
                    </div>
                </div>

            </div>
        </div>
        
          <div class="modal fade" id="myModal1" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you really want to delete category :  <span id="city_name"></span> ?</h4>
                    </div>
                   
                    <div class="modal-footer">
                        <button class="btn btn-danger pull-right" onclick="$('#myModal1').modal('hide');" id="reject" type="button" style="margin-left: 10px;">No</button>
                        <a style="text-decoration: none;" id="accept1"><button class="btn btn-primary pull-right" type="button" >Yes</button></a>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>