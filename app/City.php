<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false;

    const IS_NOT_CONFIRMED = 0;
    const IS_CONFIRMED = 1;
    
   
    public static function cityListRequest(){
        
        return City::select('id','name')->Where("is_active",self::IS_NOT_CONFIRMED)
         ->get();
        
    }
    
    public static function searchCity($data){
        
         $keyword=$data['name'];
         $citysearch= City::Where("name", "LIKE", "$keyword")->Where("is_active",self::IS_CONFIRMED)
         ->get();
         $count=count($citysearch);
         if($count>0){
             return true;
         }
         return false;

    }
    
    
}
