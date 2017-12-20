@extends('frontend.layouts.login')
@section('title', 'Deals en Route|Main')
@section('content')

<div class="base-wrapper">
    <section class="page">
            <div class="container">
                    <div class="designs">
                            <div class="Content">
                                    <a class="logo smooth-scroll" href="#">
    <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/logo.png' ?>" width="100">
    </a>
                                    <h2 class="primary-col">Deals en Route wants to bring YOU closer to your local businesses.</h2>
                                    <h4>Download our app and receive instant notifications on fun activities and huge discounts from restaurants, hotels, bars, apparel stores, beauty stores, craft stores, supermarkets right around you! <br>
                                            <br> Plus, did we mention how easy it is? Just tell us what you’re interested in and we do the rest. <br>
                                            <br> We are creating a more efficient relationship between you- the student, parent, teacher, long-time resident- and businesses in your college town by offering targeted, customized and time-sensitive deals powered by geo-location.</h4>

                                    <h4>If you are a store owner <a id="main-call-to-action" class="call-to-action button" href="{{ route('vendorindex') }}">Click Here</a> </h4>

                                    <h4>Download the app from <a id="main-call-to-action" class="call-to-action button" href="#" style="margin-left: 10px;"><span class="icon fa fa-apple"></span>App Store</a> </h4>

                            </div>
                            <div class="sliders">
                                    <div class="mobileslider">
                                            <div class="mobile">
                                                    <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/4.png' ?>">
                                            </div>
                                            <div class="owl-carousel owl-theme">
                                                    <div class="item"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/slider/1.jpg' ?>" /></div>
                                                    <div class="item"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/slider/2.jpg' ?>" /></div>
                                                    <div class="item"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/slider/3.jpg' ?>" /></div>
                                                    <div class="item"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/slider/4.jpg' ?>" /></div>
                                                    <div class="item"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/slider/5.jpg' ?>" /></div>
                                                    <div class="item"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/slider/6.jpg' ?>" /></div>
                                                    <div class="item"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/slider/7.jpg' ?>" /></div>
                                                    <div class="item"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/slider/8.jpg' ?>" /></div>
                                                    <div class="item"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/slider/9.jpg' ?>" /></div>
                                            </div>
                                    </div>

                            </div>
                    </div>
            </div>
    </section>
</div>
<!-- end of  banner -->
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('frontend/js/owl-carousel/owl.carousel.js') }} "></script>
	<script type="text/javascript" src="{{ asset('frontend/js/owl-carousel/owl.autoplay.js') }}"></script>

	<script type="text/javascript">
		$('.owl-carousel').owlCarousel({
			loop: true,
			autoplay: true,
			autoplayHoverPause: true,
			items: 1,
			nav: false,
			pagination: false
		})

	</script>
        @endsection

