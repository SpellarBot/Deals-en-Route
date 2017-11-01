@extends('frontend.layouts.app')
@section('title', 'Deals en Route|Index')
@section('content')
<div class="banner" id="banner">
    <header class="parallax" data-parallax-amount="-0.2" data-parallax-start="auto">
        <h1 class="index-head"> Create <span class="secondary-col">relevant</span> and <span class="secondary-col">time sensitive</span> coupons around your business! </h1>
        <a id="main-call-to-action" class="call-to-action button" href="{{route('frontend.register')}}">Sign Up</a> <a href="#login" class="call-to-action button" data-toggle="modal">Login</a> </header>
    <div class="banner-background animated parallax" data-parallax-amount="0.1" data-parallax-start="500">
        <div class="clouds"> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px" height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud distant smaller">
                <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
                      c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
                      C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
                      S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
            </svg> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px" height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud small slow">
                <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
                      c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
                      C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
                      S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
            </svg> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px" height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud slower">
                <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
                      c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
                      C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
                      S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
            </svg> </div>
        <div class="clouds right"> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px" height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud distant smaller">
                <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
                      c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
                      C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
                      S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
            </svg> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px" height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud small slow">
                <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
                      c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
                      C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
                      S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
            </svg> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="762px" height="331px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud slower">
                <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
                      c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
                      C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
                      S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
            </svg> </div>
        <div class="banner-background-sea">
            <div class="banner-back">
                <div class="banner-back-right"></div>
            </div>
        </div>
    </div>
    <div class="banner-road animated parallax" data-parallax-amount="-0.1" data-parallax-start="500">
        <div class="banner-bridge">
            <div class="banner-bridge-center"></div>
            <div class="banner-wazers">
                <div class="banner-women-wazer"></div>
                <div class="banner-women-wazer1">
                    <div class="banner-hotdog-pin">
                        <div class="pin">
                            <div class="pinheader"> <img src="{{ $company_logo }}">
                                    <h5>Deals en Route</h5>
                            </div>
                            <div class="pindetails">
                                <p>Hey John! Your favorite craft beers aren't going to drink themselves. Here is a free one with a meal over $25. Cheers</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="banner-smart-wazer"></div>
                <div class="banner-smart-wazer1">
                    <div class="banner-hotdog-pin">
                        <div class="pin">
                            <div class="pinheader"> <img src="{{ $company_logo }}">
                                    <h5>Deals en Route</h5>
                            </div>
                            <div class="pindetails">
                                <p>YOU! Yes! You! Pepperoni pizza for dinner tonight? $1 pizza slices till midnight</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="banner-smart-aa"></div>
                <div class="banner-smart-aa1">
                    <div class="banner-hotdog-pin">
                        <div class="pin">
                            <div class="pinheader"> <img src="{{ $company_logo }}">
                                    <h5>Deals en Route</h5>
                            </div>
                            <div class="pindetails">
                                <p>YOU! Yes! You! Pepperoni pizza for dinner tonight? $1 pizza slices till midnight</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="banner-smart-asian"></div>
                <div class="banner-smart-asian1">
                    <div class="banner-hotdog-pin">
                        <div class="pin">
                            <div class="pinheader"> <img src="{{ $company_logo }}">
                                    <h5>Deals en Route</h5>
                            </div>
                            <div class="pindetails">
                                <p>YOU! Yes! You! Pepperoni pizza for dinner tonight? $1 pizza slices till midnight</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="banner-dog-wazer"></div> -->
                <div class="banner-women-pink-wazer"></div>
                <div class="banner-women-pink-wazer1">
                    <div class="banner-hotdog-pin">
                        <div class="pin">
                            <div class="pinheader"> <img src="{{ $company_logo }}">
                                    <h5>Deals en Route</h5>
                            </div>
                            <div class="pindetails">
                                <p>Taco night at Anderson Creek! We’re shaking up tonight with free tequila shots (21+) from 8-9 only! Bottoms up!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of  banner -->
@endsection
