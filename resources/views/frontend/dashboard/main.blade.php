@extends('frontend.layouts.dashboard')
@section('title', 'Deals en Route|Index')
@section('content')
@include('frontend/modal/miles',['currenttime'=>$currenttime,'user_access'=>$user_access])
@include('frontend/modal/geofence',['currenttime'=>$currenttime,'user_access'=>$user_access])

<div class="main-panel">   	
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                
                <button type="button" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar bar1"></span> <span class="icon-bar bar2"></span> <span class="icon-bar bar3"></span> </button>
    
                <p class="navbar-brand">
                 
                    Hello, {{ Auth::user()->vendorDetail->vendor_name }} </p>
            </div>
            <div class="collapse navbar-collapse">
                 
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                    <div class="free-trial">  
                             <p>{{ ($is_free_trial['is_trial']==1)?"Free Trial Account": ($is_free_trial['days_left'])." days left" }} </p>  
                        </div>
                    </li>
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
            @include('frontend/dashboard/dash',['year'=>$year,'total_age_wise_redeem'=>$total_age_wise_redeem])
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
                                    <div class="row">
                                        <form class="editCompanyDetails">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->vendor_name != '' ) {{$vendor_detail->vendor_name}} @else Business Name @endif" name="vendor_name">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" id="autocomplete1" name="vendor_address" type="text" placeholder="@if($vendor_detail->vendor_address != '' ) {{$vendor_detail->vendor_address}} @else Address @endif" value="" autocomplete="off">

<!--<input type="text" placeholder="@if($vendor_detail->vendor_address != '' ) {{$vendor_detail->vendor_address}} @else Address @endif" name="vendor_address">-->
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->vendor_city != '' ) {{$vendor_detail->vendor_city}} @else City @endif" name="vendor_city" id="locality">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->vendor_state != '' ) {{$vendor_detail->vendor_state}} @else State @endif" name="vendor_state" id="administrative_area_level_1">
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" name="vendor_country" id="country">
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
                                                <div class="form-group">
                                                    <input type="text" placeholder="@if($vendor_detail->vendor_zip != '' ) {{$vendor_detail->vendor_zip}} @else Zip Code @endif" name="vendor_zip" id="postal_code">
                                                </div>
                                                <div class="form-group">
                                                    <input type="tel" name="vendor_phone" placeholder="@if($vendor_detail->vendor_phone != '' ) {{$vendor_detail->vendor_phone}} (x-xxx-xxx-xxxx) @endif (x-xxx-xxx-xxxx)" pattern="^\d{1}-\d{3}-\d{3}-\d{4}$" maxlength="15">
                                                </div>
                                                <fieldset>
                                                    <!-- <input type="file" name="vendor_logo" id="file" accept="image/*" /> -->
                                                    <label for="file" class="file-upload__label">Upload Vendor Logo</label>
                                                    <input id="file" class="file-upload__input" type="file" name="vendor_logo" accept="image/*">
                                                </fieldset>
                                                <!--                                                <div class="form-group">
                                                                                                 <input type="email" placeholder="Email" required>
                                                                                                </div>-->
                                            </div>
                                            <div class="header">
                                                <h5 class="title">Billing Information</h5>
                                            </div>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h5 class="title">Package Details</h5>
                                    </div>
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="package-title">Current Package:</h5>
                                                @if($subscription['sub_id'] != '')
                                                <p class="package-details text-capitalize">{{$subscription['stripe_plan']}}
                                                    <!--<small>$99 per month</small>-->
                                                </p>
                                                <a href="{{URL::route('changesubscription')}}" type="button" class="btn btn-pack">Change</a>
                                                <a href="{{URL::route('cancelsub')}}" type="button" class="btn btn-pack btn-danger">Cancel</a>
                                                @else
                                                <p class="package-details text-capitalize">Subscribe
                                                    <small>Now</small>
                                                </p>
                                                <a href="{{URL::route('changesubscription')}}" type="button" class="btn btn-pack">Subscribe</a>
                                                @endif

                                            </div>
                                            <div class="col-md-12 mar-top30">
                                                <h5 class="package-title">Additional Items:</h5>
                                                <div class="package-add">
                                                    <p class="package-addon1">Additional-Miles</p>
                                                    <p class="package-addon2">Additional-Miles - $4.99/mile</p>
                                                    <form class="additional_miles">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="extra_miles">
                                                                        <option value="">Select Miles</option>
                                                                        @for($i=1;$i<=30;$i++)
                                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                                        @endfor
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-pack btn-buy1">Buy</button>

                                                        </div>

                                                    </form>
                                                    <p class="package-addon3">Available Miles - {!! number_format($total_location) !!} Miles</p>    
                                                </div>
                                                <div class="package-add">
                                                    <p class="package-addon1">Geo-Fencing</p>
                                                    <p class="package-addon2">Geo-Fencing - $4.99/20,000 sq.ft.</p>
                                                    <form class="geo_fencing">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="extra_fensing_area">
                                                                        <option value="">Select Fencing</option>
                                                                        <option value="20000">20,000</option>
                                                                        <option value="40000">40,000</option>
                                                                        <option value="60000">60,000</option>
                                                                        <option value="80000">80,000</option>
                                                                        <option value="100000">1,00,000</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-pack btn-buy1">Buy</button>

                                                        </div>

                                                    </form>
                                                    <p class="package-addon3">Available geo fencing -{!! number_format($total_geofencing,2) !!} sq.ft</p>
                                                </div>
                                                <div class="package-add">
                                                    <p class="package-addon1">Additional-Deals</p>
                                                    <p class="package-addon2">Additional-Deals - $4.99/deal</p>
                                                    <form class="additional_deals">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="extra_deals">
                                                                        <option value="">Select Deals</option>
                                                                        @for($i=1;$i<=30;$i++)
                                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-pack btn-buy1">Buy</button>

                                                        </div>

                                                    </form>
                                                    <p class="package-addon3">Available deals  - {!! number_format($deals_left) !!} deals</p>
                                                </div>
                                            </div>
                                        </div>
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

                        <div class="card hours-opration">
                            <div class="header">
                                <h5 class="title">Hours of operation</h5>
                            </div>
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{ Form::open([ 'id' => 'hoursOfOperation']) }}
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="hours-opration-col1 pb-15"><label>Days</label></div>
                                            <div class="hours-opration-col2 text-center pb-15"><label>From</label></div>
                                            <div class="hours-opration-col2 text-center pb-15"><label>To</label></div>
                                            
                                        </div>
                                      
                                        @foreach ($listWeeks as $key=>$value)
                                        <div class="row-out">
                                        <div class="row datepair">

                                            <input type="hidden" value="{{$key+1}}" id="datePairvalue">
                                            <div class="hours-opration-col1"><p class="package-addon1">{{ucfirst($value)}}</p></div>
                                            <input type="hidden" name="{{$value}}[]" value="{{$key+1}}"/>

                                            <div class="hours-opration-col2">
                                                <div class="form">
                                                             {{ Form::text($value."[fromtime]", empty($hoursofoperation[$key+1]['open_time'])?"":$hoursofoperation[$key+1]['open_time'], 
                                                                 ['placeholder'=>'00:00 AM','class'=>'form-control time start','id'=>"fromtimepicker".($key+1),
                                                                  'disabled'=>(isset($hoursofoperation[($key+1)]['is_closed'])&& $hoursofoperation[($key+1)]['is_closed']==1)?true:false]) }}
                                                  </div>
                                            </div>
                                            <div class="hours-opration-col2">
                                                <div class="form">
                                                                  {{ Form::text($value."[totime]", empty($hoursofoperation[$key+1]['close_time'])?"":$hoursofoperation[$key+1]['close_time'], 
                                                                 ['placeholder'=>'00:00 PM','class'=>'form-control time end','id'=>"totimepicker".($key+1),
                                                                  'disabled'=>(isset($hoursofoperation[($key+1)]['is_closed'])&& $hoursofoperation[($key+1)]['is_closed']==1)?true:false]) }}
                                                 </div>
                                            </div>  
                                              
                                          
                                   
                                        </div>
                                         <div class="hours-opration-col3">
                                                <div class="form fillall-checkbox">
                                                       {{ Form::checkbox($value."[is_closed]", '1',(isset($hoursofoperation[($key+1)]['is_closed'])&& $hoursofoperation[($key+1)]['is_closed']==1)?true:false,['class' => 'fill_checkbox','id'=>($key+1)]) }}
                                                       <small></small>
                                                       <span>closed</span>
                                                 </div>
                                             </div>
                                        </div>     
                                        @endforeach

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

                                                    {{ Form::label('query', 'Message:') }}
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
                                                        <span><a href="mailto:{{ \Config::get('constants.CLIENT_MAIL') }}" style="color: #252422;">{{ \Config::get('constants.CLIENT_MAIL') }}</a></span>
                                                    </li>
                                                    <li>
                                                            <!-- <i class="fa fa-mobile"></i> -->
                                                        <span><a href="tel:1231564879"> +1 231 564 879</a></span>
                                                    </li>
                                                    <li>
                                                        <div class="social-cont">
                                                            <div> <a target="_blank" href="{{ \Config::get('constants.FACEBOOK_LINK') }}"><i class="fa fa-facebook"></i> </a> </div>
                                                            <div> <a target="_blank" href="{{ \Config::get('constants.LINKDIN_LINK') }}"><i class="fa fa-linkedin"></i> </a> </div>
                                                            <div> <a target="_blank" href="{{ \Config::get('constants.TWITTER_LINK') }}"><i class="fa fa-twitter"></i> </a> </div>
                                                            <div> <a target="_blank" href="{{ \Config::get('constants.INSTAGRAM_LINK') }}"><i class="fa fa-instagram"></i> </a> </div>
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
