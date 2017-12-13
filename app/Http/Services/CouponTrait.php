<?php

namespace App\Http\Services;

use App\Coupon;
use App\CouponShare;
use Auth;
use Carbon\Carbon;
use App\User;

trait CouponTrait {

    //get count of friend list
    public function getCouponShareCount($activityid = "", $couponid) {
        if (empty($activityid)) {
            return CouponShare::where(['coupon_id' => $couponid])
                            ->where(function($q) {
                                $q->where(['user_id' => Auth::id()])
                                ->orWhere('share_friend_id', Auth::id());
                            })
                            ->count();
        }
        return CouponShare::where(['user_id' => Auth::id()])
                        ->where(['coupon_id' => $couponid])
                        ->where(['activity_id' => $activityid])
                        ->count();
    }
 //get count of friend list
    public function getCouponShareWebCount($couponid, $userid) {
       
            return CouponShare::where(['coupon_id' => $couponid])
                            ->where(function($q) use ($userid) {
                                $q->where(['user_id' => $userid])
                                ->orWhere('share_friend_id', $userid);
                            })
                            ->count();
        
      
    }
    //get count of friend list
    public function getCouponActivityFriendCount($activityid,$couponid, $userid) {
       
               return CouponShare::where(['user_id' => $userid])
                        ->where(['coupon_id' => $couponid])
                        ->where(['activity_id' => $activityid])
                        ->count();
        
      
    }
    public function getCouponShareFriend($couponid,$userid) {
        $coupon_share = CouponShare::select('share_friend_id as user_id')->where('user_id', $userid)
                ->where('coupon_id', $couponid)
                ->get()
                ->toArray();

        $coupon_owner = CouponShare::select('user_id as user_id')->where('share_friend_id', $userid)
                ->where('coupon_id', $couponid)
                ->get()
                ->toArray();


        return array_merge($coupon_share, $coupon_owner);
    }

    public function finalMessage($message, $item) {
        $count=$item->count_fb_friend-1;
        $share_friend = $this->getUserDetail($item->share_friend_id); 
        $find = ['{{coupon_name}}', '{{count}}', '{{created_by}}','{{shared_name}}'];
        $replace = [$item->coupon->coupon_name, $count, $item->user->first_name . " " . $item->user->last_name,
            $share_friend->first_name . " " . $share_friend->last_name];
        $message = str_replace($find, $replace, $message);
        return $message;
    }
    
    
    public static function convertDateInUtc($date){
      
      $date = Carbon::parse($date);
      $authtimezone=User::find(Auth::id())->vendorDetail->vendor_time_zone;  
      if (strpos($authtimezone, '-') !== false) {
          $timezone=str_replace('-','',$authtimezone); 
          $finalDate=$date->subMinutes($timezone);  
      }else if (strpos($date, '+') !== false) {
          $timezone=str_replace('+','',$authtimezone); 
          $finalDate=$date->addMinutes($timezone);  
      }else{
          $finalDate=$date;
      }
        return   $finalDate;
    }
    
    
    public static function convertDateInUserTZ($date){
      
      $date = Carbon::parse($date);
      $authtimezone=User::find(Auth::id())->vendorDetail->vendor_time_zone;  
      if (strpos($authtimezone, '-') !== false) {
          $timezone=str_replace('-','',$authtimezone); 
          $finalDate=$date->addMinutes($timezone);  
      }else if (strpos($date, '+') !== false) {
          $timezone=str_replace('+','',$authtimezone); 
          $finalDate=$date->subMinutes($timezone);  
      }else{
          $finalDate=$date;
      }
        return   $finalDate;
    }
    
   public function getUserNotificationOffer($toid, $couponid, $type) {

        return \App\Notifications::where('notifiable_id', $toid)
                        ->where('coupon_id', $couponid)
                        ->where('type', $type)
                        ->where(\DB::raw('date_format(created_at,"%Y-%m-%d")'), date('Y-m-d'))
                        ->count();
    }
    
     public function getUserNotification($toid, $couponid, $type) {

        return \App\Notifications::where('notifiable_id', $toid)
                        ->where('coupon_id', $couponid)
                        ->where('type', $type)
                        ->count();
    }
    
    public static function getLastYear(){
        
        return [date('Y')=>date('Y'),date('Y')-1=>date('Y')-1,date('Y')-2=>date('Y')-2,date('Y')-3=>date('Y')-3];
    }
    
    
   
    
    

   
    
}  
