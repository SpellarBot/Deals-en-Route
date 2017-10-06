<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;

class VendorDetail extends Model
{
    protected $table='vendor_detail';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false; 
    public $primaryKey = 'vendor_id';
    
      protected $fillable = [
        'user_id','vendor_name', 'vendor_address',
          'vendor_description','vendor_logo'
    ];
      
    public function getVendorLogoAttribute($value) {
        
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/vendor_logo/' . $value))) ? URL::to('/storage/app/public/vendor_logo') . '/' . $value : "";
    }
  
}
