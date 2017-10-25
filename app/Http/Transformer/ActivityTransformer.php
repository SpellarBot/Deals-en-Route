<?php

namespace App\Http\Transformer;

use URL;
use Carbon\Carbon;
use Auth;
use \App\Http\Services\CouponTrait;
use  \App\Http\Services\UserTrait;
class ActivityTransformer {
    
    use CouponTrait;
    
    
    public function transformCheckFb($user){
        return [
            'is_fbconnected' => (!empty($user->fb_token)?0:1)
            
         ]; 
    }
    
      public function transformActivityList($data){
         
        $var = [];
       foreach($data as $item){
           $user=$item->getUserDetail($item->created_by);
            if (strpos($item->activity_message, 'created_by') !== false) {
                $name=$user->first_name."".$user->last_name ;
            }else{
                 $name='you';
            }   
            $image=(!empty($user->profile_pic)) ? URL::to('/storage/app/public/profile_pic/tmp') . '/' . $user->profile_pic : "";
           
            $fmessage=$this->finalMessage($item->activity_message,$item);
            $var[]= [
                'activity_id'=>$item->activity_id??'',   
                'activity_name'=>$fmessage,
                'total_like'=>$item->total_like,
                'total_share'=>$item->total_share??0,
                'total_comment'=>$item->total_comment??0,
                'is_like'=>$item->activitylike->is_like??0,
                'name'=>$name,
                'image'=>$image,
                
            ];
           }
         
              return ['has_page'=>$data->hasMorePages(),'current_page'=>$data->currentPage(),'listing'=>$var];
  
          
        
          
      }
      
       public function transformCommentList($data) {
           
        $var = [];
        $var = $data->map(function ($item) {
               
            return [
                'comment_id'=>$item->comment_id??'',
                'activity_id'=>$item->activity_id??'',   
                'comment_desc'=>$item->comment_desc??'',
                'created_by'=>$item->user->first_name." ".$item->user->last_name??'',
                'creator_image'=>(!empty($item->user->profile_pic)) ? URL::to('/storage/app/public/profile_pic') . '/' . $item->user->profile_pic : "",
            ];
        });
        return $var;
       }
    
}

