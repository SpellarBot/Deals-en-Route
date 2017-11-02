<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'country';
    public $primaryKey = 'id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public function scopeActive($query) {
        return $query->where('is_delete', self::IS_FALSE);
    }

    public static function countryList() {
        $countrylist = Country::active()->pluck('country_name', 'id')->toArray();
        return $countrylist;
    }

}
