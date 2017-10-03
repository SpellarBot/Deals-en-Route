<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use URL;
class CouponRedeem extends Model
{
    public $table = 'coupon_redeem';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const IS_TRUE = 1;
    const IS_FALSE = 0;
    public $primaryKey = 'redeem_id';  
    
      /**
     * Get the vendor detail record associated with the user.
     */
    public function vendorDetail() {
        return $this->hasOne('App\VendorDetail', 'user_id', 'created_by');
    }
    
    
    public function getCouponLogoAttribute($value) {
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/coupon_logo/' . $value))) ? URL::to('/storage/app/public/coupon_logo') . '/' . $value : "";
    }
    
       public static function redeemCouponList($data) {
        $user = Auth()->user()->userDetail;
        $circle_radius = \Config::get('constants.EARTH_RADIUS');
        $lat = $user->latitude;
        $lng = $user->longitude;
        $result = CouponRedeem::
                select(DB::raw('coupon.coupon_id,coupon_lat,coupon_long,coupon_redeem.coupon_id,coupon_radius,coupon_start_date,coupon_end_date,coupon_detail,'
                                . 'coupon_name,coupon_logo,created_by,coupon_category_id'))
                ->leftJoin('coupon', 'coupon_redeem.coupon_id', '=', 'coupon.coupon_id')
                ->where('is_active', self::IS_TRUE)
                ->where('is_delete', self::IS_FALSE)
                ->where('user_id', Auth::id())
                ->where('is_redeem',self::IS_TRUE)
                ->groupBy('coupon_redeem.coupon_id')
                ->orderBy('redeem_id','desc')
                ->get();
        return $result;
    }

}
