<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Http\Services\UserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use League\Fractal\TransformerAbstract;
use Auth;

class User extends Authenticatable {

    use Notifiable;
    use UserTrait;

    const IS_NOT_CONFIRMED = 0;
    const IS_CONFIRMED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_confirmed', 'confirmation_code',
        'timezone', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the phone record associated with the user.
     */
    public function userDetail() {
        return $this->hasOne('App\UserDetail');
    }

    public function deviceDetail() {
        return $this->hasOne('App\DeviceDetail');
    }

    protected function creatUser($data) {

        $user = User::create([
                    'role' => 'user',
                    'email' => $data['email'],
                    'timezone' => $data['timezone'] ?? '',
                    'password' => bcrypt($data['password']),
                    'is_confirmed' => self::IS_NOT_CONFIRMED,
                    'confirmation_code' => $this->generateRandomString()
        ]);
        return $user;
    }

    protected function updateUser($data) {
        $user_id = Auth::id();
        $user_detail = User::find($user_id);
        if (!empty($data['password'])) {
            $user_detail->password = bcrypt($data['password']);
        }
        $user_detail->fill($data);
        $user_detail->save();
        return $user_detail;
    }

    protected function saveToken($data) {

        $user_detail = \App\UserDetail::where(["fb_token" => $data['token']])
                ->orWhere(["google_token" => $data['token']])
                ->orWhere(["twitter_token" => $data['token']])
                ->first();
        $user = self::getUser($user_detail, $data);
        \App\UserDetail::saveUserDetail($data, $user->id);
        \App\DeviceDetail::saveDeviceToken($data, $user->id);
        UserFbFriend::saveFbFriend($data,$user->id);
        return $user;
    }

    protected function getUser($user_detail, $data) {

        if (empty($user_detail)) {
            $user = User::create(['role' => 'user']);
            $user_id = $user->id;
        } else {
            $user_id = $user_detail->user_id;
            $user = User::find($user_id);
            if (!empty($data['email'])) {
                $user->api_token = $this->generateAuthToken();
            }
            $user->fill($data);
            $user->save();
        }
        return $user;
    }
    
    
   

}
