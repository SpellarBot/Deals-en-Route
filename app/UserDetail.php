<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\ImageTrait;
use App\Notifications\FcmNotification;
use Illuminate\Notifications\Notifiable;
use Notification;
use Carbon\Carbon;
use Auth;
class UserDetail extends Model {

    use ImageTrait;
    use Notifiable;

    protected $fillable = [
        'user_detail_id', 'first_name', 'last_name', 'dob', 'phone', 'profile_pic',
        'latitude', 'longitude', 'fb_token', 'google_token', 'twitter_token', 'user_id',
        'category_id', 'type', 'notification_fav_expire', 'notification_new_offer',
        'notification_recieve_offer', 'gender'
    ];
    protected $table = 'user_detail';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false;

    const IS_NOT_CONFIRMED = 0;
    const IS_CONFIRMED = 1;

    protected $dates = [
        'dob',
    ];
    public $primaryKey = 'user_detail_id';

    public function setDobAttribute($value) {

        $this->attributes['dob'] = Carbon::parse($value)->format('Y-m-d');
    }

    public static function formatDob($value) {
        return Carbon::parse($value)->format('m/d/Y');
    }
    public static function saveUserDetaillatlong($data, $user_id) {

        
        
        $user_detail = UserDetail::firstOrNew(["user_id" => $user_id]);
        $user_detail->latitude = $data['latitude'];
        $user_detail->longitude = $data['longitude'];
        $user_detail->save();
        return $user_detail;
    }

    
    public static function saveUserDetail($data, $user_id) {

        if (isset($data['profile_pic'])) {
            unset($data['profile_pic']);
        }
        
        if (isset($data['token']) && $data['type'] == 1) {
            $data['fb_token'] = ($data['token']);
        }if (isset($data['token']) && $data['type'] == 2) {
            $data['twitter_token'] = ($data['token']);
        }if (isset($data['token']) && $data['type'] == 3) {
            $data['google_token'] = ($data['token']);
        }

        $user_detail = UserDetail::firstOrNew(["user_id" => $user_id]);
        $user_detail->user_id = $user_id;

        $user_detail->fill($data);
        $user_detail->save();
        return $user_detail;
    }

    //create user for web
    public static function createUser($data = [], $id = '') {

        $user = User::create([
                    'role' => 'user',
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'is_confirmed' => self::IS_CONFIRMED,
                        // 'confirmation_code' => $this->generateRandomString()
        ]);
        $data['category_id'] = implode(',', $data['category_id']);
        $user_detail = self::saveUserDetail($data, $user->id);
        return $user_detail;
    }

    // update user for web
    public static function updateUser($data = [], $id = '') {

        $user = User::find($id);
        $user->fill($data);
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
        $data['category_id'] = implode(',', $data['category_id']);
        $user_detail = self::saveUserDetail($data, $user->id);
        return $user_detail;
    }

}
