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
      <!-- =============== PAGE VENDOR STYLES ===============-->
      <!-- WEATHER ICONS-->
      <link rel="stylesheet" href="{{ asset('vendor/admin/weather-icons/css/weather-icons.min.css') }}">
      <!-- =============== BOOTSTRAP STYLES ===============-->
      <link rel="stylesheet" href="{{ asset('css/admin/bootstrap.css') }}" id="bscss">
      <!-- =============== APP STYLES ===============-->
      <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}" id="maincss">
      <!-- =============== APP STYLES ===============-->
      <link rel="stylesheet" href="{{ asset('css/admin/custom.css') }}">
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
                        <img src="{{ asset('img/admin/logo.png') }}" alt="App Logo" class="img-responsive">
                     </div>
                     <div class="brand-logo-collapsed">
                        <img src="{{ asset('img/admin/logo-single.png') }}" alt="App Logo" class="img-responsive">
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
                        <a href="#" data-toggle="dropdown">
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
                     <li class="active">
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
            <div class="content-wrapper dashboard-cat-list">
               <div class="content-heading">
                  
                  <!-- END Language list-->
                  Dashboard
                  <small>Welcome Admin !</small>
               </div>
               <!-- START widgets box-->
               <div class="row">
                  <div class="col-lg-4 col-sm-6">
                     <!-- START widget-->
                     <a href="{{ asset('admin/userlist') }}">
                        <div class="panel widget bg-primary">
                           <div class="row row-table">
                              <div class="col-xs-4 text-center bg-primary-dark pv-lg">
                                 <em class="icon-people fa-3x"></em>
                              </div>
                              <div class="col-xs-8 pv-lg">
                                 <div class="h2 mt0">{{$user_count}}</div>
                                 <div class="text-uppercase">Users</div>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-lg-4 col-sm-6">
                     <!-- START widget-->
                     <a href="{{ asset('admin/vendorlist') }}">
                        <div class="panel widget bg-purple">
                           <div class="row row-table">
                              <div class="col-xs-4 text-center bg-purple-dark pv-lg">
                                 <em class="icon-briefcase fa-3x"></em>
                              </div>
                              <div class="col-xs-8 pv-lg">
                                 <div class="h2 mt0">{{$vendor_count}}</div>
                                 <div class="text-uppercase">Businesses</div>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-lg-4 col-sm-6">
                     <!-- START widget-->
                     <a href="#">
                        <div class="panel widget bg-green">
                           <div class="row row-table">
                              <div class="col-xs-4 text-center bg-green-dark pv-lg">
                                 <em class="fa fa-inbox fa-3x"></em>
                              </div>
                              <div class="col-xs-8 pv-lg">
                                 <div class="h2 mt0">{{$plan_count}}</div>
                                 <div class="text-uppercase">Packages</div>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-lg-4 col-sm-6">
                     <!-- START widget-->
                     <a href="{{ asset('admin/reported-content') }}">
                        <div class="panel widget bg-warning">
                           <div class="row row-table">
                              <div class="col-xs-4 text-center bg-warning-dark pv-lg">
                                 <em class="icon-docs fa-3x"></em>
                              </div>
                              <div class="col-xs-8 pv-lg">
                                 <div class="h2 mt0">10</div>
                                 <div class="text-uppercase">Reported Content</div>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-lg-4 col-sm-6">
                     <!-- START widget-->
                     <a href="{{ asset('admin/city') }}">
                        <div class="panel widget bg-success">
                           <div class="row row-table">
                              <div class="col-xs-4 text-center bg-success-dark pv-lg">
                                 <em class="fa fa-building-o fa-3x"></em>
                              </div>
                              <div class="col-xs-8 pv-lg">
                                 <div class="h2 mt0">120</div>
                                 <div class="text-uppercase">Cities</div>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="col-lg-4 col-sm-6">
                     <!-- START widget-->
                     <a href="{{ asset('admin/payments') }}">
                        <div class="panel widget bg-yellow">
                           <div class="row row-table">
                              <div class="col-xs-4 text-center bg-yellow-dark pv-lg">
                                 <em class="fa fa-money fa-3x"></em>
                              </div>
                              <div class="col-xs-8 pv-lg">
                                 <div class="h2 mt0">{{$payment_count}}</div>
                                 <div class="text-uppercase">Payments</div>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
               </div>
               <!-- END widgets box-->
               
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
   <!-- =============== APP SCRIPTS ===============-->
   <script src="{{ asset('js/admin/app.js') }}"></script>
   <script src="{{ asset('js/admin/cusom.js') }}"></script>
</body>
</html>