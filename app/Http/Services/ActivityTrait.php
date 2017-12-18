<?php

namespace App\Http\Services;

use App\CouponCategory;
use App\User;

trait ActivityTrait {

    public function getActivityLikeCount($activityid) {

        return \App\ActivityShare::where('activity_id', $activityid)
                        ->where('is_like', 1)
                        ->count();
    }

    public function getCommentCount($activityid) {

        return \App\Comment::where('activity_id', $activityid)
                        ->count();
    }

   

    
    public  function finalActivityMessage($from_id,$message,$couponname) {

        $userfrom = User::find($from_id);

        $fromid = (!empty($userfrom) ? $userfrom->userDetail->first_name . " " . $userfrom->userDetail->last_name : '');
        $find = ['{{like_friend}}','{{comment_friend}}','{{coupon_name}}'];
        $replace = [$fromid,$fromid,$couponname];
        $message = str_replace($find, $replace, $message);
        return $message;
    }


}
