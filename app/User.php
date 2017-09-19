<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Http\Services\UserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use League\Fractal\TransformerAbstract;
class User extends Authenticatable
{
    use Notifiable;
    use UserTrait;
    const IS_NOT_CONFIRMED=0;
    const IS_CONFIRMED=1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','is_confirmed','confirmation_code',
        'timezone','api_token'
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
    public function userDetail()
    {
        return $this->hasOne('App\UserDetail');
    }
    
     protected function creatUser($data) {
     
             $user=User::create([
            'role'=>'user',
            'email' => $data['email'],
            'timezone' => $data['timezone'],
            'password' => bcrypt($data['password']),
            'is_confirmed'=>self::IS_NOT_CONFIRMED,
            'confirmation_code' => $this->generateRandomString()
        ]);
       return $user;
     }
     
   

}
