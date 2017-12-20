@extends('frontend.layouts.login')
@section('title', 'Deals en Route|Terms & Conditions')
@section('content')

<header class="staticpage">
    <div class="container">
        <div class="header">
            <div class="row">
                <div class="col-sm-6">
                    <a href="index.html" class="logo"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/logo.png' ?>"></a>
                </div>
                <div class="col-sm-6 text-right">
                    <h2>Terms & Conditions</h2>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="staticmain">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p>
            Please read these Terms and Conditions ("Terms", "Terms and Conditions") carefully before using the www.dealsenroute.com website (the "Service") operated by Deals en Route, LLC ("us", "we", or "our").
Your access to and use of the Service is conditioned upon your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who wish to access or use the Service.
By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you do not have permission to access the Service.
              
              Communications
By creating an Account on our service, you agree to subscribe to newsletters, marketing or promotional materials and other information we may send. However, you may opt out of receiving any, or all, of these communications from us by following the unsubscribe link or instructions provided in any email we send.
             </p>
            </div>
        </div>
    </div>
</section>

@endsection
