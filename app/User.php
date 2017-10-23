<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Http\Services\UserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use League\Fractal\TransformerAbstract;
use Auth;
use App\Http\Services\MailTrait;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable {

    use Notifiable;
    use UserTrait;
    use MailTrait;

    const IS_NOT_CONFIRMED = 0;
    const IS_CONFIRMED = 1;
    const IS_TRUE = 1;
    const IS_FALSE = 0;
  
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
  public function scopeActive($query) {
        return $query->where('is_active', self::IS_TRUE);
    }

    public function scopeDeleted($query) {
        return $query->where('is_delete', self::IS_FALSE);
    }
    /**
     * Get the phone record associated with the user.
     */
    public function userDetail() {
        return $this->hasOne('App\UserDetail');
    }

    public function deviceDetail() {
        return $this->hasOne('App\DeviceDetail','user_id','id');
    }
    
     public function classification()
    {
        return $this->belongsTo('App\UserDetail');
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
       
        $user_detail->fill($data);
        if (!empty($data['password'])) {
            $user_detail->password = bcrypt($data['password']);
        }
        $user_detail->save();
        return $user_detail;
    }

    
    protected function getToken($data){
         $user_detail = \App\UserDetail::where(["fb_token" => $data['token']])
                ->orWhere(["google_token" => $data['token']])
                ->orWhere(["twitter_token" => $data['token']])
                ->first();
         if(!empty($user_detail)){
        return User::find($user_detail->user_id);
         }
          return '';
    }


    protected function saveToken($data) {
        $user = self::getUser($data);
        \App\UserDetail::saveUserDetail($data, $user->id);
        \App\DeviceDetail::saveDeviceToken($data, $user->id);
      //  UserFbFriend::saveFbFriend($data, $user->id);
        return $user;
    }

    protected function getUser($data) {


            $user=User::firstOrNew(["email" => $data['email']]);
            $user->role='user';
 
               if (isset($data['email']) && empty($user->password)) {
          
                if (!empty($data['email'])) {
                    $password = $this->generatePassword();
                    $array_mail = ['to' => $data['email'],
                        'type' => 'password',
                        'data' => ['password' => $password]
                    ];
                    $this->sendMail($array_mail);
                    $user->password = bcrypt($password);
                    $user->is_confirmed = self::IS_CONFIRMED;
                    $user->api_token = $this->generateAuthToken();
                } else if (!empty($user->email) && !empty($user->password) && $user->is_confirmed == self::IS_CONFIRMED) {
                    $user->api_token = $this->generateAuthToken();
                }
            }
            $user->fill($data);
            $user->save();
        
        return $user;
    }

    public static function addEmail($data) {
        
        $user=User::firstOrNew(["email" => $data['email']]);
        $user->fill($data);
        $user->role='user';
        $user->confirmation_code = $user->generateRandomString();
        $user->save();
        if($user->is_confirmed==self::IS_NOT_CONFIRMED){
        $array_mail = ['to' => $data['email'],
            'type' => 'verify',
            'data' => ['confirmation_code' => $user->confirmation_code]
        ];
        $user->sendMail($array_mail);
        }
        \App\UserDetail::saveUserDetail($data, $user->id);
        \App\DeviceDetail::saveDeviceToken($data, $user->id);
       // UserFbFriend::saveFbFriend($data, $user->id);
        $user->save();
        return $user;
       
    }

       public function sendPasswordResetNotification($token)
{
     
    $this->notify(new ResetPasswordNotification($token));
}
}
