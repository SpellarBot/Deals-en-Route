<?php
namespace App\Http\Services;

use App\Coupon;
use App\CouponShare;
use Auth;

trait CouponTrait {
    

    //get count of friend list
    public function getCouponShareCount($couponid){
    return CouponShare::where(['user_id' => Auth::id()])
            ->where(['coupon_id' =>$couponid])
            ->count();
    }
    
    public function finalMessage($message,$item){
      
        $find=['{{coupon_name}}','{{count}}','{{created_by}}'];
        $replace=[$item->coupon->coupon_name,$item->count_fb_friend,$item->user->first_name." ".$item->user->last_name];
        $message = str_replace($find, $replace, $message);
        return $message;
    }
}

