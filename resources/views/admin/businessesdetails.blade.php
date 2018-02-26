<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <meta name="description" content="Bootstrap Admin App + jQuery">
      <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
      <title>DealsEnRoute - Admin Panel</title>
      <link rel="shortcut icon" href="{{ asset('img/favicon.ico')}}" type="image/x-icon">
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
                                 <!-- last list item-->
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
                     <li class="active">
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
               
               Business Details
               <small class="sub-title"></small>
               
               <button type="button" class="btn btn-primary btn-oval pull-right back-btn" onclick="location.href='users.html'">Back</button>
               </h3>
               <div class="container-fluid">
                  <!-- START DATATABLE 1-->
                  <div class="row">
                     <div class="col-lg-12">
                        <!-- User Details -->
                        <div class="well clearfix">
                           
                           <div class="col-lg-3 col-md-6 col-xs-12 business-img">
                              <img src="{{ asset('img/admin/dominos_pizza_logo.png') }}" alt="" class="img-responsive">
                           </div>
                            @foreach($vendor_list as $row)
                           <div class="col-lg-5 col-md-6 col-xs-12 business-intro">
                              <h2 class="mt-0 mb-20"><strong>{{$row->vendor_name}}</strong></h2>
                              <p><strong><i class="fa fa-location-arrow"></i></strong> {{$row->vendor_address}}</p>
                              <p><strong><i class="fa fa-envelope"></i></strong> {{$row->email}}</p>
                              <p><strong><i class="fa fa-phone"></i></strong> <span>{{$row->vendor_phone}}</span></p>
                              <p><strong>Currently Subscribed Pakage :</strong> <span>{{$row->stripe_plan}}</span></p>
                              <p><strong>Renews On :</strong> <span>{{$row->trial_ends_at}}</span></p>
                           </div>
                            
                           <div class="col-lg-offset-0 col-lg-4 col-md-offset-6 col-md-6 col-xs-12 mt-20">
                              <p>
                                  <a href="{{ asset('admin/business-detail-pdf/'.$row->id) }}"><button type="button" class="btn btn-primary btn-oval">Export PDF</button></a> 
                                  @if($row->is_active == 1)
                                   <a href="{{ asset('admin/disable-user/'.$row->id.'/business')}}"><button type="button" class="btn btn-oval btn-danger">Disable User</button></a>
                                   @else
                                   <a href="{{ asset('admin/active-user/'.$row->id.'/business')}}"><button type="button" class="btn btn-oval btn-info">Enable User</button></a>
                                   @endif
                              </p>
                           </div>
                            @endforeach
                        </div>
                        <!-- Currently Active Offer Table -->
                        <div class="row">
                           <div class="col-lg-12">
                              <h3>Currently Active Offer</h3>
                              <div class="panel panel-default">
                                 <div class="panel-body">
                                    <div class="col-xs-12">
                                       <div class="table-responsive user-detail-table">
                                          <table  class="table table-striped table-hover">
                                             <thead>
                                                <tr>
                                                   <th>Offer Name</th>
                                                   <th>Code</th>
                                                   <th>Created</th>
                                                   <th>Redeemed</th>
                                                   <th>Active</th>
                                                   <th>Valid Until</th>
                                                   <th>Radius</th>
                                                   <th>Geofencing Area</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                 @foreach($active_list as $row)
                                                <tr>
                                                   <td>{{$row->coupon_name}}</td>
                                                   <td>{{$row->coupon_code}}</td>
                                                   <td>{{$row->coupon_redeem_limit}}</td>
                                                   <td>{{$row->redeemed}}</td>
                                                   <td>{{$row->coupon_redeem_limit - $row->redeemed}}</td>
                                                   <td>{{$row->coupon_end_date}}</td>
                                                   <td>{{$row->coupon_radius}}</td>
                                                   <td>{{$row->coupon_notification_sqfeet}}</td>
                                                </tr>
                                                @endforeach
                                             </tbody>
                                          </table>
                                           {{ $active_list->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Additional Items Purchased Table -->
                        <div class="row">
                           <div class="col-lg-12">
                              <h3>Additional Items Purchased</h3>
                              <div class="panel panel-default">
                                 <div class="panel-body">
                                    <div class="col-xs-12">
                                       <div class="table-responsive user-detail-table">
                                          <table id="table3" class="table table-striped table-hover">
                                             <thead>
                                                <tr>
                                                   <th>Purchased On</th>
                                                   <th>Type</th>
                                                   <th>Quanity</th>
                                                   <th>Amount</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                 @foreach($additional_list as $row)
                                                <tr>
                                                   <td>{{$row->created_at}}</td>
                                                   <td>{{$row->addon_type }}</td>
                                                   <td>{{$row->quantity}}</td>
                                                   <td>$ {{$row->quantity * 4.99}}</td>
                                                </tr>
                                                @endforeach
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Current Balances Table -->
                        <div class="row">
                           <h3 class="col-xs-12">Current Balances</h3>
                           <!-- Remaining Deals -->
                           <div class="col-lg-4 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                 <div class="panel-body">
                                    <div class="col-xs-12">
                                       <h4 class="mb-20">Remaining Deals ({{$used_deal}})</h4>
                                       @if($used_deal > 0)
                                       <canvas id="remainingDeals" style="max-width: 200px; margin: 0px auto;"></canvas>
                                       @else
                                       This Vendor has no remaining Deals
                                       @endif
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Remaining Miles -->
                           <div class="col-lg-4 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                 <div class="panel-body">
                                    <div class="col-xs-12">
                                       <h4 class="mb-20">Remaining Miles ({{$used_mile}})</h4>
                                       @if($used_mile > 0)
                                       <canvas id="remainingMiles" style="max-width: 200px; margin: 0px auto;"></canvas>
                                       @else
                                       This Vendor has no remaining Miles
                                       @endif
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Remaining Geofencing -->
                           <div class="col-lg-4 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                 <div class="panel-body">
                                    <div class="col-xs-12">
                                       <h4 class="mb-20">Remaining Geofencing  ({{$used_geo}})</h4>
                                       @if($used_geo > 0)
                                       <canvas id="remainingGeofencing" style="max-width: 200px; margin: 0px auto;"></canvas>
                                       @else
                                       This Vendor has no remaining Geofancing
                                       @endif
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
      <script src="{{ asset('vendor/admin/chart.js/dist/Chart.js')}}"></script>

      <!-- =============== APP SCRIPTS ===============-->
      <script src="{{ asset('js/admin/app.js')}}"></script>
      <script src="{{ asset('js/admin/cusom.js')}}"></script>

      <script>
         $(function(){
            // Pie chart
              // -----------------------Remaining Deals-----------------------
              var remainingDeals = {
                  labels: [
                      'Remaining',
                      'Used'
                  ],
                  datasets: [{
                      data: ['{{$used_deal}}', '{{$total_deal}}'],
                      backgroundColor: [
                          '#4bba6d',
                          '#3b5898'
                      ],
                      hoverBackgroundColor: [
                          '#4bba6d',
                          '#3b5898'
                      ]
                  }]
              };

              var pieOptions = {
                  legend: {
                      display: false
                  }
              };
              var piectx = document.getElementById('remainingDeals').getContext('2d');
              var pieChart = new Chart(piectx, {
                  data: remainingDeals,
                  type: 'pie',
                  options: pieOptions
              });
              // -----------------------Remaining Miles-----------------------
              var remainingMiles = {
                  labels: [
                      'Remaining',
                      'Used'
                  ],
                  datasets: [{
                      data: [{{$total_mile?:'0'}}, {{$used_mile?:'0'}}],
                      backgroundColor: [
                          '#4bba6d',
                          '#3b5898'
                      ],
                      hoverBackgroundColor: [
                          '#4bba6d',
                          '#3b5898'
                      ]
                  }]
              };

              var pieOptions = {
                  legend: {
                      display: false
                  }
              };
              var piectx = document.getElementById('remainingMiles').getContext('2d');
              var pieChart = new Chart(piectx, {
                  data: remainingMiles,
                  type: 'pie',
                  options: pieOptions
              });
              // -----------------------Remaining Geofencing-----------------------
              var remainingGeofencing = {
                  labels: [
                      'Remaining',
                      'Used'
                  ],
                  datasets: [{
                      data: [{{$total_geo?:'0'}}, {{$used_geo?:'0'}}],
                      backgroundColor: [
                          '#4bba6d',
                          '#3b5898'
                      ],
                      hoverBackgroundColor: [
                          '#4bba6d',
                          '#3b5898'
                      ]
                  }]
              };

              var pieOptions = {
                  legend: {
                      display: false
                  }
              };
              var piectx = document.getElementById('remainingGeofencing').getContext('2d');
              var pieChart = new Chart(piectx, {
                  data: remainingGeofencing,
                  type: 'pie',
                  options: pieOptions
              });
         });
      </script>
   </body>
</html>