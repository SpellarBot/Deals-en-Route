<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth.vendor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $coupon_lists = \App\Coupon::couponList();
        $vendor_detail = \App\VendorDetail::join('stripe_users', 'stripe_users.user_id', 'vendor_detail.user_id')
                ->where('vendor_detail.user_id', Auth::id())
                ->first();
        $country_list = \App\Country::countryList();
//        echo '<pre>';
//        print_r($vendor_detail);die;
        return view('frontend.dashboard.main')->with(['coupon_lists' => $coupon_lists,
                    'vendor_detail' => $vendor_detail, 'country_list' => $country_list]);
    }

}
