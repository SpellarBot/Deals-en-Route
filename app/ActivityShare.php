<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Notifications\FcmNotification;
use Illuminate\Notifications\Notifiable;
 use App\Http\Services\ActivityTrait;
 use Notification;

class ActivityShare extends Model {

 use ActivityTrait;

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

       $activity= Activity::where('activity_id', $data['activity_id'])->first();
       $activity->total_like= $addlike->getActivityLikeCount($data['activity_id']);
       $activity->save();      
        if($activity->save() && $data['is_like']==1 && $activity->created_by!=Auth::id()){
            self::sendActivityNotification($activity,'activitylike',\Config::get('constants.ACTIVITY_LIKE'));
         }
    }
    
    public static function sendActivityNotification($activity,$type,$message,$comment=''){
            
             $creatoruser=User::find($activity->created_by);
             $fMessage = $activity->finalActivityMessage(Auth::id(),$message,$activity->coupon->coupon_name);
          
            // send notification success for activity like 
            Notification::send($creatoruser, new FcmNotification([
                'type' => $type,
                'notification_message' => $message,
                'message' => $fMessage,
                'activity_id' => $activity->activity_id,
                'coupon_id' => $activity->coupon_id,
                'comment_id'=>$comment->comment_id??''
            ]));
    }

}
