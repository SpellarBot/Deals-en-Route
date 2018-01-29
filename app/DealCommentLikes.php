<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealCommentLikes extends Model {

    public $table = 'deal_comment_likes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'comment_id';
    protected $fillable = [
        'id', 'comment_id', 'created_at', 'updated_at', 'is_like', 'liked_by'
    ];

    public static function addCommentLike($data) {
        $addlike = DealCommentLikes::updateOrCreate(
                        [
                    'liked_by' => auth()->id(),
                    'comment_id' => $data['comment_id']
                        ], [
                    'is_like' => (int) $data['is_like'],
                    'liked_by' => auth()->id(),
                    'comment_id' => $data['comment_id']
                        ]
        );
        return $addlike;
    }

}
