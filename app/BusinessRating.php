<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BusinessRating extends Model {

    //
    public $table = 'business_rating';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'id';
    protected $fillable = [
        'id', 'user_id', 'vendor_id', '	rating', 'comments', 'created_at', 'updated_at'
    ];

    public static function addRating($data) {
        $addRating = BusinessRating::updateOrCreate(
                        ['vendor_id' => $data['vendor_id'], 'user_id' => auth()->id()], ['user_id' => auth()->id(),
                    'vendor_id' => $data['vendor_id'],
                    'rating' => $data['rating'],
                    'comments' => $data['comments']
                        ]
        );
        return $addRating;
    }

//
//    public static function editComment($data) {
//        $editComment = DealComments::find($data['comment_id']);
//        $editComment->comment_desc = $data['comment'];
//        $editComment->save();
//        return $editComment;
//    }

    public static function getRatings($id) {
        $getRatings = BusinessRating::select(\DB::raw('sum(rating) as total_ratings'))
                ->where('vendor_id', $id)
                ->first();
        return $getRatings->getAttributes();
    }

}
