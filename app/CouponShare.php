<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\UserTrait;
use App\Http\Services\NotificationTrait;
use DB;
use Auth;
use URL;
use App\Notifications\FcmNotification;
use Illuminate\Notifications\Notifiable;
use Notification;

class CouponShare extends Model {

    use UserTrait;
    use Notifiable;
    use NotificationTrait;

    public $table = 'coupon_share';
    public $primaryKey = 'share_id';
    public $timestamps = false;

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    protected $fillable = [
        'activity_id', 'share_id', 'share_friend_id', 'share_token_id', 'user_id'
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

    public static function addShareCoupon($data, $couponid, $activity) {

        if (isset($data) && !empty($data)) {

//            $delete = CouponShare::where('user_id', $userid)->delete();
//            if ($delete) {
//                DB::statement("ALTER TABLE coupon_share AUTO_INCREMENT = 1;");
//            }
            $datafb = [];
            $userid = [];
            $creator_id = Auth::user();
            foreach ($data as $k => $v) {

                $fbfriend = new CouponShare();
                $userid[] = $fbfriend->getFbFriendId($v);

                $datafb[] = [
                    'coupon_id' => $couponid,
                    'user_id' => $creator_id->id,
                    'share_token_id' => $v,
                    'share_friend_id' => $fbfriend->getFbFriendId($v),
                    'activity_id' => $activity->activity_id
                ];
            }
            $user = User::leftJoin('user_detail', 'user_detail.user_id', '=', 'users.id')
                    ->whereIn('id', $userid)
                    ->get();

            $coupon = Coupon::find($couponid);
            $fMessage = $coupon->finalNotifyMessage(Auth::id(), '', $coupon, \Config::get('constants.NOTIFY_SHARED_COUPON'));

            // send notification to your friends
            Notification::send($user, new FcmNotification([
                'type' => 'sharecoupon',
                'notification_message' => \Config::get('constants.NOTIFY_SHARED_COUPON'),
                'message' => $fMessage,
                'name' => $creator_id->userDetail->first_name . ' ' . $creator_id->userDetail->last_name,
                'image' => (!empty($coupon->coupon_logo)) ? URL::to('/storage/app/public/coupon_logo/tmp') . '/' . $coupon->coupon_logo : "",
                'coupon_id' => $coupon->coupon_id
            ]));

            // send notification to yourself
            Notification::send($creator_id, new FcmNotification([
                'type' => 'sharedcoupon',
                'notification_message' => \Config::get('constants.NOTIFY_SHARE_COUPON'),
                'message' => \Config::get('constants.NOTIFY_SHARE_COUPON'),
                'image' => (!empty($coupon->coupon_logo)) ? URL::to('/storage/app/public/coupon_logo/tmp') . '/' . $coupon->coupon_logo : "",
                'coupon_id' => $coupon->coupon_id
            ]));


            if (CouponShare::insert($datafb)) {
                if ($activity->getCouponShareCount($activity->activity_id, $couponid) == 1) {
                    Activity::where('activity_id', $activity->activity_id)
                            ->update(['count_fb_friend' => $activity->getCouponShareCount($activity->activity_id, $couponid),
                                'activity_name_creator' => \Config::get('constants.ACTVITY_CREATOR_MESSAGE_1')]);
                } else {
                    Activity::where('activity_id', $activity->activity_id)
                            ->update(['count_fb_friend' => $activity->getCouponShareCount($activity->activity_id, $couponid)]);
                }
            }
        }
    }

    public static function addRedeemCoupon($data, $couponid, $activity) {

        if (isset($data) && !empty($data)) {

            $datafb = [];
            $userid = Auth::id();
            foreach ($data as $k => $v) {

                $fbfriend = new CouponShare();
                $datafb[] = [
                    'coupon_id' => $couponid,
                    'user_id' => $userid,
                    'share_friend_id' => $v['user_id'],
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

            Activity::where('activity_id', $activity->activity_id)
                    ->update(['count_fb_friend' => $activity->getCouponActivityFriendCount($activity->activity_id, $couponid, $userid)]);
        }
    }

    public static function couponShareList($data) {
        $user = Auth()->user()->userDetail;
        $lat = $user->latitude;
        $lng = $user->longitude;
        $circle_radius = \Config::get('constants.EARTH_RADIUS');
        $result = CouponShare::
                select(DB::raw('coupon.coupon_id,coupon_lat,coupon_long,coupon_original_price,coupon_total_discount,'
                                . 'coupon_share.coupon_id,coupon_start_date,'
                                . 'coupon_end_date,coupon_detail,'
                                . 'coupon_name,coupon_logo,created_bycoupon_category_id,((' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(coupon_lat)) * cos(radians(coupon_long) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(coupon_lat))))) as distance'))
                ->leftJoin('coupon', 'coupon_share.coupon_id', '=', 'coupon.coupon_id')
                ->where('share_friend_id', Auth::id())
                ->where('is_active', self::IS_TRUE)
                ->where('is_delete', self::IS_FALSE)
                ->groupBy('coupon_share.coupon_id')
                ->orderBy('coupon_share.share_id', 'desc')
                ->simplePaginate(\Config::get('constants.PAGINATE'));
        return $result;
    }

}
