<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;
use Auth;

class CouponCategory extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'coupon_category';


    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'category_id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    protected $fillable = [
        'category_id', 'category_name', 'category_image', 'is_active', 'is_delete', 
        'reject_reason', 'request_email', 'is_requested','requested_by','category_logo_image'
    ];

    public function scopeActive($query) {
        return $query->where('is_active', self::IS_TRUE);
    }
    /**
     * Set the catgeory image.
     *
     * @param  string  $value
     * @return void
     */
    public function setCategoryImageAttribute($value) {

      $this->attributes['category_image'] = (isset($value) && !empty($value)) ?  $value :\Config::get('constants.OTHER_CATEGORY_IMAGE');

    }
  
  public function setCategoryLogoImageAttribute($value) {
      
      $this->attributes['category_logo_image'] = (isset($value) && !empty($value)) ?  $value :\Config::get('constants.OTHER_CATEGORY_LOGO_IMAGE');

    }
    public function scopeDeleted($query) {
        return $query->where('is_delete', self::IS_FALSE);
    }

     
   
    public function getCategoryImageAttribute($value) {

        return (!empty($value)) ? URL::to('/storage/app/public/category_image') . '/' . $value : URL::to('/storage/app/public/category_image/'.\Config::get('constants.OTHER_CATEGORY_IMAGE'));
    }

    //category logo image
    public function getCategoryLogoImageAttribute($value) {

        return (!empty($value)) ? URL::to('/storage/app/public/category_logo_image') . '/' . $value : URL::to('/storage/app/public/category_image/'.\Config::get('constants.OTHER_CATEGORY_LOGO_IMAGE'));
    }

    //get category list
    public static function categoryList() {
        $category = CouponCategory::active()->deleted()->get();
        return $category;
    }

    //get category list for web
    public static function categoryListWeb() {
        $category = CouponCategory::active()->deleted()->pluck('category_name', 'category_id')->toArray();
        return $category;
    }

    public static function categorySavedList($id) {

        $idsArr = explode(',', $id);
        $category = CouponCategory::whereIn('category_id', $idsArr)
                ->active()
                ->deleted()
                ->get();
        return $category;
    }

    public static function addCategory($data,$userid) {
        $cat = CouponCategory::create(['category_name' => $data['category_name'],
                    'is_requested' => self::IS_TRUE,
                    'category_image'=>\Config::get('constants.OTHER_CATEGORY_IMAGE'),
                    'category_logo_image'=>\Config::get('constants.OTHER_CATEGORY_LOGO_IMAGE'),
                    'requested_by' => $userid,
                    'is_active' => self::IS_TRUE,
                    'is_delete' => self::IS_FALSE,
        ]);
        return $cat;
    }

}
//ALTER TABLE `coupon_category` CHANGE `category_image` `category_image` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;