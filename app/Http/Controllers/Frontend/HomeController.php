<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Http\Services\CouponTrait;
use App\Coupon;
use App\Subscription;
use App\Http\Services\ResponseTrait;
use App\Http\Services\UserTrait;
use App\Http\Services\MailTrait;
use App\Http\Requests\ContactRequest;

class HomeController extends Controller {

    use CouponTrait;
    use ResponseTrait;
    use UserTrait;
    use MailTrait;

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
        $user_access = $vendor_detail->userSubscription;
        $user = \App\Subscription::where('user_id', Auth::id())->first();
        if ($user) {
            $deals_left = $user->getRenewalCoupon($user_access[0]);
        }
        $country_list = \App\Country::countryList();
        $date = \Carbon\Carbon::now();
        $currenttime = $this->convertDateInUserTZ($date);
        $year = $this->getLastYear();


        return view('frontend.dashboard.main')->with(['coupon_lists' => $coupon_lists,
                    'vendor_detail' => $vendor_detail, 'country_list' => $country_list,
                    'currenttime' => $currenttime, 'year' => $year, 'user_access' => $user_access[0],
                    'deals_left' => $deals_left]);
    }

    public function dashboard(Request $request) {
        $request = $request->all();
        $year = (isset($request) && !empty($request['year'])) ? $request['year'] : date('Y');
        $month = (isset($request) && !empty($request['month'])) ? $request['month'] : date('m');
        $data = [];
        $vendor_detail = \App\VendorDetail::getStripeVendor();
        $total_redeem_monthly = Coupon::getReedemCouponMonthly($year);
        $total_redeem_weekly = Coupon::getReedemCouponWeekly($year, $month);
        $total_coupon_monthly = Coupon::getTotalCouponMonthly();
        $total_active_coupon_monthly = Coupon::getTotalActiveCouponMonthly();
        $total_age_wise_redeem = \App\CouponRedeem::getAgeWiseReddemCoupon();
        $data['total_redeem_monthly'] = $total_redeem_monthly->getAttributes();
        $data['total_coupon_monthly'] = $total_coupon_monthly->getAttributes();
        $data['total_redeem_weekly'] = $total_redeem_weekly->getAttributes();
        $data['total_active_coupon_monthly'] = $total_active_coupon_monthly->getAttributes();
        $data['deals_left'] = $vendor_detail['deals_left'];
        $data['deals_percent'] = $vendor_detail['deals_percent'];
        $data = $data + $total_age_wise_redeem;
        return $this->responseJson('success', \Config::get('constants.DASHBOARD_DETAIL'), 200, $data);
    }

    public function sendContact(ContactRequest $contactrequest) {
        try {
            $data = $contactrequest->all();
            $array_mail = ['to' => \Config::get('constants.CLIENT_MAIL'),
                'type' => 'contactuserweb',
                'data' => ['email' => $data['email'],
                    'query' => $data['query'],
                    'name' => $data['user_name']]
            ];
            if ($this->sendMail($array_mail)) {
                return response()->json(['status' => 1, 'message' => \Config::get('constants.CONTACT_SUCCESS')], 200);
            }
             return response()->json(['status' => 0, 'message' => \Config::get('constants.CONTACT_FAILURE')], 200);
        } catch (\Exception $e) {
            // throw $e;
            return response()->json(['status' => 0, 'message' => \Config::get('constants.APP_ERROR')], 200);
        }
    }

    public function changeSubscription() {
        $user_id = Auth::id();
        $sub_details = Subscription::select('*')->where('user_id', $user_id)->first();
        $subscription = $sub_details->getAttributes();
        return view('frontend.dashboard.changesub')->with(['subscription' => $subscription, 'user_id' => $user_id]);
    }

}
