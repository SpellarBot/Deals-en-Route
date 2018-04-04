@extends('frontend.layouts.price')
@section('title', 'Deals en Route|Subscription')
@section('content')

<div id="loadingDiv"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/489.gif' ?>" class="loading-gif"></div>

<div class="errorpopup">

        <div class="alert-fade alert-success custom-alert"  style="display: none">
            <div class="alert  alert-success alert-dismissable" role="alert"  >
                <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <div class="tick-mark-circle"></div>
                <div class="alert-content">
                    <h3 class="success-text">Success</h3>
                    {{ Session::get('success') }}
                </div>
                <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
            </div>
        </div>

        <div class="alert-fade alert-danger custom-alert" style="display: none">
            <div class="alert alert-danger alert-dismissable" role="alert"  >
                <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <div class="close-circle"></div>
                <div class="alert-content">
                    <h3 class="success-text">Failed</h3>
                    {{ Session::get('error') }}
                </div>
                <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
            </div>
        </div>

    </div>  

<section class="prices">
    <div class="container">
        <div class="row p-flex">
            <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3 cardm">
                <p class="head">GOLD</p>
                <p class="price"><sup>$</sup>149</p>
                <p class="price-pm">PER MONTH</p>
                <p class="deals">~ Create and Send Coupons
                    <br><br> ~ Geolocation (Up to 10 mile radius)
                    <br><br> ~ Geofencing (one per deal up to 20,000 Sq. Feet)
                    <br><br> ~ Analytics (Age + Gender)
                    <br><br> ~ 30 Deals/ Unlimited Coupons
                    <br><br> ~ Sticker for Store window (Deals en Route certified)</p>
                <p class="head2">Additional Packages</p>
                <p class="deals">Geolocation - $4.99/additional mile
                    <br><br> Geo Fencing - $4.99/20,000 square feet</p>
                <p class="discl">*Coupons don't roll/carry over to next month
                    <br><br> *Commission is equal to 30% of the face value discount the coupon provides. If this is less than $1.00, DER will receive $1.00</p>
                <button type="button" class="btn btn-want" value="gold">I want this one</button>
            </div>
            <div class="col-md-4 col-sm-6 cards cards2">
                <p class="head">SILVER</p>
                <p class="price"><sup>$</sup>99</p>
                <p class="price-pm">PER MONTH</p>
                <p class="deals">~ Create and Send Coupons
                    <br><br> ~ Geolocation (Up to 5 mile radius)
                    <br><br> ~ Geofencing (one per deal up to 20,000 Sq. Feet)
                    <br><br> ~ Analytics (Age)
                    <br><br> ~ 20 Deals / Unlimited Coupons
                    <br><br> ~ Sticker for Store window (Deals en Route certified)</p>
                <p class="head2">Additional Packages</p>
                <p class="deals">Geolocation - $4.99/additional mile
                    <br><br> Geo Fencing - $4.99/20,000 square feet</p>
                <p class="discl">*Coupons don't roll/carry over to next month
                    <br><br> *Commission is equal to 30% of the face value discount the coupon provides. If this is less than $1.00, DER will receive $1.00</p>
                <button type="button" class="btn btn-want" value="silver">I want this one</button>
            </div>
            <div class="col-md-4 col-sm-6 cards cards1">
                <p class="head">BRONZE</p>
                <p class="price"><sup>$</sup>49</p>
                <p class="price-pm">PER MONTH</p>
                <p class="deals">~ Create and Send Coupons
                    <br><br> ~ Geolocation (Up to 1 mile radius)
                    <br><br> ~ Geofencing (one per deal up to 20,000 Sq. Feet)
                    <br><br> ~ 10 Deals / Unlimited Coupons
                    <br><br> ~ Sticker for Store window (Deals en Route certified)</p>
                <p class="head2">Additional Packages</p>
                <p class="deals">Geolocation - $4.99/additional mile
                    <br><br> Geo Fencing - $4.99/20,000 square feet</p>
                <p class="discl">*Coupons don't roll/carry over to next month
                    <br><br> *Commission is equal to 30% of the face value discount the coupon provides. If this is less than $1.00, DER will receive $1.00</p>
                <button type="button" class="btn btn-want btn-want1" value="bronze">I want this one</button>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript">
    $('.btn-want').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: $('#hidAbsUrl').val() + "/register/subcription",
            type: 'POST',
            data: {'plan_id': $(this).val(), 'user_id': "<?php echo $user_id ?>"},
            success: function (data) {
                location.reload();
            },
            beforeSend: function () {
                $('#loadingDiv').show();
            },
            complete: function () {
                $('#loadingDiv').hide();
            },
            error: function (data) {
                window.location.href = 'http://dealsenroute.com/dealenroute';
            },

        });

    });
</script>   

@endsection

