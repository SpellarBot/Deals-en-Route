<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;

class VendorDetail extends Model {

    use \App\Http\Services\UserTrait;

    protected $table = 'vendor_detail';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false;
    public $primaryKey = 'vendor_id';
    protected $fillable = [
        'user_id', 'vendor_name', 'vendor_address', 'vendor_city', 'vendor_zip', 
        'vendor_logo', 'vendor_category', 'vendor_phone', 'vendor_state', 
        'billing_home', 'billing_state', 'billing_zip', 'billing_city',
        'billing_country','vendor_country', 'vendor_state','vendor_lat',
        'vendor_long','billing_businessname','check-address'
    ];

    public function getVendorLogoAttribute($value) {

        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/vendor_logo/' . $value))) ? URL::to('/storage/app/public/vendor_logo') . '/' . $value : "";
    }

    // save vendor detail
    public static function saveVendorDetail($data, $user_id) {
        if(isset($data['check-address'])){
          $checkaddress=$data['check-address'];
          unset($data['check-address']);
        }
        $vendor_detail = VendorDetail::firstOrNew(["user_id" => $user_id]);
        $vendor_detail->user_id = $user_id;
      
        $vendor_detail->fill($data);
        $vendor_detail->save();
       
         if(isset($checkaddress) && $checkaddress=='yes'){
             
            self::saveBusinessAddress($vendor_detail,$data);
        }
        if(empty($data['vendor_lat'])  || empty($data['vendor_long']) ){
        self::saveMapLatLong($vendor_detail);
        }
       
        return $vendor_detail;
    }
  
    //create vendor for admin
    public static function createVendor($data = []) {

        $user = User::create([
                    'role' => 'vendor',
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'is_confirmed' => User::IS_CONFIRMED,
        ]);
        $user_id = $user->id;
        return self::saveVendorDetail($data, $user_id);
    }

    //update vendor
    public static function updateVendor($data = [], $id) {
        //update user
        $user = User::find($id);
        $user->fill($data);

        $user->save();
        $data['vendor_category'] = implode(',', $data['vendor_category']);
        return self::saveVendorDetail($data, $id);
    }

    //create vendor for front
    public static function createVendorFront($data = []) {

        $user = User::create([
                    'role' => 'vendor',
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'is_confirmed' => User::IS_NOT_CONFIRMED,
        ]);
        $user->confirmation_code = $user->generateRandomString();
        $user->save();
        $user_id = $user->id;
        return self::saveVendorDetail($data, $user_id);
    }

    
    // save map lat long 
    public static function saveMapLatLong($model){
        $response = \GoogleMaps::load('geocoding')
		->setParam (['address' =>$model->vendor_address])
 		->get();
       $response1=json_decode($response);
       $model->vendor_lat= $response1->results[0]->geometry->location->lat; 
       $model->vendor_long= $response1->results[0]->geometry->location->lng; 
       $model->save();        
    }
    
    public static function saveBusinessAddress($vendor_detail,$data){
        
     $vendor_detail->billing_businessname = $data['vendor_name'];
     $vendor_detail->billing_home = $data['vendor_address'];
     $vendor_detail->billing_state = $data['vendor_state'];
     $vendor_detail->billing_city = $data['vendor_city'];
     $vendor_detail->billing_zip = $data['vendor_zip'];
     $vendor_detail->billing_country = $data['vendor_country'];
 
    }

}
