<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;
class CouponCategory extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    public $table = 'coupon_category';
    const CREATED_AT = 'createddate';
    const UPDATED_AT = 'updateddate';
    public $primaryKey = 'category_id';
    const IS_TRUE=1;
    const IS_FALSE=0;
    
     protected $fillable = [
        'category_id','category_name', 'category_image', 'is_active','is_delete','created_at',
       'updated_at'
    ];
    
     public function scopeActive($query) {
        return $query->where('is_active', 1);
    }
    
     public function scopeDeleted($query) {
        return $query->where('is_delete', 0);
    }
    
    public static function categoryList(){      
    $category= CouponCategory::active()->deleted()->get();

      return $category;
    }
    
    public function getCategoryImageAttribute($value) {
      return (!empty($value)) ? URL::to('/storage/app/public/category_image') . '/' . $value : "";
    }
}
