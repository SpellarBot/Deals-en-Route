   <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="profile-element profile-element-name">
                             <?php $image=\Config::get('app.url') . \Config::get('constants.IMAGE_PATH') . '/images/logo.png' ?>
                           <span>
                            <img alt="image" class="img-circle" src="<?php echo $image;?>" />
                             </span>
                                                  
                        </div>
                      
                    </li>
    
                    <li class="{{ Request::segment(2) === 'users' ? 'active' : null }}">
                
                        <a href="{{ url('/admin/users') }}"  title="Users"><i class="fa fa-users"></i> <span class="nav-label"> Users </span> </a>
                    </li>
                  
                   
                     
                    <!--<li>
                        <a data-toggle="modal" data-target="#address-book" href="#"><i class="fa fa-book"></i> <span class="nav-label">Address Book</span>  </a>
                    </li>-->
                </ul>
            </div>
        </nav>