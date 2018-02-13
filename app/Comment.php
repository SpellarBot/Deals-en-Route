<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

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

    public static function getCommentsByActivity($id, $offset, $limit) {
        $comments = Comment::select(\DB::raw('comment.*,activity_comment_likes.liked_by,activity_comment_likes.is_like'))
                ->leftjoin('activity_comment_likes', 'activity_comment_likes.comment_id', 'comment.comment_id')
                ->where('comment.activity_id', $id)
                ->orderBy('comment.updated_at', 'asc')
                ->groupBy('parent_id')
                ->skip($offset)
                ->take($limit)
                ->get();
   
        return $comments;
    }

    public static function getCommentsByParentId($id, $comment_id) {
        $comments = Comment::select(\DB::raw('comment.*,activity_comment_likes.liked_by,activity_comment_likes.is_like,user_detail.first_name ,user_detail.last_name,user_detail.profile_pic,user_detail.user_id'))
                ->leftjoin('activity_comment_likes', 'activity_comment_likes.comment_id', 'comment.comment_id')
                ->leftjoin('user_detail', 'user_detail.user_id', 'comment.created_by')
                ->where('comment.parent_id', $id)
                ->where('comment.comment_id', '!=', $comment_id)
                ->orderBy('comment.updated_at', 'asc')
                ->get();
        return $comments;
    }

}
