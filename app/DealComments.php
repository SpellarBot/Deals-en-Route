<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealComments extends Model {

    //
    public $table = 'deal_comments';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'id';
    protected $fillable = [
        'id', 'comment_by', 'comment_desc', 'coupon_id', 'created_at', 'updated_at'
    ];

    public static function addComment($data) {
        $addComment = DealComments::create(['comment_desc' => $data['comment'],
                    'comment_by' => $data['user_id'],
                    'coupon_id' => $data['coupon_id']
                        ]
        );
        return $addComment;
    }

    public static function editComment($data) {
        $editComment = DealComments::find($data['comment_id']);
        $editComment->comment_desc = $data['comment'];
        $editComment->save();
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

}
