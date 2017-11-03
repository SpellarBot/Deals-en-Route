@extends('frontend.layouts.login')
@section('title', 'Deals en Route|Category')
@section('content')
<header>
         <div class="container">
                 <div class="header">
                         <a href="" class="logo"><img src="{{ $company_logo }}" /></a>
                 </div>
         </div>
 </header>
<section class="registerPage">
		<div class="container">
			<h1>Register Your Business</h1>
			<h3>Congratulations! One more step to pushing your business to new heights! You have a 30-day free trial — Way less than what you spend on a current advertising methods collectively!</h3>
			<div class="box-container">
	                  <div class="row">
                             @foreach ($category_images as $category_image)
  
                                 <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                         <div class="box">
                                                 <a href=""  class="box-bg clickopen" data-toggle="modal" data-id="{{ $category_image->category_id }}">
                                                         <img src="{{ $category_image->category_image }}">
                                                         <span> {{ $category_image->category_name }}</span>
                                                 </a>
                                         </div>
                                 </div>
                            
                            @endforeach
                         </div>
                 </div>
         </div>
 </section>
 @include('frontend/modal/signup')
@endsection
@section('scripts')

<script src="{{ asset('frontend/js/webjs/register.js?reload=1318923150"') }}"> </script>

@endsection
