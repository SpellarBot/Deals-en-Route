<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use Auth;
use App\Http\Transformer\ActivityTransformer;
use App\Http\Transformer\UserTransformer;
use Carbon\Carbon;
use App\ActivityCommentLike;

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
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function acivityAddCommentLike(Request $request) {
        try {
            // get the request
            $data = $request->all();
            //add like
            $activitycommentlike = ActivityCommentLike::addCommentLike($data);
            if ($activitycommentlike) {
                return $this->responseJson('success', \Config::get('constants.ACTIVITY_COMMENT_LIKE_SUCCESS'), 200);
            }
            return $this->responseJson('success', \Config::get('constants.APP_ERROR'), 400);
        } catch (\Exception $e) {
            throw $e;
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
                if (array_key_exists('parent_id', $data) && !empty($data['parent_id'])) {
                    $comment->parent_id = $data['parent_id'];
                } else {
                    $comment->parent_id = $comment->comment_id;
                }
                $comment->save();
                $activity = \App\Activity::where('activity_id', $data['activity_id'])->first();
                $activity->total_comment = $this->getCommentCount($data['activity_id']);
                $activity->save();
                if ($activity->save() && $activity->created_by != Auth::id()) {
                    \App\ActivityShare::sendActivityNotification($activity, 'activitycomment', \Config::get('constants.ACTIVITY_COMMENT'), $comment);
                }
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
            $comment = \App\Comment::where('comment_id', $data['comment_id'])->first();
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

    public function addnotificationallread(Request $request) {
        try {
            $user = Auth::user();
            $user->unreadNotifications()->update(['read_at' => Carbon::now(), 'is_read' => 1]);
            return $this->responseJson('success', \Config::get('constants.NOTI_SUCCESS'), 200);
        } catch (\Exception $e) {
            // throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function getActivityComments(Request $request) {

        try {
            $data = $request->all();
            //find nearby coupon
            $activity = \App\Activity::getActivityDetails($data);
            if (count($activity) > 0) {
                $data['activity_details'] = (new ActivityTransformer)->transformActivityDetails($activity);
                $getComments = \App\Comment::getCommentsByActivity($data['activity_id']);
                $data['comments_list'] = [];
                foreach ($getComments as $comment) {
                    $com = $comment->getAttributes();
                    $dt = new Carbon($com['updated_at']);
                    $getUser = \App\UserDetail::find($com['created_by']);
                    $comment_details['user_id'] = $getUser->user_id;
                    $comment_details['comment_by'] = $getUser->first_name . ' ' . $getUser->last_name;
                    $comment_details['profile_pic'] = ($getUser->profile_pic ? asset('storage/app/public/profile_pic/' . $getUser->profile_pic) : asset('storage/app/public/profile_pic/'));
                    if ($com['liked_by'] === auth()->id() && $com['is_like'] === 1) {
                        $comment_details['is_liked'] = 1;
                    } else {
                        $comment_details['is_liked'] = 0;
                    }
                    $comment_details['comment'] = $com['comment_desc'];
                    $comment_details['comment_time'] = $dt->diffForHumans();
                    array_push($data['comments_list'], $comment_details);
                }
                return $this->responseJson('success', \Config::get('constants.COUPON_DETAIL'), 200, $data);
            }
            return $this->responseJson('success', \Config::get('constants.NO_DEAL'), 200);
        } catch (\Exception $e) {
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

}
