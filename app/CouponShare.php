<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\UserTrait;

class CouponShare extends Model {

    use UserTrait;

    public $table = 'coupon_share';
    public $primaryKey = 'share_id';
    public $timestamps = false;

  protected $fillable = [
        'activity_id','share_id','share_friend_id','share_token_id','user_id'
    ];
    
    public static function addShareCoupon($data, $userid,$activity) {

        if (isset($data['fb_friend']) && !empty($data['fb_friend'])) {
            $fbfriend = $data['fb_friend'];
            $ex = explode(',', $fbfriend);
//            $delete = CouponShare::where('user_id', $userid)->delete();
//            if ($delete) {
//                DB::statement("ALTER TABLE coupon_share AUTO_INCREMENT = 1;");
//            }
            $datafb = [];

            foreach ($ex as $k=>$v) {
  
                $fbfriend = new CouponShare();
                $datafb[] = [
                    'coupon_id' => $data['coupon_id'],
                    'user_id' => $userid,
                    'share_token_id' => $v,
                    'share_friend_id' => $fbfriend->getFbFriendId($v),
                    'activity_id' => $activity->activity_id
                ];
                 $twiliosid = CouponShare::where('user_id', $userid)
                      ->where('share_friend_id', $fbfriend->getFbFriendId($v))
                         ->where('coupon_id', $data['coupon_id'])
                         ->where('activity_id', $activity->activity_id)
                         ->first();
 
                    if (!empty($twiliosid)) {
                        unset($datafb[$k]);
                    }
            }
            CouponShare::insert($datafb);
            Activity::where('activity_id',$activity->activity_id)
                ->update(['count_fb_friend' =>  $activity->getCouponShareCount($data['coupon_id'])]);
        }
    }

}
