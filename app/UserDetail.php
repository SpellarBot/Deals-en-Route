<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\ImageTrait;

class UserDetail extends Model
{
   use ImageTrait;
   protected $fillable = [
        'user_detail_id','first_name', 'last_name', 'dob','phone','profile_pic',
       'latitude','longitude','fb_token','google_token','twitter_token','user_id',
       'category_id','type'
    ];
   
    protected $table='user_detail';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false;
    protected $dates = [
        'dob', 
    ];
    public $primaryKey = 'user_detail_id';
    
    
      
    
    public static function saveUserDetail($data,$user_id){
        if(isset($data['profile_pic'])){
        unset($data['profile_pic']);
        }
        if(isset($data['password'])){
          $data['password']= bcrypt($data['password']);
        }
       
        $user_detail = UserDetail::firstOrNew(["user_id" => $user_id]);
        $user_detail->user_id = $user_id;
        $user_detail->fill($data);
        $user_detail->save();
        return $user_detail;
    }
    
    
    
  
}
