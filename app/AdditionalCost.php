<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class AdditionalCost extends Model {

    use \App\Http\Services\CouponTrait;

    public $table = 'additional_cost';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'id';
    protected $fillable = [
        'id', 'coupon_id', 'user_id', 'coupon_id', 'created_at', 'updated_at',
        'total_geolocation_utilised', 'total_geofence_utilised', 'total_geolocation_buy',
        'total_geofence_buy', 'is_particular_coupon'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public static function addAdditionalCost() {
        
    }

    public static function getAdditionalCost($data) {

        $additional = new AdditionalCost();
        $user_access = $additional->userAccess();
        $used_plan = self::usedCouponTotal();
  // geo fencing
        $additonal_left = self::getAdditionalFencing();
        $vendordetail = VendorDetail::where('user_id', Auth::id())->first();
        if (($data['totaldrawn'] <= $user_access['basicgeofencing'])) {
          //  $totalgeofenceadditionalused = $additonal_left;
            $totalfenceused = 0;
        } else if ($additonal_left > ($data['totaldrawn'] - $user_access['basicgeofencing'])) {
          //  $totalgeofenceadditionalused = $additonal_left - ($data['totaldrawn'] - $user_access['basicgeofencing']);
            $totalfenceused = ($data['totaldrawn'] - $user_access['basicgeofencing']);
        } else {
          
           // $totalgeofenceadditionalused = $additonal_left;
            $totalfenceused = $vendordetail->additional_geo_fencing_total;
        }
// geo location
        $additonal_left_location = self::getAdditionalLocation();
        if (($data['totalgeomilesselected'] <= $user_access['basicgeolocation'])) {
          //  $totalgeolocationadditionalused = $additonal_left_location;
            $totallocationused = 0;
        } else if ($additonal_left_location > ($data['totalgeomilesselected'] - $user_access['basicgeolocation'])) {
         //   $totalgeolocationadditionalused = $additonal_left_location - ($data['totalgeomilesselected'] - $user_access['basicgeolocation']);
            $totallocationused = ($data['totalgeomilesselected'] - $user_access['basicgeolocation']);
        } else {
           // $totalgeolocationadditionalused = $additonal_left_location;
            $totallocationused = $vendordetail->additional_geo_location_total;
        }


        $totatl_geo_fencing = self::getAdditionalFencingCost($used_plan, $user_access, $data);
        $totatl_geo_location = self::getAdditionalLocationCost($used_plan, $user_access, $data);

        $total = $totatl_geo_location + $totatl_geo_fencing;

        return ['total_geo_fence_buy' => $totatl_geo_fencing, 'total_geo_location_buy' => $totatl_geo_location,
            'total_rs' => number_format($total, 2), 'totalgeofenceadditionalleft' => $totalfenceused,
            'totalgeolocationadditionalleft' => $totallocationused];
    }

    public static function getAdditionalFencing($id='') {
//         $plan_geo_fence_total = $user_access['geofencingtotal'];
//         $usedplanfence = (isset($used_plan) && !empty($used_plan)) ? $used_plan[0]['geofencetotalused'] - ($used_plan[0]['geofencecount'] * $user_access['basicgeofencing']) : 0;
//
//        if ($usedplanfence <= $user_access['additionalgeofencing']) {
//            $additonal_left = $user_access['additionalgeofencing'] - $usedplanfence;
//        } else {
//            $additonal_left = 0;
//        }
        $id=(!empty($id))?$id:Auth::id();
        $vendordetail = VendorDetail::where('user_id', $id)->first();
        if ($vendordetail) {
            $additonal_left = $vendordetail->additional_geo_fencing_total - $vendordetail->additional_geo_fencing_used;
        }
        return $additonal_left;
    }

    public static function getAdditionalFencingCost($used_plan, $user_access, $data) {

        //get geofence left
        $additonal_left = self::getAdditionalFencing($used_plan, $user_access);

        // geo fence addtional drawn
        $totalleftfenced = $user_access['basicgeofencing'] + $additonal_left;




        if ($data['totaldrawn'] >= $totalleftfenced) {
            $additional_geo_fence = $data['totaldrawn'] - $totalleftfenced;
        } else {
            $additional_geo_fence = 0;
        }
        //addon price
        $geofenceaddonprice = PlanAccess::where('plan_id', 'add_on_geo_fence')->first();
        $totatl_geo_fencing = (ceil($additional_geo_fence / $geofenceaddonprice->geofencing)) * $geofenceaddonprice->price;
        return $totatl_geo_fencing;
    }

    public static function getAdditionalLocation($id='') {
        // geo miles cost
//        $plan_geo_location = $user_access['geolocationtotal'];
//        $usedplanlocation = (isset($used_plan) && !empty($used_plan)) ? $used_plan[0]['geolocationtotalused'] - ($used_plan[0]['geolocationcount'] * $user_access['basicgeolocation']) : 0;
//
//        if ($usedplanlocation <= $user_access['additionalgeolocation']) {
//            $additonal_left_location = $user_access['additionalgeolocation'] - $usedplanlocation;
//        } else {
//            $additonal_left_location = 0;
//        }
//        return $additonal_left_location;
        $id=(!empty($id))?$id:Auth::id();
        $vendordetail = VendorDetail::where('user_id', $id)->first();
        if ($vendordetail) {
            $additonal_left = $vendordetail->additional_geo_location_total - $vendordetail->additional_geo_location_used;
        }
        return $additonal_left;
    }

    public static function getAdditionalLocationCost($used_plan, $user_access, $data) {
        //get geofence left
        $additonal_left_location = self::getAdditionalLocation($used_plan, $user_access);

        // geo fence addtional drawn
        $totalleftlocation = ($user_access['basicgeolocation']) + $additonal_left_location;
        if ($data['totalgeomilesselected'] >= $totalleftlocation) {
            $additional_geo_location = $data['totalgeomilesselected'] - $totalleftlocation;
        } else {
            $additional_geo_location = 0;
        }
        $geolocationddonprice = PlanAccess::where('plan_id', 'add_on_geo_location')->first();
        $totatl_geo_location = (ceil($additional_geo_location / $geolocationddonprice->geolocation)) * $geolocationddonprice->price;
        return $totatl_geo_location;
    }

    public static function usedAdditionalPlan() {

        $addditonal_plan = AdditionalCost::select(DB::raw('SUM(case when is_particular_coupon=1 then total_geofence_utilised else 0 end) as geofencetotalused,Count(geofencetotalused) as geofencecount
                 SUM(case when is_particular_coupon=1 then total_geolocation_utilised else 0 end) as geolocationtotalused,
                 startdate,enddate,user_id'))
                ->where(\DB::raw('TIMESTAMP(`startdate`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`enddate`)'), '>=', date('Y-m-d H:i:s'))
                ->where('user_id', Auth::id())
                ->get()
                ->toArray();
        return $addditonal_plan;
    }

    public static function usedCouponTotal() {

        $addditonal_plan = Coupon::select(DB::raw('SUM(coupon_notification_sqfeet) as geofencetotalused,
                 Count(coupon_notification_sqfeet) as geofencecount,
                 SUM(coupon_radius) as geolocationtotalused,
                 Count(coupon_radius) as geolocationcount,
                 startdate,enddate,created_by'))
                ->leftjoin('subscriptions', 'subscriptions.user_id', 'coupon.created_by')
                ->where(\DB::raw('TIMESTAMP(`startdate`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`enddate`)'), '>=', date('Y-m-d H:i:s'))
                ->where('user_id', Auth::id())
                ->get()
                ->toArray();
        return $addditonal_plan;
    }

}
