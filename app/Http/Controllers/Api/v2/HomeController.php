<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\ResponseTrait;
use App\CouponRedeem;
use App\Coupon;
use Auth;
use App\VendorDetail;
use App\Country;
use App\Http\Transformer\VendorTransformer;

class HomeController extends Controller {

    use ResponseTrait;

    public function dashboard(Request $request) {
        $data = array();
        $user_id = Auth::id();
        $coupons = Coupon::select('coupon.coupon_id', 'coupon.coupon_redeem_limit', 'coupon.coupon_total_redeem', 'coupon.created_at')
                ->where('created_by', $user_id)
                ->get();
        $vendor_detail = \App\VendorDetail::getStripeVendor();
        $total_redeem_monthly = Coupon::getReedemCouponMonthly();
        $total_coupon_monthly = Coupon::getTotalCouponMonthly();
        $total_active_coupon_monthly = Coupon::getTotalActiveCouponMonthly();
        $data['total_redeem_monthly'] = $total_redeem_monthly->getAttributes();
        $data['total_coupon_monthly'] = $total_coupon_monthly->getAttributes();
        $data['total_active_coupon_monthly'] = $total_active_coupon_monthly->getAttributes();
        $total_coupon = 0;
        $total_coupon_reedem = 0;
        foreach ($coupons as $coupon) {
            $total_coupon = $coupon->coupon_redeem_limit + $total_coupon;
            $total_coupon_reedem = $coupon->coupon_total_redeem + $total_coupon_reedem;
        }
        if ($total_coupon == 0) {
            $data['total_coupon_reedemed'] = 0;
        } else {
            $data['total_coupon_reedemed'] = number_format(($total_coupon_reedem / $total_coupon) * 100, 2);
        }
        $allreedemcoupons = CouponRedeem::getRedeemCoupon();
        $redeem_by_18_below = 0;
        $redeem_by_18_34 = 0;
        $redeem_by_35_50 = 0;
        $redeem_by_above_50 = 0;
        foreach ($allreedemcoupons as $redeemcoupon) {
            $redeem = $redeemcoupon->getAttributes();
            if ($redeem['age'] < 18) {
                $redeem_by_18_below = $redeem_by_18_below + 1;
            } elseif ($redeem['age'] < 35 && $redeem['age'] >= 18) {
                $redeem_by_18_34 = $redeem_by_18_34 + 1;
            } elseif ($redeem['age'] >= 35 && $redeem['age'] < 50) {
                $redeem_by_35_50 = $redeem_by_35_50 + 1;
            } elseif ($redeem['age'] >= 50) {
                $redeem_by_above_50 = $redeem_by_above_50 + 1;
            }
        }
        $dealsbyplan = \App\Subscription::select('plan_access.deals', 'plan_add_ons.addon_type', 'plan_add_ons.quantity')
                ->leftjoin('plan_access', 'plan_access.plan_id', 'subscriptions.stripe_plan')
                ->leftjoin('plan_add_ons', 'plan_add_ons.user_id', 'subscriptions.user_id')
                ->where('subscriptions.user_id', $user_id)
                ->where('plan_add_ons.addon_type', 'deals')
                ->get();
        $totaladdon = 0;
        $totaldeals = 0;
        foreach ($dealsbyplan as $addon) {
            $totaldeals = $addon->deals;
            $totaladdon = $addon->quantity + $totaladdon;
        }
//        $data['redeem_by_18_below_per'] = number_format(($redeem_by_18_below / $total_coupon) * 100, 2);
//        $data['redeem_by_18_34_per'] = number_format(($redeem_by_18_34 / $total_coupon) * 100, 2);
//        $data['redeem_by_35_50_per'] = number_format(($redeem_by_35_50 / $total_coupon) * 100, 2);
//        $data['redeem_by_above_50_per'] = number_format(($redeem_by_above_50 / $total_coupon) * 100, 2);
        $data['redeem_by_18_below_per'] = strval(($redeem_by_18_below != 0) ? number_format(($redeem_by_18_below / $total_coupon) * 100, 2) : 0);
        $data['redeem_by_18_34_per'] = strval(($redeem_by_18_34 != 0) ? number_format(($redeem_by_18_34 / $total_coupon) * 100, 2) : 0);
        $data['redeem_by_35_50_per'] = strval(($redeem_by_35_50 != 0) ? number_format(($redeem_by_35_50 / $total_coupon) * 100, 2) : 0);
        $data['redeem_by_above_50_per'] = strval(($redeem_by_above_50 != 0) ? number_format(($redeem_by_above_50 / $total_coupon) * 100, 2) : 0);
        $data['redeem_by_18_below'] = strval($redeem_by_18_below);
        $data['redeem_by_18_34'] = strval($redeem_by_18_34);
        $data['redeem_by_35_50'] = strval($redeem_by_35_50);
        $data['redeem_by_above_50'] = strval($redeem_by_above_50);
        $data['reemaining_deal'] = strval($vendor_detail['deals_left']);
        $data['total_coupons'] = strval($total_coupon);
        $data['total_coupons_remaining'] = strval(($total_coupon - $total_coupon_reedem));
        $data['total_deals_created_count'] = strval(count($coupons));
        $data['total_deals_can_create_count'] = strval(($totaladdon + $totaldeals));
        $data['total_deals_remaining_count'] = strval(($data['total_deals_can_create_count'] - $data['total_deals_created_count']));
//        var_dump($data);
//        die;
        return $this->responseJson('success', \Config::get('constants.DASHBOARD_DETAIL'), 200, $data);
    }

    public function getReedeemCouponByYear(Request $request) {
        $details = $request->all();
        $total_redeem_monthly = Coupon::getReedemCouponMonthly($details['year']);
//        $data['total_redeem_monthly'] = $total_redeem_monthly;
        return $this->responseJson('success', \Config::get('constants.REDEEM_COUPON_YEAR'), 200, $total_redeem_monthly);
    }

    public function getCountry() {
        $country_list = \App\Country::countryList();
        $data = array();
        $data['country_list'] = $country_list;
        return $this->responseJson('success', 'Country list', 200, $data);
    }

    public function getSettings() {
        $user_id = Auth::id();
        $userdata = VendorDetail::getVendorDetails($user_id);
        $settings = $userdata->getAttributes();
        $countries = Country::select('country_name')->find($settings['billing_country']);
        if ($countries && !empty($countries)) {
            $country = $countries->getAttributes();
            $settings['billing_country_name'] = $country['country_name'];
        } else {
            $settings['billing_country_name'] = '';
        }
        $data = (new VendorTransformer)->settingsData($settings);
        return $this->responseJson('success', \Config::get('constants.SETTINGS'), 200, $data);
    }

}
