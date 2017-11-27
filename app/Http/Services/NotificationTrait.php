<?php

namespace App\Http\Services;

use App\User;

trait NotificationTrait {



    public function finalNotifyMessage($from_id,$to_id,$coupon,$message) {

        $userfrom = User::find($from_id);
        $tofrom = User::find($to_id);
        $fromid = (!empty($userfrom) ? $userfrom->userDetail->first_name . " " . $userfrom->userDetail->last_name : '');
        $toid = (!empty($tofrom) ? $tofrom->userDetail->first_name . " " . $tofrom->userDetail->last_name : '');
        $coupon_name = \App\Coupon::getCouponDetail(['coupon_id' => $coupon->coupon_id]);
        $find = ['{{coupon_name}}','{{vendor_name}}'];
        $replace = [empty($coupon) ? "" : $coupon->coupon_name,empty($coupon) ?"":$coupon->vendorDetail->vendor_name];
        $message = str_replace($find, $replace, $message);
        return $message;
    }

}
