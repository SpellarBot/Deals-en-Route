<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ActivityShare extends Model {

    use Http\Services\ActivityTrait;

    public $table = 'activity_share';
    public $timestamps = false;
    public $primaryKey = 'share_id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    protected $fillable = [
        'share_id', 'activity_id', 'user_id', 'is_like'
    ];

    public static function addLike($data) {

        $addlike = ActivityShare::updateOrCreate([
                    'activity_id' => $data['activity_id'],
                    'user_id' => Auth::id()
                        ], ['is_like' => $data['is_like'],
                    'activity_id' => $data['activity_id'],
                    'user_id' => Auth::id()
                        ]
        );

        self::updateLike($data, $addlike);
        return $addlike;
    }

    //update like count in activity
    public static function updateLike($data, $addlike) {

        Activity::where('activity_id', $data['activity_id'])
                ->update(['total_like' => $addlike->getActivityLikeCount($data['activity_id'])]);
    }

}
