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
                     <li class="">
                        <a href="{{ asset('admin/vendorlist') }}" title="Packages">
                           <em class="fa fa-inbox"></em>
                           <span>Packages</span>
                        </a>
                     </li>
                     <li class="">
                        <a href="{{ asset('admin/reported-content') }}" title="Reported Content">
                           <em class="icon-docs"></em>
                           <span>Reported Content</span>
                        </a>
                     </li>
                     <li class="active">
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
               Cities
               <small class="sub-title">Lorem ipsum dolor sit amet, consectetur</small>
               
               </h3>
               <div class="container-fluid cities-content-wrapper">
                  <!-- Nav Tabs -->
                  <div class="row">
                     <div class="col-lg-12 mb-30">
                        <ul role="tablist" class="nav nav-tabs">
                           <li role="presentation" class="active"><a href="#activeCities" aria-controls="home" role="tab" data-toggle="tab">Active Cities</a></li>
                           <li role="presentation"><a href="#cityRequests" aria-controls="profile" role="tab" data-toggle="tab">City Requests</a></li>
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
                              <div class="row">
                                 <div class="panel panel-default">
                                    <div class="panel-body">
                                       <div class="form-group clearfix">
                                          <label class="col-sm-2 control-label">Add Cities</label>
                                          <div class="col-sm-10">
                                             <select multiple class="chosen-select form-control" value="Select Cities or City">
                                                <option>New York</option>
                                                <option>Chongqing</option>
                                                <option>Shanghai</option>
                                                <option>Delhi</option>
                                                <option>Beijing</option>
                                                <option>Mumbai</option>
                                                <option>Lagos</option>
                                                <option>Karachi</option>
                                                <option>Guangzhou</option>
                                                <option>Istanbul</option>
                                                <option>Tokyo</option>
                                                <option>Tianjin</option>
                                                <option>Moscow</option>
                                                <option>Dhaka</option>
                                                <option>Cairo</option>
                                                <option>Seoul</option>
                                                <option>Kinshasa</option>
                                                <option>Jakarta</option>
                                                <option>Wenzhou</option>
                                                <option>Mexico City</option>
                                                <option>London</option>
                                                <option>Hyderabad</option>
                                                <option>Bengaluru</option>
                                                <option>Ahmedabad</option>
                                                <option>Los Angeles</option>
                                                <option>Durban</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-group mb-0 clearfix">
                                          <div class="col-sm-10 col-sm-offset-2">
                                             <button type="button" class="btn btn-oval btn-primary btn-lg btn-min-w-100">Save</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
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
                                                            <th>City Name</th>
                                                            <th class="text-center">Action</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody>
                                                         <tr>
                                                            <td>New York</td>
                                                            <td class="text-center"><a href="#" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                                         </tr>
                                                         <tr>
                                                            <td>Delhi</td>
                                                            <td class="text-center"><a href="#" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                                         </tr>
                                                         <tr>
                                                            <td>Mexico City</td>
                                                            <td class="text-center"><a href="#" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                                         </tr>
                                                         <tr>
                                                            <td>Los Angeles</td>
                                                            <td class="text-center"><a href="#" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                                         </tr>
                                                         <tr>
                                                            <td>Ahmedabad</td>
                                                            <td class="text-center"><a href="#" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                                         </tr>
                                                         <tr>
                                                            <td>Tokyo</td>
                                                            <td class="text-center"><a href="#" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
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
                     <!-- City Requests -->
                     <div id="cityRequests" role="tabpanel" class="tab-pane">
                        <!-- START DATATABLE 1-->
                        <div class="row">
                           <div class="panel panel-default">
                              <div class="panel-body">
                                 <div class="col-xs-12">
                                    <div class="table-responsive user-management">
                                       <table id="table4" class="table table-striped table-hover">
                                          <thead>
                                             <tr>
                                                <th>User Requested</th>
                                                <th>City Requested</th>
                                                <th>Message</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Esse laudantium adipisci, optio aliquam enim provident rem.</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Animi, a, fugit. Quibusdam error esse reprehenderit cupiditate!</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Corporis amet distinctio repellendus cumque unde, dolores a.</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Quis ad commodi quo eum debitis unde, quia!</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Eveniet excepturi vel optio, at corporis consequuntur ullam.</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>A consequuntur, maiores itaque officia voluptatum voluptatibus quae!</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Veritatis veniam nesciunt odit odio quas recusandae incidunt!</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Voluptatum autem quia, facilis nemo perspiciatis fuga, fugit.</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Harum tempora eum earum debitis esse, ipsa at.</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Deleniti quia dignissimos aut suscipit magnam mollitia minima?</td>
                                             </tr>
                                             <tr>
                                                <td>John Doe</td>
                                                <td>New York</td>
                                                <td>Voluptatibus itaque eum voluptatem, incidunt similique quisquam consequatur.</td>
                                             </tr>
                                          </tbody>
                                       </table>
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
      $(document).ready(function() {
      $('.chosen-select').chosen({
      placeholder_text_multiple: "Select Cities or City"
      });
      });
      </script>
   </body>
</html>