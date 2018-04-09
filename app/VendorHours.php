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
        'id', 'days', 'vendor_id', 'open_time', 'close_time', 'created_at',
        'updated_at','fill_all'
    ];

    public static function addHoursOfOperations($data) {
      VendorHours::where('vendor_id', '=', auth()->id())->update(['fill_all' => (isset($data['fillcheckbox']))?1:0]);
    
      if(isset($data['fillcheckbox'])){
      unset($data['fillcheckbox']);
      }
        $i = 0;
        foreach ($data as $hours) {
           
              
                $dt1 = isset($hours[1])?new Carbon($hours[1]):"";
                $dt2 = isset($hours[2])? new Carbon($hours[2]):"";
                 if(empty($dt1) && empty($dt2)) {
                  $i++;
                 }
                $add['day'] = $hours[0];
                $add['open_time'] = !empty($dt1)?$dt1->format('H:i:s'):"";
                $add['close_time'] = !empty($dt2)?$dt2->format('H:i:s'):"";
                self::vendorHourUpdate($add);
            
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
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
        ];
        return $weeks;
    }

}
