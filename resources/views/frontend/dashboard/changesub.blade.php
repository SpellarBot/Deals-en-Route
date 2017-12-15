@extends('frontend.layouts.price')
@section('title', 'Deals en Route|Subscription')
@section('content')

<?php $name = ""; ?>
@if($subscription['stripe_plan'] == 'gold')
<?php $name = "Downgrade"; ?>
@elseif($subscription['stripe_plan'] == 'bronze')
<?php $name = "Upgrade"; ?>
@else
<?php $name = ""; ?>
@endif
<div id="loadingDiv"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/489.gif' ?>" class="loading-gif"></div>

<div class="errorpopup">

    <div class="alert alert-success alert-dismissible" role="alert" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('success') }}
    </div>  


    <div class="alert alert-danger alert-dismissible" role="alert" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('error') }}
    </div>  
</div>    

<section class="prices">
    <div class="container">
        <div class="row p-flex">
            @if($subscription['subscriptioncanceled'] && $subscription['subscriptioncanceled'] == 1)
            <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3 cardm">
                @else
                @if($subscription['stripe_plan'] == 'gold' && $subscription['sub_id'] != '')
                <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3 cardm">
                    @elseif($subscription['stripe_plan'] == 'silver')
                    <div class="col-md-4 col-sm-6 cards cards2">
                        @else
                        <div class="col-md-4 col-sm-6 cards cards1">
                            @endif
                            @endif
                            <p class="head">GOLD</p>
                            <p class="price"><sup>$</sup>149</p>
                            <p class="price-pm">PER MONTH</p>
                            <p class="deals">~ Create and Send Coupons
                                <br><br> ~ Geolocation (Mile Radius 5-10 miles)
                                <br><br> ~ Geofencing (one per deal up to 20,000 Sq. Feet)
                                <br><br> ~ Analytics ( Age + Gender + Coupon Views + Potential Customer Reach)
                                <br><br> ~ 30 Deals/ Unlimited Coupons
                                <br><br> ~ Sticker for Store window (Deals en Route certified)</p>
                            <p class="head2">Additional Packages</p>
                            <p class="deals">Geolocation - $4.99/additional mile
                                <br><br> Geo Fencing - $4.99/20,000 square feet</p>
                            <p class="discl">*Coupons don't roll/carry over to next month
                                <br><br> *Commission is equal to 30% of the face value discount the coupon provides. If this is less than $1.00, DER will receive $1.00</p>
                            @if($subscription['subscriptioncanceled'] && $subscription['subscriptioncanceled'] == 1)
                            <button type="button" class="btn btn-want" value="gold">I want this one</button>
                            @else
                            @if($subscription['stripe_plan'] == 'gold')
                            <button type="button" class="btn btn-want" value="gold">Current Package</button>
                            @elseif($subscription['stripe_plan'] == 'silver')
                            <button type="button" class="btn btn-want" value="gold" id="upgrade">Upgrade</button>
                            @else
                            <button type="button" class="btn btn-want" value="gold" id="{{$name}}">{{$name}}</button>
                            @endif
                            @endif
                        </div>
                        @if($subscription['stripe_plan'] == 'silver' && $subscription['sub_id'] != '')
                        <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3 cardm">
                            @else
                            <div class="col-md-4 col-sm-6 cards cards2">
                                @endif

                                <p class="head">SILVER</p>
                                <p class="price"><sup>$</sup>99</p>
                                <p class="price-pm">PER MONTH</p>
                                <p class="deals">~ Create and Send Coupons
                                    <br><br> ~ Geolocation (Mile Radius 1-5 Miles)
                                    <br><br> ~ Geofencing (one per deal up to 20,000 Sq. Feet)
                                    <br><br> ~ Analytics ( Age + Gender)
                                    <br><br> ~ 20 Deals / Unlimited Coupons
                                    <br><br> ~ Sticker for Store window (Deals en Route certified)</p>
                                <p class="head2">Additional Packages</p>
                                <p class="deals">Geolocation - $4.99/additional mile
                                    <br><br> Geo Fencing - $4.99/20,000 square feet</p>
                                <p class="discl">*Coupons don't roll/carry over to next month
                                    <br><br> *Commission is equal to 30% of the face value discount the coupon provides. If this is less than $1.00, DER will receive $1.00</p>
                                @if($subscription['subscriptioncanceled'] && $subscription['subscriptioncanceled'] == 1)
                                <button type="button" class="btn btn-want" value="silver">I want this one</button>
                                @else
                                @if($subscription['stripe_plan'] == 'silver')
                                <button type="button" class="btn btn-want" value="silver">Current Package</button>
                                @else
                                <button type="button" class="btn btn-want" value="silver" id="{{$name}}">{{$name}}</button>
                                @endif
                                @endif

                            </div>
                            @if($subscription['stripe_plan'] == 'bronze' && $subscription['sub_id'] != '')
                            <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3 cardm">
                                @else
                                <div class="col-md-4 col-sm-6 cards cards1">
                                    @endif
                                    <p class="head">BRONZE</p>
                                    <p class="price"><sup>$</sup>49</p>
                                    <p class="price-pm">PER MONTH</p>
                                    <p class="deals">~ Create and Send Coupons
                                        <br><br> ~ Geolocation (Mile Radius 0-1 Miles)
                                        <br><br> ~ Geofencing (one per deal up to 20,000 Sq. Feet)
                                        <br><br> ~ 10 Deals / Unlimited Coupons
                                        <br><br> ~ Sticker for Store window (Deals en Route certified)</p>
                                    <p class="head2">Additional Packages</p>
                                    <p class="deals">Geolocation - $4.99/additional mile
                                        <br><br> Geo Fencing - $4.99/20,000 square feet</p>
                                    <p class="discl">*Coupons don't roll/carry over to next month
                                        <br><br> *Commission is equal to 30% of the face value discount the coupon provides. If this is less than $1.00, DER will receive $1.00</p>
                                    @if($subscription['subscriptioncanceled'] && $subscription['subscriptioncanceled'] == 1)
                                    <button type="button" class="btn btn-want btn-want1" value="bronze">I want this one</button>
                                    @else
                                    @if($subscription['stripe_plan'] == 'bronze')
                                    <button type="button" class="btn btn-want btn-want1" value="bronze">Current Package</button>
                                    @elseif($subscription['stripe_plan'] == 'silver')
                                    <button type="button" class="btn btn-want" value="bronze" id="downgrade">Downgrade</button>
                                    @else
                                    <button type="button" class="btn btn-want" value="bronze" id="{{$name}}">{{$name}}</button>
                                    @endif
                                    @endif
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
                                    url: $('#hidAbsUrl').val() + "/vendor/updatesubscription",
                                    type: 'POST',
                                    data: {'plan': $(this).val(), 'user_id': "<?php echo $user_id ?>", 'status': $(this).attr('id')},
                                    success: function (data) {
                                        console.log(data);
                                        window.location.href = $('#hidAbsUrl').val() + '/dashboard#settings';
                                    },
                                    beforeSend: function () {
                                        $('#loadingDiv').show();
                                    },
                                    error: function (data) {
                                        console.log(data);
                                        $('#loadingDiv').hide();
                                        $('.alert-danger').show();
                                        setTimeout(function () {
                                            $('.alert-danger').fadeOut('slow');
                                        }, 10000);
                                        $('.errormessage').html(data.responseJSON.message);
                                    },

                                });

                            });
                        </script>   

                        @endsection

