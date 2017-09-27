<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Auth;
use App\Http\Transformer\ActivityTransformer;

class ActivityController extends Controller
{
    
    use \App\Http\Services\ResponseTrait;
    
    public function checkFb(Request $request){
        $data=$request->all();
       
        $user= Auth::user()->userDetial;
        $data = (new ActivityTransformer)->transformCheckFb($user);
        return $this->responseJson('success', \Config::get('constants.USER_DETAIL'), 200, $data);
        
    }
    
    public function addFbFriend(Request $request){
         try {
            // get the request
            $data = $request->all();
            $user=Auth::user()->id;
            //add fb token
            $user_detail = \App\UserDetail::saveUserDetail($data,$user);
            //add fb friend list
            \App\UserFbFriend::saveFbFriend($data, $user);
            \App\CouponShare::addShareCoupon($data);
            return $this->responseJson('success', \Config::get('constants.ADD_FB_FRIEND'), 200);
       } catch (\Exception $e) {
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }  
        
    }
    
    
}
