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
use App\VendorHours;
use Carbon\Carbon;

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
        $vendor_detail = \App\VendorDetail::
                select('*','vendorcountry.country_code AS vendor_country_code','billingcountry.country_code AS billing_country_code')
                ->join('stripe_users', 'stripe_users.user_id', 'vendor_detail.user_id')
                ->leftJoin('country as vendorcountry','vendorcountry.id','vendor_detail.vendor_country')
                 ->leftJoin('country as billingcountry','billingcountry.id','vendor_detail.billing_country')
                ->where('vendor_detail.user_id', Auth::id())
                ->first();

        $user_access = $this->userAccess();
        $hoursofoperation = VendorHours::getHoursOfOperations(Auth::id());
        $hours_of_operations = [];
        $hoursflage = false;
        if (count($hoursofoperation) > 0) {
            foreach ($hoursofoperation as $hours) {
                $hour = $hours->getAttributes();
                
                $dt1 = (isset($hour['open_time']) && !empty($hour['open_time']))? new Carbon($hour['open_time']):'';
                $dt2 = (isset($hour['open_time']) && !empty($hour['close_time']))? new Carbon($hour['close_time']):'';
                $hours_of_operations[$hour['days']]['day'] = $hour['days'];
                $hours_of_operations[$hour['days']]['is_closed'] = $hour['is_closed'];
                $hours_of_operations[$hour['days']]['open_time'] = (empty($dt1))?"":$dt1->format('h:i A');
                $hours_of_operations[$hour['days']]['close_time'] = (empty($dt2))?"":$dt2->format('h:i A');
//                array_push($hours_of_operations, $dataVendorHour);
            }
        } else {
            $hoursflage = true;
        }
//        echo '<pre>';
//        print_r($hours_of_operations);die;

        $additional = new \App\AdditionalCost();
        $used_plan = $additional->usedCouponTotal();
        $total_additional_fencing_left = $additional->getAdditionalFencing();
        $total_additional_location_left = $additional->getAdditionalLocation();
        $total_geofencing = $total_additional_fencing_left + $user_access['basicgeofencing'];
        $total_location = $total_additional_location_left + $user_access['basicgeolocation'];
        $user = \App\Subscription::where('user_id', Auth::id())->first();
        if ($user) {
            $deals_left = $user->getRenewalCoupon($user_access);
        }
        $country_list = \App\Country::countryList();
        $date = \Carbon\Carbon::now();
        $currenttime = $this->convertDateInUserTZ($date);
        $year = $this->getLastYear();
        $sub_details = Subscription::select('*')->where('user_id', Auth::id())->first();
        $subscription = $sub_details->getAttributes();
        $listWeeks=VendorHours::listWeeks();
        $is_free_trial= $this->getUserPaymentPeroid();
//        print_r($subscription);
//        die;
                $total_age_wise_redeem = \App\CouponRedeem::getAgeWiseReddemCoupon();
        return view('frontend.dashboard.main')->with(['coupon_lists' => $coupon_lists,
                    'vendor_detail' => $vendor_detail, 'country_list' => $country_list,
                    'currenttime' => $currenttime, 'year' => $year, 'user_access' => $user_access,
                    'total_geofencing' => $total_geofencing, 'total_location' => $total_location,
                    'deals_left' => $deals_left, 'subscription' => $subscription,
                     'total_age_wise_redeem'=>$total_age_wise_redeem,
                    'hoursofoperation' => $hours_of_operations, 
                    'hoursmsg' => $hoursflage,'listWeeks'=>$listWeeks,
            'is_free_trial'=>$is_free_trial]);
    }

    public function dashboard(Request $request) {
        $request = $request->all();
        $year = (isset($request) && !empty($request['year'])) ? $request['year'] : date('Y');
        $month = (isset($request) && !empty($request['month'])) ? $request['month'] : date('m');
        $data = [];
        $additional = new \App\AdditionalCost();
        $user_access = $additional->userAccess();
        // get current time
        $sub_details = Subscription::select('*')->where('user_id', Auth::id())->first();
        $subscription = $sub_details->getAttributes();
        $used_plan = $additional->usedCouponTotal();
        $vendor_detail = \App\VendorDetail::getStripeVendor();
        $total_redeem_monthly = Coupon::getReedemCouponMonthly($year);
        $total_redeem_weekly = Coupon::getReedemCouponWeekly($year, $month);
        $total_coupon_monthly = Coupon::getTotalCouponMonthly();
        $total_active_coupon_monthly = Coupon::getTotalActiveCouponMonthly();
        $total_age_wise_redeem = \App\CouponRedeem::getAgeWiseReddemCoupon();
        $total_additional_fencing_left = $additional->getAdditionalFencing();
        $total_additional_location_left = $additional->getAdditionalLocation();
        $vendor_detail_geo = \App\VendorDetail::where('user_id', Auth::id())->first();
        $data['total_additional_fencing_left_per'] = ($total_additional_fencing_left != 0) ? number_format(($total_additional_fencing_left / $vendor_detail_geo->additional_geo_fencing_total) * 100, 2) : 0;
        $data['total_additional_location_left_per'] = ($total_additional_location_left != 0) ? number_format(($total_additional_location_left / $vendor_detail_geo->additional_geo_location_total) * 100, 2) : 0;
        $data['total_redeem_monthly'] = $total_redeem_monthly->getAttributes();
        $data['total_additional_fencing_left'] = $total_additional_fencing_left;
        $data['total_additional_location_left'] = $total_additional_location_left;
        $data['total_coupon_monthly'] = $total_coupon_monthly->getAttributes();
        $data['total_redeem_weekly'] = $total_redeem_weekly->getAttributes();
        $data['total_active_coupon_monthly'] = $total_active_coupon_monthly->getAttributes();
        $data['deals_left'] = $vendor_detail['deals_left'];
        $data['deals_percent'] = $vendor_detail['deals_percent'];
        $data['subscription']=$subscription;
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
            $this->sendMail($array_mail);
            return response()->json(['status' => 1, 'message' => \Config::get('constants.CONTACT_SUCCESS')], 200);
        } catch (\Exception $e) {
            // throw $e;
            return response()->json(['status' => 0, 'message' => \Config::get('constants.APP_ERROR')], 200);
        }
    }

    public function changeSubscription() {
        $user_id = Auth::id();
        $sub_details = Subscription::select('*')->where('user_id', $user_id)->first();
        $subscription = $sub_details->getAttributes();
        if ($subscription['sub_id'] == '') {
            $subscription['subscriptioncanceled'] = 1;
        } else {
            $subscription['subscriptioncanceled'] = 0;
        }
        return view('frontend.dashboard.changesub')->with(['subscription' => $subscription, 'user_id' => $user_id]);
    }

    public function hoursOfOperation(Request $request) {
        $data = $request->all();
        if(isset($data['_token'])){
        unset($data['_token']);
        }
        
        $addhours = VendorHours::addHoursOfOperations($data);
      
        if ($addhours == 7) {
            return response()->json(['status' => '0', 'message' => 'Please Enter at least one entry in Hours of operation'], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Hours of operation Added Successfully!!!'], 200);
        }
    }

}
