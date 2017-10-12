   <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="profile-element profile-element-name">
                            <h2>Deals en route</h2>                            
                        </div>
                      
                    </li>
       

                    <li @if(\Request::path()=='/') class= "active" @endif >
                        <a href="{{ url('/') }}"  title="Reminder"><i class="fa fa-bell"  ></i> <span class="nav-label"> Users </span> </a>
                    </li>
                  
                    <!--<li>
                        <a data-toggle="modal" data-target="#address-book" href="#"><i class="fa fa-book"></i> <span class="nav-label">Address Book</span>  </a>
                    </li>-->
                </ul>
            </div>
        </nav>