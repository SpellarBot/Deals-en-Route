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
    
    
 
}

