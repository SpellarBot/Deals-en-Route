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

<<<<<<< HEAD
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
=======
//    const CREATED_AT = 'createddate';
//    const UPDATED_AT = 'updateddate';
>>>>>>> 685b56304c0f96259722ce41d9d39ab9170e58ca

    public $primaryKey = 'category_id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    protected $fillable = [
        'category_id', 'category_name', 'category_image', 'is_active', 'is_delete', 'reject_reason', 'request_email', 'is_requested'
    ];

    public function scopeActive($query) {
        return $query->where('is_active', self::IS_TRUE);
    }

    public function scopeDeleted($query) {
        return $query->where('is_delete', self::IS_FALSE);
    }

    public function getCategoryImageAttribute($value) {

        return (!empty($value)) ? URL::to('/storage/app/public/category_image') . '/' . $value : "";
    }

    //category logo image
    public function getCategoryLogoImageAttribute($value) {

        return (!empty($value)) ? URL::to('/storage/app/public/category_logo_image') . '/' . $value : "";
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

    public static function addCategory($data) {
        $cat = CouponCategory::create(['category_name' => $data['category_name'],
                    'request_email' => $data['request_email'],
                    'is_requested' => self::IS_TRUE,
                    'is_active' => self::IS_FALSE,
                    'is_delete' => self::IS_FALSE,
        ]);
        return $cat;
    }

}
