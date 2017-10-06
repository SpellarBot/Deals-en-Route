<?php
namespace App\Http\Services;

use App\CouponCategory;

trait ActivityTrait {
    

    
    public function getActivityLikeCount($activityid){
        
      return  \App\ActivityShare::where('activity_id',$activityid)
                ->where('is_like',1)
                ->count();
    }
    
       public function getCommentCount($activityid){
        
      return \App\Comment::where('activity_id',$activityid)
                ->count();
    }
    
     public function getUserNotification($toid,$couponid,$type){
        
      return \App\Notifications::where('notifiable_id',$toid)
              ->where('coupon_id',$couponid)
              ->where('type',$type)
              ->count();
    }
    
    public function getUserNotificationOffer($toid,$couponid,$type){
        
      return \App\Notifications::where('notifiable_id',$toid)
              ->where('coupon_id',$couponid)
              ->where('type',$type)
              ->where(\DB::raw('date_format(created_at,"%Y-%m-%d")'),date('Y-m-d'))
              ->count();
    }
    
     
    
    
 
}

