@extends('frontend.layouts.landing')
@section('title', 'Deals en Route|Main')
@section('content')
       <section class="wrapper">
            <div class="border-element"></div>
            <!--page navigation progress-->
            <div class="page-nav hidden-sm hidden-xs">
                <ul class="list-unstyled">
                    <!-- <li><a class="slider-first" href="#"><i class="icon icon-navigazione-1"></i></a></li> -->
                    <li><a class="slider-first"  href="#"><i class="icon icon-navigazione-2"></i></a></li>
                    <li><a class="slider-second" href="#"><i class="icon icon-navigazione-3"></i></a></li>
                    <li><a class="slider-third" href="#"><i class="icon icon-navigazione-4"></i></a></li>
                </ul>
            </div>
            <!--next section container-->
            <nav class="arrow-section-container hidden-sm hidden-xs"><a class="go-to-next" href="#"><i class="icon icon-arrow-down"></i></a></nav>
            <nav class="arrow-section-container visible-sm visible-xs"><a href="#content" class="scrollTo"><i class="icon icon-arrow-down"></i></a></nav>
            <div class="landing scene" id="demo-slider">
                <div class="slides video-slide active" id="content">
                    <div class="absolute-full-container hidden-xs hidden-sm">
                        <div class="iphone-video-container visible-lg" id="scene2">
                            <!-- <video class="composizione" loop muted>
                                <source src="images/video/finale-white.mp4" type='video/mp4'>
                            </video> -->
                            <img class="composizione" src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/banner.gif' ?> ">
                        </div>
                        <div class="static-video-container visible-md" id="scene5" style="background-image:url('<?php echo \Config::get('app.url') . '/public/frontend/img/images/banner.jpg' ?>')"></div>
                    </div>
                    <div class="col-left padding-bottom-mobile toshow" id="scene1">
                        <h2 class="primary-col">Deals en Route wants to bring YOU closer to your local businesses.</h2>
                        <p class="text-primary">Download our app and receive instant notifications on fun activities and huge discounts from restaurants, hotels, bars, apparel stores, beauty stores, craft stores, supermarkets right around you!</p>
                        <p class="text-primary">Plus, did we mention how easy it is? Just tell us what you’re interested in and we do the rest.</p>
                        <p class="text-primary">We are creating a more efficient relationship between you- the student, parent, teacher, long-time resident- and businesses in your college town by offering targeted, customized and time-sensitive deals powered by geo-location.</p>
                        <div class="outer-button-container">
                            <div class="normal-button-container">
                                <a data-target="#follow" href="{{ route('vendorindex')}}"  class="btn btn-default normal-links hover-state">Inqury for Business<div class="icon-container"><i class="icon icon-arrow-right"></i></div></a>
                                <a data-target="#follow" href="{{ route('vendorindex')}}"  class="btn btn-default normal-links normal">Inqury for Business<div class="icon-container"><i class="icon icon-arrow-right"></i></div></a>
                            </div>
                            <div class="normal-button-container">
                                <a data-target="#follow" href="https://itunes.apple.com/us/app/deals-en-route-customer/id1327286547?ls=1&mt=8"  class="btn btn-default normal-links hover-state "><div class="icon-container"><i class="icon fa fa-apple"></i></div>Download iOS App<div class="icon-container"><i class="icon icon-arrow-right"></i></div></a>
                                <a data-target="#follow" href="https://itunes.apple.com/us/app/deals-en-route-customer/id1327286547?ls=1&mt=8"  class="btn btn-default normal-links normal"><div class="icon-container"><i class="icon fa fa-apple"></i></div>Download iOS App<div class="icon-container"><i class="icon icon-arrow-right"></i></div></a>
                            </div>
                        </div>
                    </div>
                    <div class="gif-container toshow visible-sm visible-xs">
                        <img class="img-responsive" src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/gif-banner.gif' ?>">
                    </div>
                </div>
                <!--second slide-->
                <div class="slides hiring-section">
                    <div class="absolute-full-container video-container hidden-sm hidden-xs">
                        <div class="no-padding hiring-thumb">
                            <div class="static-video-thumb"></div>
                        </div>
                        <div class="no-padding hiring-thumb">
                            <div class="static-video-thumb"></div>
                        </div>
                    </div>
                    <div class="col-left toshow" id="scene3">

                        <h2 class="white">CUSTOMERS FEATURES</h2>
                        <ul>
                        	<li>
                        		<img src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/coupon.png' ?> " class="img-responsive">
                        		<p class="white">Personalized Coupons</p>
                        	</li>
                        	<li>
                        		<img src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/TimeLocation.png' ?>" class="img-responsive">
                        		<p class="white">Time & Location Sensitive Coupons</p>
                        	</li>
                        	<li>
                        		<img src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/Gamification.png' ?>" class="img-responsive">
                        		<p class="white">Gamification</p>
                        	</li>
                        </ul>
                    </div>

                    <div class="col-right toshow" id="scene4">
                        <h2 class="white">BUSINESSES FEATURES</h2>
                        <ul>
                        	<li>
                        		<img src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/geofencing.png' ?>" class="img-responsive">
                        		<p class="white">Geo-fencing & Geo-location</p>
                        	</li>
                        	<li>
                        		<img src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/Inventorycontrol.png' ?>" class="img-responsive">
                        		<p class="white">Inventory Control</p>
                        	</li>
                        	<li>
                        		<img src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/Couponredemption.png' ?>" class="img-responsive">
                        		<p class="white">Coupon Redemption and reach Tracker</p>
                        	</li>
                        	<li>
                        		<img src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/Artificialintelligence.png' ?>" class="img-responsive">
                        		<p class="white">Artificial Intelligence</p>
                        	</li>
                        	<li>
                        		<img src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/Affordableprice.png' ?>" class="img-responsive">
                        		<p class="white">Affordable Price</p>
                        	</li>
                        </ul>
                    </div>

                    <!-- <div class="titlefeaturs toshow" id="scene8">
                        <h2 class="white">FEATURES</h2>
                    </div> -->

                </div>
                <!--third slide-->
                <div class="slides sview-section">
					
					<div class="col-left toshow" id="scene7">
						<img src="<?php echo \Config::get('app.url') . '/public/frontend/img/images/footer_banner.png' ?>" class="img-responsive">
					</div>
                    
                    <div class="col-right toshow" id="scene6">

                    	

                        <h2 class="primary-col">sooo...Why Deals en Route?</h2>
                        <p class="text-gray">"Making my way downtown, walking…nvm" Okay seriously….Walking in your downtown area, is there a pizza store on your way home, ever wondered what slices they have today? Or do you pass by a coffee store during your early morning commutes to work? Or hey, you have your favorite stores around but you just can’t be bothered to go out and check out their deals and discounts.</p>

                        <p class="text-gray">Whatever store it is, Deals en Route notifies you of your favorite stores' deals just to make sure you start your day off or end your night with saving money while we do all the work. And even better, you can share these deals with friends to help them get the same deals whether you are out for lunch or a night out at a bar or need some new clothes for an outing.</p>

                        <p class="text-gray">Yep, that's what Deals en Route is about. Whether you’re new in town or a long-time resident, there's always new things happening in your town that might skip your attention. Don’t worry. that won’t happen ever again with us. We push the latest and most relevant deals to your phone right when you need it.</p>

                        <p class="text-gray">Now what are you waiting for? Go out there and save seamlessly & effortlessly anytime, anywhere.</p>

                    </div>

                    <footer class="footer-bottom">
                        <div class="footer-inner-alternative">
                            
                       
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <p>
                         <a target="_blank" style="color: white" href="{{ route('termscondition')}}">Terms and Conditions </a> |
                        <a target="_blank" style="color: white" href="{{ route('privacy')}}">Privacy Policy</a> |
                        <a target="_blank" style="color: white" href="{{ route('help')}}">Help</a> 
                                       <br>
                                        ©
                                        <script>
                                 
                                    document.write(new Date().getFullYear())
                                </script> DealsEnRoute - All right reserved.</p>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
            
        </section>
       <div class="social-popup">
            <div class="velina"></div>
            <div class="social-close"><a class="social-close-button" href="#"><i class="icon icon-close"></i></a></div>
            <div class="social-container">
                <h2 class="white">You can find us on:</h2>
                <div class="social-buttons-content">
                    <div class="social-button-container">
                        <a class="social-links fb hover-state" target="_blank" href="{{ \Config::get('constants.FACEBOOK_LINK') }}"><div class="icon-container"><i class="icon icon-fb"></i></div></a>
                        <a class="social-links fb normal" target="_blank" href="{{ \Config::get('constants.FACEBOOK_LINK') }}"><div class="icon-container"><i class="icon icon-fb"></i></div></a>
                    </div>
                    <div class="social-button-container">
                        <a class="social-links dribbble hover-state" target="_blank" href="{{ \Config::get('constants.LINKDIN_LINK') }}"><div class="icon-container"><i class="fa fa-linkedin"></i></div></a>
                        <a class="social-links dribbble normal" target="_blank" href="{{ \Config::get('constants.LINKDIN_LINK') }}"><div class="icon-container"><i class="fa fa-linkedin"></i></div></a>
                    </div>
                    <div class="social-button-container">
                        <a class="social-links instagram hover-state" target="_blank" href="{{ \Config::get('constants.INSTAGRAM_LINK') }}"><div class="icon-container"><i class="icon icon-instagram"></i></div></a>
                        <a class="social-links instagram normal" target="_blank" href="{{ \Config::get('constants.INSTAGRAM_LINK') }}"><div class="icon-container"><i class="icon icon-instagram"></i></div></a>
                    </div>
                    <div class="social-button-container">
                        <a class="social-links be hover-state" target="_blank" href="{{ \Config::get('constants.TWITTER_LINK') }}"><div class="icon-container"><i class="fa fa-twitter"></i></div></a>
                        <a class="social-links be normal" target="_blank" href="{{ \Config::get('constants.TWITTER_LINK') }}"><div class="icon-container"><i class="fa fa-twitter"></i></div></a>
                    </div>
                </div>

            </div>
        </div>
<!-- end of  banner -->
@endsection


