<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Coupon extends Model
{
    
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    public $table = 'coupon';
    const CREATED_AT = 'createddate';
    const UPDATED_AT = 'updateddate';
    public $primaryKey = 'coupon_id';
    const IS_TRUE=1;
    const IS_FALSE=0;
    
     protected $fillable = [
        'coupon_id','coupon_category_id', 'coupon_name', 'coupon_detail','coupon_logo',
       'coupon_start_date','coupon_end_date','coupon_redemption_code',
         'coupon_qrcode','coupon_code','coupon_lat','coupon_long','coupon_radius',
         'coupon_total_redeem','coupon_redeem_limit','is_active','is_delete',
         'created_at','updated_at','created_by'
    ];
    
    
     public static function getNearestCoupon(){
     $user=Auth()->user()->userDetail;    
     $max_distance = 15;
     $circle_radius = 3959;
     $lat=$user->latitude;
     $lng=$user->longitude;
//     $results =DB::raw(
//               'SELECT coupon_id,  (' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(coupon_lat)) *
//                    cos(radians(coupon_long) - radians(' . $lng . ')) +
//                    sin(radians(' . $lat . ')) * sin(radians(coupon_lat))))
//                    AS distance
//                    FROM coupon
//                WHERE distance < ' . $max_distance . '
//                ORDER BY distance
//                OFFSET 0
//                LIMIT 20;
//            ');
     
     $results = DB::table('coupon')
                 ->select(DB::raw('coupon_id,coupon_radius, ('. $circle_radius.' * acos(cos(radians(' . $lat . ')) * cos(radians(coupon_lat)) *
                    cos(radians(coupon_long) - radians(' . $lng . ')) +
                    sin(radians(' . $lat . ')) * sin(radians(coupon_lat)))) as distance'))
                  
                  ->orderBy('distance')
                  ->get();
print_r($results); exit;
     return $results;


     }
    
}
//'SELECT coupon_id, ( 3959 * acos( cos( radians(37) ) * cos( radians( coupon_lat ) ) * cos( radians( coupon_long ) - radians(-122) ) + sin( radians(37) ) * sin( radians( coupon_lat ) ) ) ) AS distance FROM coupon HAVING distance < 25 ORDER BY distance LIMIT 0 , 20 '