<?php

namespace App\Http\Services;

use App\Coupon;
use App\CouponShare;
use Auth;
use Carbon\Carbon;
use App\User;
use DB;

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
    public function getCouponActivityFriendCount($activityid, $couponid, $userid) {

        return CouponShare::where(['user_id' => $userid])
                        ->where(['coupon_id' => $couponid])
                        ->where(['activity_id' => $activityid])
                        ->count();
    }

    public function getCouponShareFriend($couponid, $userid) {
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

        if ($item->count_fb_friend == '' || $item->count_fb_friend == 0) {
            $count = 0;
        } else {
            $count = $item->count_fb_friend - 1;
        }
        $share_friend = $this->getUserDetail($item->share_friend_id);
        $find = ['{{coupon_name}}', '{{count}}', '{{created_by}}', '{{shared_name}}'];
        if (empty($share_friend)) {
        
            $replace = [(!empty($item->coupon)?$item->coupon->coupon_name:'') , $count, $item->user->first_name . " " . $item->user->last_name
            ];
        } else {
            $replace = [$item->coupon->coupon_name, $count, $item->user->first_name . " " . $item->user->last_name,
                $share_friend->first_name . " " . $share_friend->last_name];
        }
        $message = str_replace($find, $replace, $message);
        return $message;
    }

    public static function convertDateInUtc($date) {

        $date = Carbon::parse($date);
        $authtimezone = User::find(Auth::id())->vendorDetail->vendor_time_zone;
        if (strpos($authtimezone, '-') !== false) {
            $timezone = str_replace('-', '', $authtimezone);
            $finalDate = $date->subMinutes($timezone);
        } else if (strpos($date, '+') !== false) {
            $timezone = str_replace('+', '', $authtimezone);
            $finalDate = $date->addMinutes($timezone);
        } else {
            $finalDate = $date;
        }
        return $finalDate;
    }

    public static function convertDateInUserTZ($date) {

        $date = Carbon::parse($date);
        $authtimezone = User::find(Auth::id())->vendorDetail->vendor_time_zone;
        if (strpos($authtimezone, '-') !== false) {
            $timezone = str_replace('-', '', $authtimezone);
            $finalDate = $date->addMinutes($timezone);
        } else if (strpos($date, '+') !== false) {
            $timezone = str_replace('+', '', $authtimezone);
            $finalDate = $date->subMinutes($timezone);
        } else {
            $finalDate = $date;
        }
        return $finalDate;
    }

    public function getUserNotificationOffer($toid, $couponid, $type) {

        return \App\Notifications::where('notifiable_id', $toid)
                        ->where('coupon_id', $couponid)
                        ->where(\DB::raw('date_format(created_at,"%Y-%m-%d")'), date('Y-m-d'))
                        ->where(function($q) {
                                $q->where(['type' => 'newcoupon'])
                                ->orWhere('type', 'geonotification');
                            })
                        ->count();
    }

    public function getUserNotification($toid, $couponid, $type) {

        return \App\Notifications::where('notifiable_id', $toid)
                        ->where('coupon_id', $couponid)
                        ->where('type', $type)
                        ->count();
    }

    public static function getLastYear() {

        return [date('Y') => date('Y'), date('Y') - 1 => date('Y') - 1, date('Y') - 2 => date('Y') - 2, date('Y') - 3 => date('Y') - 3];
    }

    // and CURDATE() between date_format(startdate,'%Y-%m-%d') and date_format(enddate,'%Y-%m-%d') group by `user_id`
    public function userAccess() {
        $array = [];
        $dt = date('Y-m-d');

        $vendor_detail = \App\VendorDetail::join('stripe_users', 'stripe_users.user_id', 'vendor_detail.user_id')
                ->join('subscriptions', 'subscriptions.stripe_id', 'stripe_users.stripe_id')
                ->where(\DB::raw('TIMESTAMP(`startdate`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`enddate`)'), '>=', date('Y-m-d H:i:s'))
                ->where('vendor_detail.user_id', Auth::id())
                ->first();

        $add_ons = \App\PlanAddOns::select(DB::raw('SUM(case when addon_type="geolocation" then quantity else 0 end) as geolocationtotal,
                 SUM(case when addon_type="geofencing" then quantity else 0 end) as geofencingtotal,
                 SUM(case when addon_type="deals" then quantity else 0 end) as dealstotal,startdate,enddate,user_id'))
                ->where('user_id', Auth::id())
                ->where(\DB::raw('TIMESTAMP(`startdate`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`enddate`)'), '>=', date('Y-m-d H:i:s'))
                ->get();
        if (empty($vendor_detail)) {
            $array['geolocationtotal'] = 0;
            $array['geofencingtotal'] = 0;
            $array['dealstotal'] = 0;
            $array['additionalgeolocation']=0;
            $array['additionalgeofencing']=0;
            $array['basicgeolocation']=0;
           $array['basicgeofencing']=0;
        } else {
            $currentpackagedeal = $vendor_detail->userSubscription[0]->deals + $add_ons[0]->dealstotal;
            $previousleftdeal = $vendor_detail->deals_used;
            $totaldealsleft = $currentpackagedeal - $previousleftdeal;
            $array['geolocationtotal'] = $add_ons[0]->geolocationtotal + $vendor_detail->userSubscription[0]->geolocation;
            $array['geofencingtotal'] = $add_ons[0]->geofencingtotal + $vendor_detail->userSubscription[0]->geofencing;
            $array['dealstotal'] = $totaldealsleft;
            $array['additionalgeolocation']=$add_ons[0]->geolocationtotal;
           $array['additionalgeofencing']=$add_ons[0]->geofencingtotal;
            $array['basicgeolocation']=$vendor_detail->userSubscription[0]->geolocation;
           $array['basicgeofencing']=$vendor_detail->userSubscription[0]->geofencing;
        
        }
        return $array;
    }
    
    
    // get user payment peroid
    
    public function getUserPaymentPeroid($userid=''){
        
        $user_id=(empty($userid)?Auth::id(): $userid);
         $subscription= \App\VendorDetail::select('subscriptions.startdate','subscriptions.enddate','subscriptions.trial_ends_at')
                ->join('subscriptions', 'subscriptions.user_id', 'vendor_detail.user_id')
                ->where(\DB::raw('TIMESTAMP(`startdate`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`enddate`)'), '>=', date('Y-m-d H:i:s'))
                ->where('vendor_detail.user_id', $user_id)
                ->first();
         
          
          if($subscription){
           $final_array=[];
           $trial_end =Carbon::parse($subscription->trial_ends_at);
           $current_date = Carbon::now(); 
           $final_array['is_trial']=($current_date <=$trial_end)?1:0;
           $final_array['days_left']=$cDate = Carbon::parse($subscription->enddate)->diffInDays(); 
           return $final_array;  
          }else{
           $final_array['is_trial']=0;
           $final_array['days_left']="expire"; 
          }
         
    
    }
    
  

}
