<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VendorHours extends Model {

    public $table = 'vendor_hours_of_operations';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'id';
    protected $fillable = [
        'id', 'days', 'vendor_id', 'open_time', 'close_time', 'created_at', 'updated_at'
    ];

    public static function addHoursOfOperations($data) {
        $addHours = VendorHours::updateOrCreate(
                        ['vendor_id' => auth()->id(), 'days' => $data['day']], [
                    'vendor_id' => auth()->id(),
                    'days' => $data['day'],
                    'open_time' => $data['open_time'],
                    'close_time' => $data['close_time'],
        ]);
    }

    public static function getHoursOfOperations($id) {
        $getHours = VendorHours::select('*')
                ->where('vendor_id', $id)
                ->get();
        return $getHours;
    }

}
