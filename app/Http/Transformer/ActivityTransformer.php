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
        $var = $data->map(function ($item) {
          
            if($item->created_by==Auth::id()){
                $message=$item->activity_name_creator??'';
            }else {
                $message=$item->activity_name_friends??'';
            }
            $fmessage=$this->finalMessage($message,$item);
            return [
                'activity_id'=>$item->activity_id??'',   
                'activity_name'=>$fmessage,
                'total_like'=>$item->total_like,
                'total_share'=>$item->total_share??0,
                'total_comment'=>$item->total_comment??0,
                'is_like'=>$item->activitylike->is_like??0
       
                
            ];
        });
        return $var;
      }
    
}

