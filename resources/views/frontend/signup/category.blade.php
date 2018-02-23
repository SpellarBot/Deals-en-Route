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
<div class="errorpopup">
    <div class="alert alert-success alert-dismissible" role="alert" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="successmessage"> </div>
    </div>  
    <div class="alert alert-danger alert-dismissible" role="alert" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="errormessage"> </div>
    </div>  
</div>
<section class="registerPage">
    <div class="container">
        <h1>Register Your Business</h1>
        <h3>Congratulations! One more step to pushing your business to new heights! You have a 30-day free trial — Way less than what you spend on a current advertising methods collectively!</h3>
        <div class="box-container reg-icon-list">
            <div class="row">
                @foreach ($category_images as $category_image)

                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                    <div class="box">
                        <a href=""  class="box-bg clickopen" data-toggle="modal" data-id="{{ $category_image->category_id }}">
                            <img src="{{ $category_image->category_image }}">
                            <span> {{ $category_image->category_name }}</span>
                        </a>
                    </div>
                </div>                
                @endforeach

                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                    <div class="box">
                        <a href=""  class="box-bg" data-toggle="modal" data-target="#otherCategoryModal">
                            <img src="storage/app/public/category_image/33.png">
                            <span>Other</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend/modal/signup')

<div id="otherCategoryModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                Other Category
            </div>
            <div class="modal-body">
                <div class="col-sm-12"><br>
                    <div class="package-add">
                        <form id="requestCategory">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Add Category:</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Add Category" name="category" required=""> 
                                    </div>
                                    <label>Email Address:</label>
                                    <div class="form-group">
                                        <input type="email" placeholder="Email Address" name="request_email" required="">
                                    </div>
                                </div>
                                <div class="col-xs-12 text-center">
                                    <button type="submit" class="btn btn-priamry btn-save">Save</button>    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>

    </div>
</div>


@endsection
@section('scripts')
<script src="{{ asset('frontend/js/webjs/register.js?reload=1318923150"') }}"></script>
<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ \Config::get('googlemaps.key') }}&libraries=places&callback=initAutocomplete"
async defer></script>


@endsection
