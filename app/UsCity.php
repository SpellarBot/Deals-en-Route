<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsCity extends Model
{
    protected $table = 'us_cities';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false;

    const IS_NOT_CONFIRMED = 0;
    const IS_CONFIRMED = 1;
    
    
    
    public static function cityListRequest(){
        
        return UsCity::select('id','name')
         ->get();
        
    }
    
    public static function searchCity($data){
        
         $keyword=$data['name'];
         $citysearch= UsCity::Where("name", "LIKE", "$keyword")->Where("is_active",self::IS_CONFIRMED)
         ->get();
         $count=count($citysearch);
         if($count>0){
             return 'true';
         }
         return false;

    }
    
    
}
