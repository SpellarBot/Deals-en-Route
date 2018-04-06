<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VendorHours extends Model {

    public $table = 'vendor_hours_of_operations';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'id';
    protected $fillable = [
        'id', 'days', 'vendor_id', 'open_time', 'close_time', 'created_at', 'updated_at'
    ];

    public static function addHoursOfOperations($data) {
        $i = 0;
        foreach ($data as $hours) {
            if ($hours[1] && $hours[2]) {
                $i++;
                $dt1 = new Carbon($hours[1]);
                $dt2 = new Carbon($hours[2]);
                $add['day'] = $hours[0];
                $add['open_time'] = $dt1->format('H:i:s');
                $add['close_time'] = $dt2->format('H:i:s');
                self::vendorHourUpdate($add);
            }
        }
        return $i;
    }

    public static function vendorHourUpdate($data) {

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

    public static function listWeeks() {
        $weeks = [
            'sunday',
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
        ];
        return $weeks;
    }

}
