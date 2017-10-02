<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\CouponTrait;
use Auth;

class Activity extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use CouponTrait;

    public $table = 'activity';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'activity_id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

      protected $fillable = [
        'activity_id','coupon_id','activity_name_creator','activity_name_friends','total_like',
          'total_share','total_comment','created_by'
    ];
    /**
     * Get the coupon detail record associated with the activity.
     */
    public function coupon() {
     return $this->hasOne('App\Coupon', 'coupon_id', 'coupon_id'); 
    }
    
    public function user() {
     return $this->hasOne('App\UserDetail', 'user_id', 'created_by'); 
    }
    
    public function activitylike() {
     return $this->hasOne('App\ActivityShare', 'activity_id', 'activity_id')->where('user_id',Auth::id()); 
    }
    public static function addActivity($data, $userid) {
   
        $activity = new Activity();
        $activity->activity_name_creator = \Config::get('constants.ACTVITY_CREATOR_MESSAGE');
        $activity->activity_name_friends = \Config::get('constants.ACTVITY_FRIEND_MESSAGE');
        $activity->coupon_id = $data['coupon_id'];
        $activity->created_by = $userid;
        $activity->save();
        return $activity;

    }
    
    public static function activityList(){
       
       $activity= Activity::select('activity.activity_id','total_like','total_share','activity_name_friends',
               'activity.created_by','total_comment','count_fb_friend','activity_name_creator','activity.coupon_id'
               )
               ->leftJoin('coupon_share', 'coupon_share.activity_id', '=', 'activity.activity_id')
               ->where(function($q) {
                $q->where('created_by',Auth::id())
                   ->orWhere('share_friend_id',Auth::id());
            })->groupby('activity_id')
           ->get();
        return $activity;
    }
    
      public static function redeemActivity($data, $userid) {
   
        $activity = new Activity();
        $activity->activity_name_creator = '';
        $activity->activity_name_friends = \Config::get('constants.ACTVITY_FRIEND_REDEEM');
        $activity->coupon_id = $data['coupon_id'];
        $activity->created_by = $userid;
        $activity->save();
        $friendlist= ($activity->getCouponShareFriend($data['coupon_id']));
        $array_unique=array_map("unserialize", array_unique(array_map("serialize", $friendlist)));
        CouponShare::addRedeemCoupon($array_unique,$data['coupon_id'],$activity);
        return $activity;

    }

}
