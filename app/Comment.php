<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use App\Http\Transformer\ActivityTransformer;
use Carbon\Carbon;
use URL;
class Comment extends Model {
     use \App\Http\Services\NotificationTrait;
     use \App\Http\Services\ImageTrait;

    public $table = 'comment';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'comment_id';
    protected $fillable = [
        'comment_id', 'created_at', 'updated_at', 'comment_desc', 'activity_id','tag_user_id'
    ];

    public function user() {
        return $this->hasOne('App\UserDetail', 'user_id', 'created_by');
    }
    public function activitylike() {
        return $this->hasMany('App\ActivityCommentLike', 'comment_id', 'comment_id')->where('liked_by', Auth::id());
    }


    public static function getCommentsByActivity($id, $offset, $limit) {
        $comments = Comment::select(\DB::raw('comment.*,min(comment.comment_id) as comment_id,activity_comment_likes.liked_by,activity_comment_likes.is_like'))
                ->leftjoin('activity_comment_likes', 'activity_comment_likes.comment_id', 'comment.comment_id')
                ->where('comment.activity_id', $id)
                ->orderBy('comment.updated_at', 'desc')
                ->groupBy('parent_id')
                ->skip($offset)
                ->take($limit)
                ->get();
   
        return $comments;
    }
    
      public static function getCommentsByCommentId($id) {
        $comments = Comment::select(\DB::raw('comment.*,min(comment.comment_id) as comment_id,activity_comment_likes.liked_by,activity_comment_likes.is_like'))
                ->leftjoin('activity_comment_likes', 'activity_comment_likes.comment_id', 'comment.comment_id')
                ->where('comment.comment_id', $id)
                ->orderBy('comment.updated_at', 'desc')
                ->first();
   
        return $comments;
    }

    public static function getCommentsByParentId($id, $comment_id) {
        $comments = Comment::select(\DB::raw('comment.*,c.is_like,'
                . 'user_detail.first_name ,user_detail.last_name,'
                . 'user_detail.profile_pic,user_detail.user_id'))
                ->leftjoin('user_detail', 'user_detail.user_id', 'comment.created_by')
                ->leftJoin('activity_comment_likes AS c', function($join){
            $join->on('comment.comment_id', '=', 'c.comment_id');
            $join->where('c.liked_by', '=',Auth::id());
        })
                ->where('comment.parent_id', $id)
                ->where('comment.comment_id', '!=', $comment_id)
              
                ->orderBy('comment.updated_at', 'desc')
                ->get();
        return $comments;
    }
    
    public static function deleteActivityComment($id) {
        Comment::where('comment_id',$id)->delete();
        return $id;
    }
    
    
    public function getActivityComment($activityid,$commentid){
 
         $activity = \App\Activity::getActivityDetailsById($activityid);
       
            if (count($activity) > 0) {
                
                $data['activity_details'] = (new ActivityTransformer)->transformActivityDetails($activity);
                $getComments = self::getCommentsByCommentId($commentid);
           
                $data['comments_list'] = [];

                    $dt = new Carbon($getComments->updated_at);
                    $getUser = \App\UserDetail::where('user_id',$getComments->created_by)->first();
                    $comment_details['user_id'] = $getUser->user_id;
                    $comment_details['comment_by'] = $getUser->first_name . ' ' . $getUser->last_name;
                    $comment_details['profile_pic'] = ($getUser->profile_pic ? asset('storage/app/public/profile_pic/' . $getUser->profile_pic) : asset('storage/app/public/profile_pic/'));
                    if ($getComments->liked_by === auth()->id() && $getComments->is_like === 1) {
                        $comment_details['is_liked'] = 1;
                    } else {
                        $comment_details['is_liked'] = 0;
                    }
                    
                         $tagfriendarray=explode(",",$getComments->tag_user_id);
                    $tags=[];
                     if(!empty($getComments->tag_user_id)){
                    foreach($tagfriendarray as $key1=>$val1){
                        
                        $detail=\App\UserDetail::where('user_id',$val1)->first();
                        if($detail){
                        $tags[$key1]['user_id']= (int)$val1;
                        $tags[$key1]['full_name']= '@'.$detail->first_name." ".$detail->last_name;
                        $tags[$key1]['profile_pic']= (!empty($detail->profile_pic)) ? URL::to('/storage/app/public/profile_pic') . '/' . $detail->profile_pic : "";
                        }
                    }
                    }
                    $comment_details['comment'] = $getComments->comment_desc;
                    $comment_details['comment_id'] = $getComments->comment_id;
                    $comment_details['parent_id'] = $getComments->parent_id;
                     $comment_details['tag_user_id'] = $tags;
                    $comment_details['comment_time'] = $dt->diffForHumans();
                    
                    $getReplyComments = \App\Comment::getCommentsByParentId($getComments->parent_id, $getComments->comment_id);
                    foreach ($getReplyComments as $key => $val) {
                           $tagreplyfriendarray=explode(",",$val['tag_user_id']);
                       $tagsreply=[];
                      foreach($tagreplyfriendarray as $key2=>$val2){
                        if(!empty($val2)){
                        $detailreply=\App\UserDetail::where('user_id',$val2)->first();
                         if($detailreply){
                        $tagsreply[$key2]['user_id']= (int)$val2;
                        $tagsreply[$key2]['full_name']= '@'.$detailreply->first_name." ".$detailreply->last_name;
                        $tagsreply[$key2]['profile_pic']= (!empty($detailreply->profile_pic)) ? URL::to('/storage/app/public/profile_pic') . '/' . $detailreply->profile_pic : "";
                         }
                        
                         }
                    }
                        $dt2 = new Carbon($val['updated_at']);
                        $getReplyComments[$key]['comment_by'] = $val['first_name'] . ' ' . $val['last_name'];
                        $getReplyComments[$key]['profile_pic'] = ($val['profile_pic'] ? asset('storage/app/public/profile_pic/' . $val['profile_pic']) : asset('storage/app/public/profile_pic/'));
                        $getReplyComments[$key]['comment_time'] = $dt2->diffForHumans();
                        $getReplyComments[$key]['comment'] = $val['comment_desc'];
                        $getReplyComments[$key]['comment_id'] = $val['comment_id'];
                        $getReplyComments[$key]['tag_user_id'] = $tagsreply;
                        if ($val['is_like'] === 1) {
                            $getReplyComments[$key]['is_liked'] = 1;
                        } else {
                            $getReplyComments[$key]['is_liked'] = 0;
                        }
                        unset($getReplyComments[$key]['comment_desc']);
                        unset($getReplyComments[$key]['id']);
                        unset($getReplyComments[$key]['activity_id']);
                        unset($getReplyComments[$key]['created_by']);
                        unset($getReplyComments[$key]['updated_at']);
                        unset($getReplyComments[$key]['created_at']);
                        unset($getReplyComments[$key]['liked_by']);
                        unset($getReplyComments[$key]['is_like']);
                        unset($getReplyComments[$key]['first_name']);
                        unset($getReplyComments[$key]['last_name']);
                    }
                    $comment_details['replycomments'] = $getReplyComments;
                    array_push($data['comments_list'], $comment_details);
                    return $data;
            } 
    }

}
