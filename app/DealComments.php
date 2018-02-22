<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Notification;
use App\Notifications\FcmNotification;
use App\Http\Transformer\CouponTransformer;
use Carbon\Carbon;
use URL;

class DealComments extends Model {

    use \App\Http\Services\ImageTrait;
    use \App\Http\Services\NotificationTrait;

    //
    public $table = 'deal_comments';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'id';
    protected $fillable = [
        'id', 'comment_by', 'comment_desc', 'coupon_id', 'created_at', 'updated_at', 'tag_user_id'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public static function addComment($data) {
        $addComment = DealComments::create(['comment_desc' => $data['comment'],
                    'comment_by' => Auth::id(),
                    'coupon_id' => $data['coupon_id'],
                    'tag_user_id' => (isset($data['tag_user_id'])) ? $data['tag_user_id'] : ''
                        ]
        );
        // send notification
        if (isset($data['tag_user_id']) && !empty($data['tag_user_id'])) {
            $ids_arr = explode(',', $data['tag_user_id']);
            self::sendTagDealCommentNotification($ids_arr, $data['coupon_id'], $addComment);
        }
        if (array_key_exists('parent_id', $data) && !empty($data['parent_id'])) {
            $addComment->parent_id = $data['parent_id'];
            $commentid = $data['parent_id'];
        } else {
            $addComment->parent_id = $addComment->id;
            $commentid = $addComment->id;
        }
        if ($addComment->save()) {

            return self::getDealListById($addComment->coupon_id, $commentid);
        }
    }

    public static function editComment($data) {
        $editComment = DealComments::find($data['comment_id']);
        $editComment->comment_desc = $data['comment'];
        $editComment->tag_user_id = (isset($data['tag_user_id'])) ? $data['tag_user_id'] : '';

        if (isset($data['tag_user_id']) && !empty($data['tag_user_id'])) {
            $ids_arr = explode(',', $data['tag_user_id']);
            self::sendTagDealCommentNotification($ids_arr, $editComment->coupon_id, $editComment);
        }
        if ($editComment->save()) {
            $commentid = ($editComment->parent_id == $editComment->id) ? $editComment->id : $editComment->parent_id;

            return self::getDealListById($editComment->coupon_id, $commentid);
        }
    }

    public static function getComments($id) {
        $comments = DealComments::select(\DB::raw('count(id) as total_comments'))
                ->where('coupon_id', $id)
//                ->groupBy('parent_id')
                ->first();
        if ($comments) {
            return $comments->getAttributes();
        } else {
            return 0;
        }
    }

    public static function getCommentsByCoupon($id, $offset, $limit) {
        $comments = DealComments::select(\DB::raw('deal_comments.*,deal_comment_likes.liked_by,min(deal_comments.id) as id,deal_comment_likes.is_like'))
                ->leftjoin('deal_comment_likes', 'deal_comment_likes.comment_id', 'deal_comments.id')
                ->where('coupon_id', $id)
                ->orderBy('deal_comments.updated_at', 'asc')
                ->groupBy('parent_id')
                ->skip($offset)
                ->take($limit)
                ->get();

        return $comments;
    }

    public static function getCommentsByParentId($id, $comment_id) {
        $comments = DealComments::select(\DB::raw('deal_comments.id,deal_comments.tag_user_id,deal_comments.comment_by,'
                                        . 'deal_comments.updated_at,deal_comments.coupon_id,deal_comments.comment_desc,'
                                        . 'deal_comments.parent_id,dc.liked_by,dc.is_like as is_like,'
                                        . 'user_detail.first_name ,user_detail.last_name,user_detail.profile_pic,user_detail.user_id'))
                        ->leftjoin('user_detail', 'user_detail.user_id', 'deal_comments.comment_by')
                        ->leftJoin('deal_comment_likes AS dc', function($join) {
                            $join->on('dc.comment_id', '=', 'deal_comments.id');
                            $join->where('dc.liked_by', '=', Auth::id());
                        })
                        ->where('deal_comments.parent_id', $id)
                        ->where('deal_comments.id', '!=', $comment_id)
                        ->orderBy('deal_comments.updated_at', 'asc')
                        ->get()->toArray();
        return $comments;
    }

    public static function sendTagDealCommentNotification($ids_arr, $coupon_id, $addComment) {
        $userfromnotify = User::find(Auth::id());
        $usertonotifiy = User::whereIn('id', $ids_arr)->get();

        $message = \Config::get('constants.NOTIFY_TAG_MESSAGE');
        Notification::send($usertonotifiy, new FcmNotification([
            'type' => 'tagnotification',
            'notification_message' => $message,
            'message' => $addComment->finalTagMessage($userfromnotify, '', $coupon_id, $message),
            'image' => $addComment->showImage($userfromnotify->userdetail->profile_pic, 'profile_pic'),
            'coupon_id' => $coupon_id,
            'comment_id' => $addComment->id,
            
        ]));
    }

    public static function sendTagActivityCommentNotification($ids_arr, $activity) {
        $userfromnotify = User::find(Auth::id());
        $usertonotifiy = User::whereIn('id', $ids_arr)->get();

        $message = \Config::get('constants.NOTIFY_TAG_MESSAGE');
        Notification::send($usertonotifiy, new FcmNotification([
            'type' => 'tagnotification',
            'notification_message' => $message,
            'message' => $activity->finalTagMessage($userfromnotify, '', '', $message),
            'image' => $activity->showImage($userfromnotify->userdetail->profile_pic, 'profile_pic'),
            'comment_id' => $activity->comment_id,
            'activity_id' => $activity->activity_id
        ]));
    }

    public static function getCommentsByCouponById($id) {
        $comments = DealComments::select(\DB::raw('deal_comments.*,deal_comment_likes.liked_by,min(deal_comments.id) as id,deal_comment_likes.is_like'))
                ->leftjoin('deal_comment_likes', 'deal_comment_likes.comment_id', 'deal_comments.id')
                ->where('coupon_id', $id)
                ->orderBy('deal_comments.updated_at', 'desc')
                ->groupBy('parent_id')
                ->skip($offset)
                ->take($limit)
                ->get();

        return $comments;
    }

    public static function getCommentsById($id) {
        $comments = DealComments::select(\DB::raw('deal_comments.*,deal_comment_likes.liked_by,min(deal_comments.id) as id,deal_comments.updated_at,deal_comment_likes.is_like'))
                ->leftjoin('deal_comment_likes', 'deal_comment_likes.comment_id', 'deal_comments.id')
                ->where('deal_comments.id', $id)
                ->orderBy('deal_comments.updated_at', 'asc')
                ->first();

        return $comments;
    }

    public static function getDealListById($coupon_id, $id) {

        //find comments
        $coupondetail = \App\Coupon::getCouponDetailById($coupon_id);

        if (count($coupondetail) > 0) {

            $data['coupon_details'] = (new CouponTransformer)->transformDetail($coupondetail);
            $getComments = DealComments::getCommentsById($id);

            $data['comments_list'] = [];

            $dt = new Carbon($getComments->updated_at);
            $getUser = \App\UserDetail::where('user_id', $getComments->comment_by)->first();

            $comment_details['comment_id'] = $getComments->id;
            $comment_details['user_id'] = $getUser->user_id;
            $comment_details['comment_by'] = $getUser->first_name . ' ' . $getUser->last_name;
            $comment_details['profile_pic'] = ($getUser->profile_pic ? asset('storage/app/public/profile_pic/' . $getUser->profile_pic) : asset('storage/app/public/profile_pic/'));
            if ($getComments->liked_by === auth()->id() && $getComments->is_like === 1) {
                $comment_details['is_liked'] = 1;
            } else {
                $comment_details['is_liked'] = 0;
            }

            $tagfriendarray = explode(",", $getComments->tag_user_id);
            $tags = [];
            if (!empty($getComments->tag_user_id)) {
                foreach ($tagfriendarray as $key => $val) {

                    $detail = \App\UserDetail::where('user_id', $val)->first();

                    $tags[$key]['user_id'] = (int) $val;
                    $tags[$key]['full_name'] = '@' . $detail->first_name . " " . $detail->last_name;
                    $tags[$key]['profile_pic'] = (!empty($detail->profile_pic)) ? URL::to('/storage/app/public/profile_pic') . '/' . $detail->profile_pic : "";
                }
            }
            $comment_details['comment'] = $getComments->comment_desc;
            $comment_details['parent_id'] = $getComments->parent_id;
            $comment_details['tag_user_id'] = $tags;
            $comment_details['comment_time'] = $dt->diffForHumans();
            $getReplyComments = DealComments::getCommentsByParentId($getComments->parent_id, $getComments->id);
//                     print_r($getReplyComments); 

            foreach ($getReplyComments as $keyreply => $valreply) {
                $tagreplyfriendarray = explode(",", $valreply['tag_user_id']);

                $tagsreply = [];
                foreach ($tagreplyfriendarray as $key1 => $val1) {
                    if (!empty($val1)) {
                        $detailreply = \App\UserDetail::where('user_id', $val1)->first();

                        $tagsreply[$key1]['user_id'] = (int) $val1;
                        $tagsreply[$key1]['full_name'] = '@' . $detailreply->first_name . " " . $detailreply->last_name;
                        $tagsreply[$key1]['profile_pic'] = (!empty($detailreply->profile_pic)) ? URL::to('/storage/app/public/profile_pic') . '/' . $detailreply->profile_pic : "";
                    }
                }

                $dt2 = new Carbon($valreply['updated_at']);
                $getReplyComments[$keyreply]['comment_by'] = $valreply['first_name'] . ' ' . $valreply['last_name'];
                $getReplyComments[$keyreply]['profile_pic'] = ($valreply['profile_pic'] ? asset('storage/app/public/profile_pic/' . $valreply['profile_pic']) : asset('storage/app/public/profile_pic/'));

                $getReplyComments[$keyreply]['comment_time'] = $dt2->diffForHumans();
                $getReplyComments[$keyreply]['comment'] = $valreply['comment_desc'];
                $getReplyComments[$keyreply]['tag_user_id'] = $tagsreply;

                $getReplyComments[$keyreply]['comment_id'] = $valreply['id'];
                if ($valreply['is_like'] === 1) {
                    $getReplyComments[$keyreply]['is_liked'] = 1;
                } else {
                    $getReplyComments[$keyreply]['is_liked'] = 0;
                }
                unset($getReplyComments[$keyreply]['comment_desc']);
                unset($getReplyComments[$keyreply]['id']);
                unset($getReplyComments[$keyreply]['coupon_id']);
                unset($getReplyComments[$keyreply]['updated_at']);
                unset($getReplyComments[$keyreply]['liked_by']);
                unset($getReplyComments[$keyreply]['is_like']);
                unset($getReplyComments[$keyreply]['first_name']);
                unset($getReplyComments[$keyreply]['last_name']);
            }

            $comment_details['replycomments'] = $getReplyComments;
            array_push($data['comments_list'], $comment_details);

            return $data;
        }
    }

    public static function deleteDealComment($id) {
        DealComments::where('id', $id)->delete();
        return $id;
    }

}
