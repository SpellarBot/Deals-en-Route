<div class="sidebar" data-background-color="white" data-active-color="success">
    <div class="sidebar-wrapper">
        <div class="logo"> <a href="{{ url('/dashboard') }}"> <img width="60" src="<?php echo \Config::get('app.url') . '/public/frontend/img/logo.png' ?>" ></a> </div>
        <ul class="nav nav1" id="groupTab">
            <li > <a  href="{{ url('/dashboard') }}"> <i class="icon fa fa-dashboard"></i>
                    <p>Dashboard</p>
                </a> </li>
            <li class="active"> <a  href="{{ URL::route('frontend.main') }}#create"> <i class="icon fa fa-tag"></i>
                    <p>Create Coupon</p>
                </a> </li>
            <li> <a  href="{{ URL::route('frontend.main') }}#settings"> <i class="icon fa fa-cog"></i>
                    <p>Settings</p>
                </a> </li>
            <li> <a href="{{ URL::route('frontend.main') }}#contact"> <i class="icon fa fa-envelope"></i>
                    <p>Contact Us</p>
                </a> </li>
        </ul>
    </div>
</div>