<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VendorRating extends Model {

    //
    public $table = 'vendor_rating';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'id';
    protected $fillable = [
        'id', 'user_id', 'vendor_id', 'rating', 'comments', 'created_at', 'updated_at'
    ];

    public static function addRating($data) {
        $addRating = VendorRating::updateOrCreate(
                        [
                    'vendor_id' => $data['vendor_id'],
                    'user_id' => auth()->id()], ['user_id' => auth()->id(),
                    'vendor_id' => $data['vendor_id'],
                    'rating' => (int) $data['rating'],
                    'comments' => $data['comment']
                        ]
        );
        return $addRating;
    }

    public static function getRatings($id) {
        $getRatings = VendorRating::select(\DB::raw('sum(rating) as total_ratings'))
                ->where('vendor_id', $id)
                ->first();
        if ($getRatings) {
            return $getRatings->getAttributes();
        } else {
            return 0;
        }
    }

    public static function getRatingsDetails($id) {
        $getRatings = VendorRating::select(\DB::raw('vendor_rating.*,user_detail.first_name,user_detail.last_name,user_detail.profile_pic'))
                ->leftjoin('user_detail', 'user_detail.user_id', 'vendor_rating.user_id')
                ->where('vendor_rating.vendor_id', $id)
                ->get();
        return $getRatings;
    }

}
