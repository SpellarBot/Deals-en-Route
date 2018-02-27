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
                     <li class="active">
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
               
               User Details
               <small class="sub-title"></small>
               
               <button type="button" class="btn btn-primary btn-oval pull-right back-btn" onclick="location.href='{{ asset('admin/userlist') }}'">Back</button>
               </h3>
               <div class="container-fluid">
                  <!-- START DATATABLE 1-->
                  <div class="row">
                     <div class="col-lg-12">
                        <!-- User Details -->
                        @foreach($user_list as $row)
                        <div class="well clearfix">
                           <h2 class="col-xs-12 mt-0 mb-20"><strong>{{$row->first_name}} {{$row->last_name}}</strong></h2>
                           <div class="col-lg-4 col-md-6 col-xs-12">
                              <p><strong>Gender :</strong> {{$row->gender}}</p>
                              <p><strong>Age :</strong> {{$row->age}} Years Old</p>
                              <p><strong>Email :</strong> {{$row->email}}</p>
                           </div>
                           <div class="col-lg-4 col-md-6 col-xs-12">
                              <p><strong>Sign Up Type :</strong> {{($row->fb_token != '') ?'facebook':''}}{{($row->google_token!= '') ?'google':''}}{{($row->twitter_token != '') ?'twitter':''}}</p>
                              <p><strong>Coupons Redeemed :</strong> {{$row->coupons}}</p>
                              <p><strong>Status :</strong> <span class="text-success" @if($row->is_active != 1)style="color:red;" @endif>{{($row->is_active == 1) ?'Active':'Inactive'}}</span></p>

                           </div>
                           <div class="col-lg-4 col-xs-12 mt-20">
                               <p>
                                   <a href="{{ asset('admin/offerlist-pdf/'.$row->id)}}">
                                   <button type="button" class="btn btn-primary btn-oval">Export PDF</button> 
                                   </a>
                                   @if($row->is_active == 1)
                                   <a href="{{ asset('admin/disable-user/'.$row->id.'/user')}}"><button type="button" class="btn btn-oval btn-danger">Disable User</button></a>
                                   @else
                                   <a href="{{ asset('admin/active-user/'.$row->id).'/user'}}"><button type="button" class="btn btn-oval btn-info">Enable User</button></a>
                                   @endif
                               </p>
                           </div>
                        </div>
                        @endforeach
                        <!-- Total Survey Table -->
                        <div class="row">
                           <div class="col-lg-12">
                              <h3>Redeemed Offer</h3>
                              <div class="panel panel-default">
                                 <div class="panel-body">
                                    <div class="col-xs-12">
                                       <div class="table-responsive user-detail-table">
                                          <table  class="table table-striped table-hover">
                                             <thead>
                                                <tr>
                                                   <th>Business Name</th>
                                                   <th>Offer</th>
                                                   <th>Coupon Code</th>
                                                   <th>Redeemed On</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                 @foreach($coupons as $row)
                                                <tr>
                                                   <td>{{$row->coupon_name}}</td>
                                                   <td>{{$row->coupon_detail}}</td>
                                                   <td>{{$row->coupon_code}}</td>
                                                   <td>{{date("m-d-Y", strtotime($row->created_at))}}</td>
                                                </tr>
                                                @endforeach
                                          </tbody>
                                          </table>
                                           {{ $coupons->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
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
      <script src="{{ asset('vendor/admin/modernizr/modernizr.custom.js')}}"></script>
      <script src="{{ asset('vendor/admin/jquery/dist/jquery.js')}}"></script>
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
   </body>
</html>