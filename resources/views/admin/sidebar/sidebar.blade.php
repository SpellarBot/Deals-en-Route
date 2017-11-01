   <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="profile-element profile-element-name">
                             <?php $image=\Config::get('app.url') . \Config::get('constants.IMAGE_PATH') . '/images/logo.png' ?>
                           <span>
                            <img alt="image" class="img-circle" src="<?php echo $image;?>" />
                             </span>
                            <h2>Deals en route</h2>                            
                        </div>
                      
                    </li>
    
                    <li class="{{ Request::segment(2) === 'users' ? 'active' : null }}">
                
                        <a href="{{ url('/admin/users') }}"  title="Users"><i class="fa fa-users"></i> <span class="nav-label"> Users </span> </a>
                    </li>
                   <li class="{{ Request::segment(2) === 'vendors' ? 'active' : null }}">
                        <a href="{{ url('/admin/vendors') }}"  title="Vendors"><i class="fa fa-users"></i> <span class="nav-label"> Vendors </span> </a>
                    </li>
                     <li class="{{ Request::segment(2) === 'settings' ? 'active' : null }}">
                        <a href="{{ url('/admin/settings') }}"  title="Settings"><i class="fa fa-gear"></i> <span class="nav-label"> Setting </span> </a>
                    </li>
                    <!--<li>
                        <a data-toggle="modal" data-target="#address-book" href="#"><i class="fa fa-book"></i> <span class="nav-label">Address Book</span>  </a>
                    </li>-->
                </ul>
            </div>
        </nav>