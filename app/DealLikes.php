<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealLikes extends Model {

    //
    public $table = 'deal_likes';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'id';
    protected $fillable = [
        'id', 'like_by', 'is_like', 'coupon_id', 'created_at', 'updated_at'
    ];

    public static function addLike($data) {
        $addlike = DealLikes::updateOrCreate(
                        [
                    'like_by' => $data['user_id'],
                    'coupon_id' => $data['coupon_id']
                        ], [
                    'is_like' => (int) $data['is_like'],
                    'like_by' => $data['user_id'],
                    'coupon_id' => $data['coupon_id']
                        ]
        );
        return $addlike;
    }

    public static function getLikes($id) {
        $likes = DealLikes::select(\DB::raw('count(id) as total_likes'))
                ->where('coupon_id', $id)
                ->where('is_like', self::IS_TRUE)
                ->first();
        if ($likes) {
            return $likes->getAttributes();
        } else {
            return 0;
        }
    }

    public static function getUserLike($id, $user_id) {
        $likes = DealLikes::select(\DB::raw('*'))
                ->where('coupon_id', $id)
                ->where('like_by', $user_id)
                ->where('is_like', self::IS_TRUE)
                ->first();
        if (count($likes) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}
