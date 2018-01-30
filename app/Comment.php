<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    public $table = 'comment';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'comment_id';
    protected $fillable = [
        'comment_id', 'created_at', 'updated_at', 'comment_desc', 'activity_id'
    ];

    public function user() {
        return $this->hasOne('App\UserDetail', 'user_id', 'created_by');
    }

    public static function getCommentsByActivity($id) {
        $comments = Comment::select(\DB::raw('comment.*,activity_comment_likes.liked_by,activity_comment_likes.is_like'))
                ->leftjoin('activity_comment_likes', 'activity_comment_likes.comment_id', 'comment.comment_id')
                ->where('comment.activity_id', $id)
                ->orderBy('comment.updated_at', 'asc')
                ->get();
        return $comments;
    }

}
