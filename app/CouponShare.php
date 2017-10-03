<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\UserTrait;
use DB;
use Auth;
use URL;

class CouponShare extends Model {

    use UserTrait;

    public $table = 'coupon_share';
    public $primaryKey = 'share_id';
    public $timestamps = false;
    const IS_TRUE = 1;
    const IS_FALSE = 0;
  protected $fillable = [
        'activity_id','share_id','share_friend_id','share_token_id','user_id'
    ];
    
       /**
     * Get the vendor detail record associated with the user.
     */
    public function vendorDetail() {
        return $this->hasOne('App\VendorDetail', 'user_id', 'created_by');
    }
    
    
    public function getCouponLogoAttribute($value) {
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/coupon_logo/' . $value))) ? URL::to('/storage/app/public/coupon_logo') . '/' . $value : "";
    }
    public static function addShareCoupon($data, $couponid,$activity) {

        if (isset($data) && !empty($data)) {
            
//            $delete = CouponShare::where('user_id', $userid)->delete();
//            if ($delete) {
//                DB::statement("ALTER TABLE coupon_share AUTO_INCREMENT = 1;");
//            }
            $datafb = [];
             $userid=Auth::id();
            foreach ($data as $k=>$v) {

                $fbfriend = new CouponShare();
                $datafb[] = [
                    'coupon_id' =>$couponid,
                    'user_id' => $userid,
                    'share_token_id' => $v,
                    'share_friend_id' => $fbfriend->getFbFriendId($v),
                    'activity_id' => $activity->activity_id
                ];
//                 $couponfriendcount = CouponShare::where('user_id', $userid)
//                      ->where('share_friend_id', $fbfriend->getFbFriendId($v))
//                         ->where('coupon_id', $couponid)
//                         ->where('activity_id', $activity->activity_id)
//                         ->first();
// 
//                    if (!empty($couponfriendcount)) {
//                        unset($datafb[$k]);
//                    }
            }
            CouponShare::insert($datafb);
            Activity::where('activity_id',$activity->activity_id)
                ->update(['count_fb_friend' =>  $activity->getCouponShareCount($activity->activity_id,$couponid)]);
        }
    }
  
    
     public static function addRedeemCoupon($data, $couponid,$activity) {
    
        if (isset($data) && !empty($data)) {

            $datafb = [];
             $userid=Auth::id();
            foreach ($data as $k=>$v) {

                $fbfriend = new CouponShare();
                $datafb[] = [
                    'coupon_id' =>$couponid,
                    'user_id' => $userid,   
                    'share_friend_id' =>$v['user_id'],
                    'activity_id' => $activity->activity_id
                ];
//                 $couponfriendcount = CouponShare::where('user_id', $userid)
//                      ->where('share_friend_id', $v['user_id'])
//                         ->where('coupon_id', $couponid)
//                         ->where('activity_id', $activity->activity_id)
//                         ->first();
// 
//                    if (!empty($couponfriendcount)) {
//                        unset($datafb[$k]);
//                    }
            }
            CouponShare::insert($datafb);
            Activity::where('activity_id',$activity->activity_id)
                ->update(['count_fb_friend' =>  $activity->getCouponShareCount($activity->activity_id,$couponid)]);
        }
    
     
     }
    
       public static function couponShareList($data) {
        $user = Auth()->user()->userDetail;

        $result = CouponShare::
                select(DB::raw('coupon.coupon_id,coupon_lat,coupon_long,'
                        . 'coupon_share.coupon_id,coupon_start_date,'
                        . 'coupon_end_date,coupon_detail,'
                         . 'coupon_name,coupon_logo,created_by,coupon_category_id'))
                ->leftJoin('coupon', 'coupon_share.coupon_id', '=', 'coupon.coupon_id')
                ->where('share_friend_id',Auth::id())
                ->where('is_active', self::IS_TRUE)
                ->where('is_delete', self::IS_FALSE)
                ->groupBy('coupon_share.coupon_id')
                ->orderBy('coupon_share.share_id','desc')
                ->get();
        return $result;
    }

}
