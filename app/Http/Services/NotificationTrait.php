<?php

namespace App\Http\Services;

use App\User;

trait NotificationTrait {

// pass id in from and to

    public function finalNotifyMessage($from_id,$to_id='',$coupon,$message) {

        $userfrom = User::find($from_id);
        $tofrom = User::find($to_id);
        $fromid = (!empty($userfrom) ? $userfrom->userDetail->first_name . " " . $userfrom->userDetail->last_name : '');
        $toid = (!empty($tofrom) ? $tofrom->userDetail->first_name . " " . $tofrom->userDetail->last_name : '');
        
        $find = ['{{coupon_name}}','{{vendor_name}}','{{from_id}}'];
        $replace = [empty($coupon) ? "" : $coupon->coupon_name,empty($coupon) ?"":$coupon->vendorDetail->vendor_name,$fromid];
        $message = str_replace($find, $replace, $message);
        return $message;
    }
    
    // pass user object in from and to
      public function finalTagMessage($userfrom='',$userto='',$coupon,$message) {

        
        $fromid = (!empty($userfrom) ? $userfrom->userDetail->first_name . " " . $userfrom->userDetail->last_name : '');
    
        $toid = (!empty($userto) ? $userto->userDetail->first_name . " " . $userto->userDetail->last_name : '');
        $find = ['{{coupon_name}}','{{vendor_name}}','{{from_id}}'];
        $replace = ['','',$fromid];
        $message = str_replace($find, $replace, $message);
        return $message;
    }

}
