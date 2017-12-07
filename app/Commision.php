<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use URL;
use Auth;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use App\Http\Services\CouponTrait;
use App\Http\Services\NotificationTrait;

class Commision extends Model {

    use CouponTrait;
    use NotificationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'commision';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const IS_TRUE = 1;
    const IS_FALSE = 0;

    public $primaryKey = 'id';
    protected $fillable = [
        'vendor_id', 'coupon_id', 'amount', 'created_at', 'updated_at'
    ];

    public static function create($data) {
        $commision = new Commision;
        $commision->vendor_id = $data['vendor_id'];
        $commision->coupon_id = $data['coupon_id'];
        $commision->amount = $data['amount'];
        $commision->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $commision->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $commision->save();
        return $commision;
    }

    public static function updateCommision($data) {
        $update = Commision::where('vendor_id', '=', $data['vendor_id'])
                ->update(array('is_paid' => self::IS_TRUE));
        return $update;
    }

    public static function getCommisionDetails() {
        $commisiondetails = Commision::selectRaw('id,vendor_id,sum(amount) as totalcommision')
                ->where('is_paid', self::IS_FALSE)
                ->groupBy('vendor_id')
                ->get();
        return $commisiondetails;
    }

}
