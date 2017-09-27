<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\UserTrait;
use DB;
class UserFbFriend extends Model
{
    
    use UserTrait;
    
     protected $fillable = [
        'user_id','user_friend_id', 'user_token_id'
    ];
   
    protected $table='user_fb_friend';
    public $timestamps = false;
    public $primaryKey = 'friend_id';
    
    
    
    public static function saveFbFriend($data,$userid){

     if(isset($data['fb_friend']) && !empty($data['fb_friend']))  {  
         $fbfriend=$data['fb_friend'];
         $ex=explode(',',$fbfriend);
        $delete=UserFbFriend::where('user_id',$userid)->delete();
        if($delete){
            DB::statement("ALTER TABLE user_fb_friend AUTO_INCREMENT = 1;");
        }
        $datafb = []; 
    

        foreach($ex as $exs){
          $fbfriend=new UserFbFriend();
              $datafb[] = [
             'user_id'=>$userid,
            'user_token_id'=>$exs,
            'user_friend_id'=>$fbfriend->getFbFriendId($exs)
         
          ];
        }
        UserFbFriend::insert($datafb);
         
     }
        
    }
}
