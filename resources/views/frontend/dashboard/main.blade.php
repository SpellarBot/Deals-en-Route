@extends('frontend.layouts.dashboard')
@section('title', 'Deals en Route|Index')
@section('content')


<div class="main-panel">   	
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar bar1"></span> <span class="icon-bar bar2"></span> <span class="icon-bar bar3"></span> </button>
                <p class="navbar-brand">Hello, {{ Auth::user()->vendorDetail->vendor_name }} </p>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon fa fa-user"></i>
                            <p>User</p>
                            <b class="caret"></b> </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('vendor.logout') }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                    Sign Out
                                </a>

                                <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="content">

        <div class="tab-content">

            @include('frontend/dashboard/dash',['year'=>$year])
            @include("frontend/coupon/couponlist",['coupon_lists'=>$coupon_lists])
            @include("frontend/coupon/create",['currenttime'=>$currenttime,'user_access'=>$user_access])
            <div id="settings" class="tab-pane fade in">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="header">
                                    <h5 class="title">Company Details</h5>
                                </div>
                                <div class="content">
                                    <form class="editCompanyDetails">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->vendor_name != '' ) {{$vendor_detail->vendor_name}} @else Business Name @endif" name="vendor_name">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" id="autocomplete1" name="vendor_address" type="text" placeholder="@if($vendor_detail->vendor_address != '' ) {{$vendor_detail->vendor_address}} @else Address @endif" value="" autocomplete="off">

<!--<input type="text" placeholder="@if($vendor_detail->vendor_address != '' ) {{$vendor_detail->vendor_address}} @else Address @endif" name="vendor_address">-->
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->vendor_city != '' ) {{$vendor_detail->vendor_city}} @else City @endif" name="vendor_city">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->vendor_state != '' ) {{$vendor_detail->vendor_state}} @else State @endif" name="vendor_state">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->vendor_zip != '' ) {{$vendor_detail->vendor_zip}} @else Zip Code @endif" name="vendor_zip">
                                                </div>
                                                <div class="form-group">
                                                    <input type="tel" name="vendor_phone" placeholder="@if($vendor_detail->vendor_phone != '' ) {{$vendor_detail->vendor_phone}} (x-xxx-xxx-xxxx) @endif (x-xxx-xxx-xxxx)" pattern="^\d{1}-\d{3}-\d{3}-\d{4}$" maxlength="11" required>
                                                </div>
                                                <!--                                                <div class="form-group">
                                                                                                 <input type="email" placeholder="Email" required>
                                                                                                </div>-->
                                            </div>
                                        </div>
                                        <div class="header">
                                            <h5 class="title">Billing Information</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->billing_businessname != '' ) {{$vendor_detail->billing_businessname}} @else Billing Businessname @endif" name="billing_businessname">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->billing_home != '' ) {{$vendor_detail->billing_home}} @else Business Billing Home @endif" name="billing_home">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->billing_city != '' ) {{$vendor_detail->billing_city}} @else Business Billing City @endif" name="billing_city">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->billing_state != '' ) {{$vendor_detail->billing_state}} @else Business Billing State @endif" name="billing_state">
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" name="billing_country">
                                                        <option>Country</option>
                                                        @foreach($country_list as $key=>$value)
                                                        @if($vendor_detail->billing_country == $value)
                                                        <option value="{{ $key }}" selected="selected">{{ $value }}</option>
                                                        @else
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <fieldset>
                                                    <input type="file" name="vendor_logo" id="file" accept="image/*" />
                                                </fieldset>
                                                <ul class="list-inline pad-top1 pull-right">
                                                    <li>
                                                        <button type="submit" class="btn btn-create">Submit</button>
                                                    </li>
                                                </ul>
                                                </form>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="header">
                                    <h5 class="title">Edit Credit/Debit Card Info</h5>
                                </div>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form class="editCreditCard">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <div class="input-group"> <span class="input-group-addon"> <span class="type"></span> </span>
                                                        <input class="cardNumber type" name="card_no" placeholder="xxxx xxxx xxxx {{$vendor_detail->card_last_four}}" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" placeholder="{{$vendor_detail->vendor_name}}" name="cardholder_name">
                                                </div>
                                                <div class="form-group">
                                                        <!-- <input type="text" placeholder="Expiration Date MM/YY" required> -->
                                                    <input class="expiry" placeholder="MM/YY" name="card_expiry" required />
                                                </div>
                                                <div class="form-group">
                                                        <!-- <input type="number" placeholder="CVV" required> -->
                                                    <input class="cvv" maxlength="4" placeholder="CVV" name="card_cvv" required />
                                                </div>

                                                <ul class="list-inline pad-top pull-right">
                                                    <li>
                                                        <button type="submit" class="btn btn-create">Submit</button>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="header">
                                    <h5 class="title">Change Password</h5>
                                </div>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{ Form::open([ 'id' => 'updatePassword']) }}
                                            <div class="form-group">

                                                {{ Form::password('current_password', ['placeholder'=>'Current Password','class'=>'form-control']) }}
                                            </div>
                                            <div class="form-group">
                                                {{ Form::password('password',  ['placeholder'=>'New Password','class'=>'form-control']) }}
                                            </div>
                                            <div class="form-group">
                                                {{ Form::password('password_confirm',  ['placeholder'=>'Re-Enter Password','class'=>'form-control']) }}
                                            </div>
                                            <ul class="list-inline pad-top pull-right">
                                                <li>
                                                    <button type="submit" class="btn btn-create">Submit</button>
                                                </li>
                                            </ul>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="contact" class="tab-pane fade in">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h5 class="title">Send us a Message</h5>
                                            <div class="row">
                                                <div class="col-md-12">       
                                                    {{ Form::open([ 'id' => 'sendcontact']) }}
                                                    {{ csrf_field() }}


                                                    <div class="form-group">

                                                        {{ Form::label('user_name', 'Name:') }}
                                                        {{ Form::text('user_name', '', ['class'=>'form-control']) }}

                                                    </div>
                                                    <div class="form-group">

                                                        {{ Form::label('email', 'Email:') }}
                                                        {{ Form::text('email', '', ['class'=>'form-control']) }}

                                                    </div>
                                                    <div class="form-group">

                                                        {{ Form::label('query', 'Query:') }}
                                                        {{ Form::textarea('query','',['class'=>'form-control','style'=>'height:200px !important']) }}

                                                    </div>
                                                    <ul class="list-inline pad-top">
                                                        <li>
                                                            <button type="submit" class="btn btn-create">Submit</button>
                                                        </li>
                                                    </ul>
                                                    {{ Form::close() }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <h5 class="title">Contact Information</h5>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ul class="table-contact">
                                                        <li>
                                                                <!-- <i class="fa fa-map-marker"></i> -->
                                                            <span>35 Street Bellasis, Albani, NY, USA</span>
                                                        </li>
                                                        <li>
                                                                <!-- <i class="fa fa-envelope"></i> -->
                                                            <span><a href="mailto:abc@xyz.com" style="color: #252422;">abc@xyz.com</a></span>
                                                        </li>
                                                        <li>
                                                                <!-- <i class="fa fa-mobile"></i> -->
                                                            <span>+1 231 564 879</span>
                                                        </li>
                                                        <li>
                                                            <div class="social-cont">
                                                                <div> <a target="_blank" href="#s"><i class="fa fa-facebook"></i> </a> </div>
                                                                <div> <a target="_blank" href="#"><i class="fa fa-linkedin"></i> </a> </div>
                                                                <div> <a target="_blank" href="#s"><i class="fa fa-twitter"></i> </a> </div>
                                                                <div> <a target="_blank" href="#"><i class="fa fa-instagram"></i> </a> </div>
                                                            </div>
                                                        </li>
                                                    </ul>
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

    @include('frontend/footer/footer_dash')
</div>

@endsection