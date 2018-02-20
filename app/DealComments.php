<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Notification;
use App\Notifications\FcmNotification;

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

    public static function addComment($data) {
        $addComment = DealComments::create(['comment_desc' => $data['comment'],
                    'comment_by' => Auth::id(),
                    'coupon_id' => $data['coupon_id'],
                    'tag_user_id' => (isset($data['tag_user_id'])) ? $data['tag_user_id'] : ''
                        ]
        );
       // send notification
        if(isset($data['tag_user_id']) && !empty($data['tag_user_id'])){
            $ids_arr = explode(',', $data['tag_user_id']);
            self::sendTagDealCommentNotification($ids_arr,$data['coupon_id'],$addComment);
        }
        if (array_key_exists('parent_id', $data) && !empty($data['parent_id'])) {
            $addComment->parent_id = $data['parent_id'];
        } else {
            $addComment->parent_id = $addComment->id;
        }
        $addComment->save();
        return $addComment;
    }

    public static function editComment($data) {
        $editComment = DealComments::find($data['comment_id']);
        $editComment->comment_desc = $data['comment'];
        $editComment->tag_user_id = (isset($data['tag_user_id']) && !empty($data['tag_user_id'])) ? $data['tag_user_id'] : '';
        $editComment->save();
        if(isset($data['tag_user_id']) && !empty($data['tag_user_id'])){
            $ids_arr = explode(',', $data['tag_user_id']);
            self::sendTagDealCommentNotification($ids_arr,$editComment->coupon_id,$editComment);
        }
        return $editComment;
    }

    public static function getComments($id) {
        $comments = DealComments::select(\DB::raw('count(id) as total_comments'))
                ->where('coupon_id', $id)
                ->groupBy('parent_id')
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
                ->orderBy('deal_comments.updated_at', 'desc')
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
                     ->leftJoin('deal_comment_likes AS dc', function($join){
            $join->on('dc.comment_id', '=', 'deal_comments.id');
            $join->where('dc.liked_by', '=',Auth::id());
        })
                        ->where('deal_comments.parent_id', $id)
                        ->where('deal_comments.id', '!=', $comment_id)
                        ->orderBy('deal_comments.updated_at', 'desc')
                        ->get()->toArray();
        return $comments;
    }
    
    public static function sendTagDealCommentNotification($ids_arr,$coupon_id,$addComment){
           $userfromnotify=User::find(Auth::id());
            $usertonotifiy=User::whereIn('id',$ids_arr)->get();

            $message=\Config::get('constants.NOTIFY_TAG_MESSAGE');
                Notification::send($usertonotifiy, new FcmNotification([
                    'type' => 'tagnotification',
                    'notification_message' => $message,
                    'message' => $addComment->finalTagMessage($userfromnotify,'',$coupon_id,$message),
                    'image' =>$addComment->showImage($userfromnotify->userdetail->profile_pic, 'profile_pic'),
                    'coupon_id' =>$coupon_id,
                    'comment_id' =>$addComment->id,   
                ]));
    }
    
    public static function sendTagActivityCommentNotification($ids_arr,$activity){
            $userfromnotify=User::find(Auth::id());
            $usertonotifiy=User::whereIn('id',$ids_arr)->get();

            $message=\Config::get('constants.NOTIFY_TAG_MESSAGE');
                Notification::send($usertonotifiy, new FcmNotification([
                    'type' => 'tagnotification',
                    'notification_message' => $message,
                    'message' => $activity->finalTagMessage($userfromnotify,'','',$message),
                    'image' =>$activity->showImage($userfromnotify->userdetail->profile_pic, 'profile_pic'),
                    'comment_id' =>$activity->comment_id,   
                    'activity_id'=>$activity->activity_id
                ]));
    }
    
    public static function deleteDealComment($id){
       DealComments::where('id', $id)->delete();
       return $id;
    }

}
