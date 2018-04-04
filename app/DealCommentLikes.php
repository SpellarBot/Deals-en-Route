<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\FcmNotification;
use Illuminate\Notifications\Notifiable;
use App\Http\Services\ActivityTrait;
use Notification;
use Auth;
class DealCommentLikes extends Model {

    public $table = 'deal_comment_likes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'comment_id';
    protected $fillable = [
        'id', 'comment_id', 'created_at', 'updated_at', 'is_like', 'liked_by'
    ];
 public function comment() {
        return $this->hasOne('App\DealComments', 'id', 'comment_id');
    }
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
          if ($addlike &&  $addlike->is_like==1 &&  $addlike->comment->comment_by != Auth::id() ) {
            self::sendLikeNotification($addlike, 'dealcommentlike', \Config::get('constants.COMMENT_LIKE'));
        }
        return $addlike;
    }

     public static function sendLikeNotification($data,$type,$message){
    
         User::find($data->liked_by);
        $creatoruser = $data->comment->comment_by;
        $usercreatorsend=User::find($creatoruser); 
        $fMessage = self::finalActivityMessage(Auth::id(), $message);

        // send notification success for activity like 
        Notification::send($usercreatorsend, new FcmNotification([
            'type' => $type,
            'notification_message' => $message,
            'message' => $fMessage,
            'comment_id' => $data['comment_id'] ?? '',
             'coupon_id'=> $data->comment->coupon_id ??'',   
        ]));
    
    }
    
    public static function finalActivityMessage($from_id,$message) {

        $userfrom = User::find($from_id);

        $fromid = (!empty($userfrom) ? $userfrom->userDetail->first_name . " " . $userfrom->userDetail->last_name : '');
        $find = ['{{from_id}}'];
        $replace = [$fromid];
        $message = str_replace($find, $replace, $message);
        return $message;
    }
}
