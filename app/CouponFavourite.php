<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class CouponFavourite extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'coupon_favourite';
    public $primaryKey = 'favourite_id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    protected $fillable = [
        'user_id', 'coupon_id', 'created_at', 'updated_at', 'is_favorite'
    ];

    /**
     * Get the vendor detail record associated with the user.
     */
    public static function Coupon() {
        return $this->belongsToMany('App\Coupon', 'coupon_id', 'coupon_id');
    }

    //update or create favourtie coupon data ssss
    public static function addFavCoupon($data) {

        $addfav = CouponFavourite::updateOrCreate(['user_id' => Auth::id(),
                    'coupon_id' => $data['coupon_id']], ['user_id' => Auth::id(), 'coupon_id' => $data['coupon_id'],
                    'is_favorite' => $data['is_favourite']]
        );
        if ($addfav) {
            return true;
        }
        return false;
    }

    // coupon favorite list
    public static function getCouponFavList($data) {

        $user = Auth()->user()->userDetail;
        $lat = $user->latitude;
        $lng = $user->longitude;
        $circle_radius = \Config::get('constants.EARTH_RADIUS');

        $result = CouponFavourite::
                select(DB::raw('coupon.coupon_id,coupon_favourite.coupon_id,coupon_radius,coupon_start_date,coupon_end_date,coupon_detail,'
                                . 'coupon_name,coupon_logo,created_by,coupon_category_id,((' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(coupon_lat)) * cos(radians(coupon_long) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(coupon_lat)))) * 1609.34) as distance'))
                ->leftJoin('coupon', 'coupon_favourite.coupon_id', '=', 'coupon.coupon_id')
                ->where('is_active', self::IS_TRUE)
                ->where('is_delete', self::IS_FALSE)
                ->where('user_id', Auth::id())
                ->where('is_favorite', self::IS_TRUE)
                ->havingRaw('coupon_radius >= distance')
                ->orderBy('distance')
                ->get();


        return $result;
    }

}
