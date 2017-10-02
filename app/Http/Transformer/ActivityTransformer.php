<?php

namespace App\Http\Transformer;

use URL;
use Carbon\Carbon;
use Auth;
use \App\Http\Services\CouponTrait;
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
       
            if($item->created_by==Auth::id()){
                $message=$item->activity_name_creator??'';
            }else {
                $message=$item->activity_name_friends??'';
            }
           if(!empty($message)){
            $fmessage=$this->finalMessage($message,$item);
            $var[]= [
                'activity_id'=>$item->activity_id??'',   
                'activity_name'=>$fmessage,
                'total_like'=>$item->total_like,
                'total_share'=>$item->total_share??0,
                'total_comment'=>$item->total_comment??0,
                'is_like'=>$item->activitylike->is_like??0
       
                
            ];
           }
         
           }
          
        
        return $var;
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

