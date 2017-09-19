<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceDetail extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'device_token', 'device_type', 'device_version', 'app_version',
    ];
    public $table = 'device_detail';
    public $timestamps = false;

    public static function saveDeviceToken($data, $user_id) {
        $device_detail = DeviceDetail::firstOrNew(["user_id" => $user_id]);
        $device_detail->user_id = $user_id;
        $device_detail->fill($data);
        $device_detail->save();
    }

}
