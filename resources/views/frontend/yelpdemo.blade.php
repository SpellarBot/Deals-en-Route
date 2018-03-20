@extends('frontend.layouts.login')
@section('title', 'Deals en Route|Report a Problem')
@section('content')

<header class="staticpage">
    <div class="container">
        <div class="header">
            <div class="row">
                <div class="col-sm-6">
                    <a href="{{ route('vendorindex')}}" class="logo"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/logo.png' ?>"></a>
                </div>
                <div class="col-sm-6 text-right">
                    <h2>yelp demo</h2>
                </div>
            </div>
        </div>
    </div>
</header>

 {{ Form::open(['route' => 'users.store', 'class' => 'form','id'=>'yelpform']) }}
<div class="form-group">

    {{ Form::text('vendor_address', '', ['placeholder'=>'Street Address','class'=>'form-control','id'=>'autocomplete1']) }}
</div>
 <div class="form-group">
        <input type="search" name="tag_list" id="vendor_name" class="form-control search-input" placeholder="Search">
      </div>
  <div class="form-group">
                      
                        <select class="js-example-basic-single1" name="tag_list1" ></select>
                    </div>
 <br>
 <br>
 <button type="submit" class="btn btn-priamry ">Sign Up</button>
 <div class="yelpname"> </div>
 
      {{ Form::close() }}
@endsection
@section('scripts')

 <script src="{{ asset('frontend/js/jquery.easy-autocomplete.min.js') }}"></script> 


<script type="text/javascript" src="{{ asset('frontend/js/webjs/register.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ \Config::get('googlemaps.key') }}&libraries=places&callback=initAutocomplete"
async defer></script>
@endsection
