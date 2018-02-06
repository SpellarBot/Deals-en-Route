<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use URL;

class CouponRedeem extends Model {

    public $table = 'coupon_redeem';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'redeem_id';
    protected $fillable = [
        'user_id', 'coupon_id', 'created_at', 'updated_at', 'is_redeem'
    ];

    /**
     * Get the vendor detail record associated with the user.
     */
    public function vendorDetail() {
        return $this->hasOne('App\VendorDetail', 'user_id', 'created_by');
    }

    /**
     * Get the vendor detail record associated with the user.
     */
    public function categoryDetail() {
        return $this->hasOne('App\CouponCategory', 'category_id', 'coupon_category_id');
    }

    public function getCouponLogoAttribute($value) {
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/coupon_logo/' . $value))) ? URL::to('/storage/app/public/coupon_logo') . '/' . $value : "";
    }

    public static function redeemCouponList($data) {
        $user = Auth()->user()->userDetail;
        $circle_radius = \Config::get('constants.EARTH_RADIUS');
        $lat = $user->latitude;
        $lng = $user->longitude;
        $circle_radius = \Config::get('constants.EARTH_RADIUS');
        $result = CouponRedeem::
                select(DB::raw('coupon.coupon_id,coupon_lat,coupon_long,coupon_redeem.coupon_id,coupon_radius,coupon_start_date,coupon_end_date,coupon_detail,(coupon_redeem_limit - coupon_total_redeem) as remaining_coupons,coupon_code,coupon_end_date,coupon_original_price,coupon_total_discount,'
                                . 'coupon_name,coupon_logo,created_by,coupon_category_id,((' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(coupon_lat)) * cos(radians(coupon_long) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(coupon_lat))))) as distance'))
                ->leftJoin('coupon', 'coupon_redeem.coupon_id', '=', 'coupon.coupon_id')
                ->where('is_active', self::IS_TRUE)
                ->where('is_delete', self::IS_FALSE)
                ->where('user_id', Auth::id())
                ->where('is_redeem', self::IS_TRUE)
                ->groupBy('coupon_redeem.coupon_id')
                ->orderBy('redeem_id', 'desc')
                ->simplePaginate(\Config::get('constants.PAGINATE'));
        return $result;
    }

    public static function getRedeemCoupon() {
        $user_id = Auth::id();
        $coupons = CouponRedeem::select(DB::raw("coupon_redeem.is_redeem,coupon_redeem.created_at as coupoun_redeem_date, user_detail.gender,user_detail.user_id,TIMESTAMPDIFF(YEAR,user_detail.dob,NOW()) as age"))
                ->leftjoin('coupon', 'coupon.coupon_id', 'coupon_redeem.coupon_id')
                ->leftjoin('user_detail', 'user_detail.user_id', 'coupon_redeem.user_id')
                ->where('coupon.created_by', $user_id)
                ->get();
        return $coupons;
    }

    public static function getAgeWiseReddemCoupon() {

        $total_coupon = 0;
        $total_coupon_reedem = 0;
        $data = [];
        $coupons = Coupon::select('coupon.coupon_id', 'coupon.coupon_redeem_limit', 'coupon.coupon_total_redeem', 'coupon.created_at')
                ->where('created_by', Auth::id())
                ->get();
        foreach ($coupons as $coupon) {
            $total_coupon = $coupon->coupon_redeem_limit + $total_coupon;
            $total_coupon_reedem = $coupon->coupon_total_redeem + $total_coupon_reedem;
        }
        if ($total_coupon_reedem != 0 && $total_coupon != 0) {
            $data['total_coupon_reedemed'] = number_format(($total_coupon_reedem / $total_coupon) * 100, 2);
        } else {
            $data['total_coupon_reedemed'] = 0;
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

        $data['redeem_by_18_below_per'] = ($redeem_by_18_below != 0) ? number_format(($redeem_by_18_below / $total_coupon) * 100, 2) : 0;
        $data['redeem_by_18_34_per'] = ($redeem_by_18_34 != 0) ? number_format(($redeem_by_18_34 / $total_coupon) * 100, 2) : 0;
        $data['redeem_by_35_50_per'] = ($redeem_by_35_50 != 0) ? number_format(($redeem_by_35_50 / $total_coupon) * 100, 2) : 0;
        $data['redeem_by_above_50_per'] = ($redeem_by_above_50 != 0) ? number_format(($redeem_by_above_50 / $total_coupon) * 100, 2) : 0;
        $data['redeem_by_18_below'] = $redeem_by_18_below;
        $data['redeem_by_18_34'] = $redeem_by_18_34;
        $data['redeem_by_35_50'] = $redeem_by_35_50;
        $data['redeem_by_above_50'] = $redeem_by_above_50;
        return $data;
    }

    public static function addCouponReedem($data) {
        $coupon = new CouponRedeem();
        $coupon->user_id = $data['user_id'];
        $coupon->coupon_id = $data['coupon_id'];
        $coupon->is_redeem = self::IS_TRUE;
        if ($coupon->save()) {
            return $coupon;
        }
        return false;
    }

}
