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
           $activity= \App\Activity::addActivity($data,$user);

            \App\CouponShare::addShareCoupon($data,$user,$activity);
            
            return $this->responseJson('success', \Config::get('constants.ADD_FB_FRIEND'), 200);
       } catch (\Exception $e) {
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }  
        
    }
    
    
    public function activityList(Request $request){
           try {
            // get the request
            $data = $request->all();

            //find nearby coupon
            $activitylist = \App\Activity::activityList();
            if (count($activitylist) > 0) {
                $data = (new ActivityTransformer)->transformActivityList($activitylist);
                return $this->responseJson('success', \Config::get('constants.ACTIVITY_LIST'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
             throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }
    
    
    public function acivityAddLike(Request $request){
              try {
            // get the request
            $data = $request->all();
            //add like
            $activitylist = \App\ActivityShare::addLike($data);
            if ($activitylist) {  
                return $this->responseJson('success', \Config::get('constants.ACTIVITY_LIKE_SUCCESS'), 200);
            }
            return $this->responseJson('success', \Config::get('constants.APP_ERROR'), 400);
        } catch (\Exception $e) {
             throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }
    
}
