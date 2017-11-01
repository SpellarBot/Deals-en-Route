<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;

class VendorDetail extends Model
{
   use \App\Http\Services\UserTrait;
    protected $table='vendor_detail';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false; 
    public $primaryKey = 'vendor_id';
    
      protected $fillable = [
        'user_id','vendor_name', 'vendor_address','vendor_city','vendor_zip','vendor_logo','vendor_category','vendor_phone',
          'vendor_state','billing_home','billing_city','billing_country'
    ];
      
    public function getVendorLogoAttribute($value) {
        
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/vendor_logo/' . $value))) ? URL::to('/storage/app/public/vendor_logo') . '/' . $value : "";
    }
    
    
    public static function saveVendorDetail($data,$user_id){
      
        $vendor_detail = VendorDetail::firstOrNew(["user_id" => $user_id]);
        $vendor_detail->user_id = $user_id;     
        $vendor_detail->fill($data);
        $vendor_detail->save();
        return $vendor_detail;
    }
  
    //create vendor for admin
    public static function createVendor($data=[]){
        
        $user = User::create([
                    'role' => 'vendor',
                    'email' => $data['email'],     
                    'password' => bcrypt($data['password']),
                    'is_confirmed' => User::IS_CONFIRMED,
        ]);   
        $user_id=$user->id;
        return self::saveVendorDetail($data, $user_id);
    }
    
    //update vendor
     public static function updateVendor($data=[],$id){
         //update user
        $user = User::find($id);        
        $user->fill($data);
      
        $user->save();
        $data['vendor_category']=implode(',',$data['vendor_category']);
        return self::saveVendorDetail($data, $id);
    }
    
    //create vendor for front
    public static function createVendorFront($data=[]){
  
        $user = User::create([
                    'role' => 'vendor',
                    'email' => $data['email'],     
                    'password' => bcrypt($data['password']),
                    'is_confirmed' => User::IS_NOT_CONFIRMED,
             
        ]);   
        $user->confirmation_code = $user->generateRandomString(); 
        $user->save();
        $user_id=$user->id;  
        return self::saveVendorDetail($data, $user_id);
    }
}
