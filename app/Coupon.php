<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use URL;
use Auth;

class Coupon extends Model {



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'coupon';

    const CREATED_AT = 'createddate';
    const UPDATED_AT = 'updateddate';

    public $primaryKey = 'coupon_id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    protected $fillable = [
        'coupon_id', 'coupon_category_id', 'coupon_name', 'coupon_detail', 'coupon_logo',
        'coupon_start_date', 'coupon_end_date', 'coupon_redemption_code',
        'coupon_qrcode', 'coupon_code', 'coupon_lat', 'coupon_long', 'coupon_radius',
        'coupon_total_redeem', 'coupon_redeem_limit', 'is_active', 'is_delete',
        'created_at', 'updated_at', 'created_by'
    ];

    public function scopeActive($query) {
        return $query->where('is_active', self::IS_TRUE);
    }

    public function scopeDeleted($query) {
        return $query->where('is_delete', self::IS_FALSE);
    }

    public function getCouponLogoAttribute($value) {
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/coupon_logo/' . $value))) ? URL::to('/storage/app/public/coupon_logo') . '/' . $value : "";
    }

    public function getCouponQrcodeImageAttribute($value) {
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/qr_code_image/' . $value))) ? URL::to('/storage/app/public/qr_code_image') . '/' . $value : "";
    }

    public function getCouponOfferLogoAttribute($value) {
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/coupon_offer_logo/' . $value))) ? URL::to('/storage/app/public/coupon_offer_logo') . '/' . $value : "";
    }

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

    public static function getNearestCoupon($data) {

        $user = Auth()->user()->userDetail;
        $circle_radius = \Config::get('constants.EARTH_RADIUS');

        $lat = $user->latitude;
        $lng = $user->longitude;
        $id = $user->category_id;
        $idsArr = explode(',', $id);
        $query = Coupon::active()->deleted()
                ->select(DB::raw('coupon_id,coupon_radius,coupon_start_date,coupon_end_date,coupon_detail,'
                                . 'coupon_name,coupon_logo,created_by,coupon_lat,'
                                . 'coupon_long,coupon_category_id,((' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(coupon_lat)) * cos(radians(coupon_long) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(coupon_lat)))) ) as distance'))
                ->where(\DB::raw('TIMESTAMP(`coupon_start_date`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`coupon_end_date`)'), '>=', date('Y-m-d H:i:s'))
                ->whereColumn('coupon_total_redeem', '<', 'coupon_redeem_limit')
                ->havingRaw('coupon_radius >= distance');
        if (isset($data['category_id'])) {
            $query->where('coupon_category_id', $data['category_id']);
        } else if (isset($data['search'])) {
            $keyword = $data['search'];
            $query->whereIn('coupon_category_id', $idsArr);
            $query->where(function($q) use ($idsArr, $keyword) {
                $q->where(DB::raw("CONCAT(coupon_name,' ',coupon_detail)"), "LIKE", "%$keyword%")
                        ->orWhere(DB::raw("CONCAT(coupon_name,'',coupon_detail)"), "LIKE", "%$keyword%")
                        ->orWhere("coupon_name", "LIKE", "%$keyword%")
                        ->orWhere("coupon_detail", "LIKE", "%$keyword%");
            });
        } else {
            $query->whereIn('coupon_category_id', $idsArr);
        }

        $result = $query->orderBy('distance')->get();
        return $result;
    }

 
    public static function getCouponDetail($data) {


        $query = Coupon::active()->deleted()
                ->where('coupon_id', $data['coupon_id'])
                ->first();

        return $query;
    }

}
