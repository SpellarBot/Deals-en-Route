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

class PaymentInfo extends Model {

    use NotificationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'paymentinfo';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const payment_status_success = 'success';
    const payment_status_failed = 'failed';
    const payment_status_pending = 'pending';

    public $primaryKey = 'id';
    protected $fillable = [
        'vendor_id', 'payment_status', 'transaction_id', 'payment_amount', 'description', 'created_at', 'updated_at'
    ];

    public static function create($data) {
        $payment = new PaymentInfo;
        $payment->vendor_id = $data['vendor_id'];
        $payment->payment_amount = $data['totalamount'];
        if ($data['status'] = 'success') {
            $payment->payment_status = self::payment_status_success;
        } else {
            $payment->payment_status = self::payment_status_failed;
        }
        $payment->description = $data['description'];
        $payment->transaction_id = $data['transaction_id'];
        $payment->invoice = $data['invoice'];
        $payment->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $payment->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $payment->save();
        return $payment;
    }

}
