<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Auth;
use App\Http\Transformer\ActivityTransformer;
use App\Http\Transformer\UserTransformer;
use Carbon\Carbon;

class ActivityController extends Controller {

    use \App\Http\Services\ResponseTrait;
    use \App\Http\Services\ActivityTrait;

    public function checkFb(Request $request) {
        $data = $request->all();

        $user = Auth::user()->userDetial;
        $data = (new ActivityTransformer)->transformCheckFb($user);
        return $this->responseJson('success', \Config::get('constants.USER_DETAIL'), 200, $data);
    }

    public function addFbFriend(Request $request) {
        try {

            // get the request
            $data = $request->all();
            $user = Auth::id();
            //add fb token
            $user_detail = \App\UserDetail::saveUserDetail($data, $user);
            //add fb friend list
            $activity = \App\Activity::addActivity($data, $user);
            $fbfriend = $data['fb_friend'];
            $exp = explode(',', $fbfriend);
            \App\CouponShare::addShareCoupon($exp, $data['coupon_id'], $activity);
            return $this->responseJson('success', \Config::get('constants.ADD_FB_FRIEND'), 200);
        } catch (\Exception $e) {
             //throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function activityList(Request $request) {
        try {
            // get the request
            $data = $request->all();

            //find nearby coupon
            $activitylist = \App\Activity::activityList();
            if (count($activitylist) > 0) {
                $activitydata = (new ActivityTransformer)->transformActivityList($activitylist);
                return $this->responseJson('success', \Config::get('constants.ACTIVITY_LIST'), 200, $activitydata);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
            // throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function acivityAddLike(Request $request) {
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
            //  throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function comment(Request $request) {
        try {
            // get the request
            $data = $request->all();

            //add comment
            $comment = new \App\Comment();
            $comment->created_by = Auth::id();
            $comment->fill($data);

            if ($comment->save()) {
                \App\Activity::where('activity_id', $data['activity_id'])
                        ->update(['total_comment' => $this->getCommentCount($data['activity_id'])]);
                return $this->responseJson('success', \Config::get('constants.COMMENT_ADD'), 200);
            }
            return $this->responseJson('success', \Config::get('constants.APP_ERROR'), 400);
        } catch (\Exception $e) {
            // throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }  

    public function commentList(Request $request) {
        try {
            // get the request
            $data = $request->all();

            //add like
            $comment = \App\Comment::where('activity_id', $data['activity_id'])->get();

            if (count($comment) > 0) {
                $commentdata = (new ActivityTransformer)->transformCommentList($comment);
                return $this->responseJson('success', \Config::get('constants.COMMENT_LIST'), 200, $commentdata);
            }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 400);
        } catch (\Exception $e) {
              throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function shareActivity(Request $request) {
        $data = $request->all();
        \App\Activity::where('activity_id', $data['activity_id'])->increment('total_share');
        return $this->responseJson('success', \Config::get('constants.SHARE_ACTIVITY'), 200);
    }

    public function addnotificationread(Request $request) {
        $data = $request->all();
        $user = Auth::user();
        $user->unreadNotifications()->where('id', $data['notification_id'])->update(['read_at' => Carbon::now(), 'is_read' => 1]);
        return $this->responseJson('success', \Config::get('constants.NOTI_SUCCESS'), 200);
    }

    public function notificationList(Request $request) {
        $data = $request->all();
        $user = Auth::user();
        if (count($user->notifications) > 0) {
            $userN = $user->notifications()->paginate(\Config::get('constants.PAGINATE'));
            $notificationlist = (new UserTransformer)->transformNotification($userN);
            return $this->responseJson('success', \Config::get('constants.NOTI_LIST'), 200, $notificationlist);
        }
        return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 400);
    }
    
    public function commentEdit(Request $request) {
           try {
            // get the request
            $data = $request->all();

            //update comment
            $comment = \App\Comment::where('comment_id',$data['comment_id'])->first();
            $comment->fill($data);

            if ($comment->save()) {
//                \App\Activity::where('activity_id', $data['activity_id'])
//                        ->update(['total_comment' => $this->getCommentCount($data['activity_id'])]);
                return $this->responseJson('success', \Config::get('constants.COMMENT_UPDATE'), 200);
            }
            return $this->responseJson('success', \Config::get('constants.APP_ERROR'), 400);
        } catch (\Exception $e) {
           //  throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
           
         
    }

}
