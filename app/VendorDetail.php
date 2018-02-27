<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;
use Auth;
use DB;

class VendorDetail extends Model {

    use \App\Http\Services\UserTrait;
    use \App\Http\Services\CouponTrait;

    protected $table = 'vendor_detail';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false;
    public $primaryKey = 'vendor_id';
    protected $fillable = [
        'user_id', 'vendor_name', 'vendor_address', 'vendor_city', 'vendor_zip',
        'vendor_logo', 'vendor_category', 'vendor_phone', 'vendor_state',
        'billing_home', 'billing_state', 'billing_zip', 'billing_city',
        'billing_country', 'vendor_country', 'vendor_state', 'vendor_city', 'vendor_lat',
        'vendor_long', 'billing_businessname', 'check-address', 'vendor_time_zone',
        'deal_used','additional_geo_location_used','additional_geo_fencing_used',
        'additional_geo_location_total','additional_geo_fencing_total','vendor_street_address'
    ];

    public function userSubscription() {
        return $this->hasManyThrough('App\PlanAccess', 'App\Subscription', 'user_id', 'plan_id', 'user_id', 'stripe_plan');
    }

    public function planAccess() {
        return $this->belongsTo('App\PlanAccess', 'stripe_plan', 'plan_id');
    }

    /**
     * Get the vendor detail record associated with the user.
     */
    public function vendorDetail() {
        return $this->hasOne('App\VendorDetail', 'user_id', 'created_by');
    }

    public function stripeUser() {
        return $this->hasOne('App\StripeUser', 'user_id', 'user_id');
    }

    public function getVendorLogoAttribute($value) {
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/vendor_logo/' . $value))) ? URL::to('/storage/app/public/vendor_logo/') . '/' . $value : URL::to('/storage/app/public/vendor_logo/');
    }

    public static function getStripeVendor() {
        $vendor_detail = \App\VendorDetail::join('stripe_users', 'stripe_users.user_id', 'vendor_detail.user_id')
                ->where('vendor_detail.user_id', Auth::id())
                ->first();
        $user_access = $vendor_detail->userAccess();
        $user = \App\Subscription::where('user_id', Auth::id())->first();
        if ($user) {
            $deals_left = $user->getRenewalCoupon($user_access);
            if ($user_access['dealstotal'] != 0) {
                $deals_percent = ($deals_left / $user_access['dealstotal']) * 100;
            } else {
                $deals_percent = 0;
            }
            return ['deals_left' => $deals_left, 'deals_percent' => $deals_percent];
        }
    }

    // save vendor detail
    public static function saveVendorDetail($data, $user_id) {
        if (isset($data['check-address'])) {
            $checkaddress = $data['check-address'];
            unset($data['check-address']);
        }
        $vendor_detail = VendorDetail::firstOrNew(["user_id" => $user_id]);
        $vendor_detail->user_id = $user_id;
        $vendor_detail->additional_geo_fencing_total=0;
        $vendor_detail->additional_geo_location_used=0;
        $vendor_detail->additional_geo_fencing_used=0;
        $vendor_detail->additional_geo_location_total=0;
        $vendor_detail->fill($data);
        $vendor_detail->save();

        if (isset($checkaddress) && $checkaddress == 'yes') {

            self::saveBusinessAddress($vendor_detail, $data);
        }
        if (empty($data['vendor_lat']) || empty($data['vendor_long'])) {
            self::saveMapLatLong($vendor_detail);
        }

        return $vendor_detail;
    }

    //create vendor for admin
    public static function createVendor($data = []) {

        $user = User::create([
                    'role' => 'vendor',
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'is_confirmed' => User::IS_CONFIRMED,
        ]);
        $user_id = $user->id;
        return self::saveVendorDetail($data, $user_id);
    }

    //update vendor
    public static function updateVendor($data = [], $id) {
        //update user
        $user = User::find($id);
        $user->fill($data);

        $user->save();
        $data['vendor_category'] = implode(',', $data['vendor_category']);
        return self::saveVendorDetail($data, $id);
    }

    //update vendor
    public static function updateVendorDetails($data = [], $id) {
        $vendor = VendorDetail::where('user_id', $id)->first();
        $vendor->fill($data);
        $vendor->save();
        return $vendor;
    }

    //create vendor for front
    public static function createVendorFront($data = []) {

        $user = User::create([
                    'role' => 'vendor',
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'is_confirmed' => User::IS_NOT_CONFIRMED,
        ]);
        $user->confirmation_code = $user->generateRandomString();
        $user->save();
        $user_id = $user->id;
        return self::saveVendorDetail($data, $user_id);
    }

    // save map lat long 
    public static function saveMapLatLong($model) {
        $response = \GoogleMaps::load('geocoding')
                ->setParam(['address' => $model->vendor_address])
                ->get();
        $response1 = json_decode($response);
        
        $streetaddress="";
        foreach($response1->results[0]->address_components as $element){

       if(($element->types[0]=='street_number')){
            $streetaddress .=$element->long_name. ",";
        }
       if(($element->types[0]=='route')){
            $streetaddress .=$element->long_name.",";
        }
        
         if(($element->types[0]=='political')){
            $streetaddress .=$element->long_name.",";
        }
        }
        
       $streetaddress=  substr($streetaddress, 0, -1);
     
       // $response1->results[0]->route
        if ($response1->status != 'ZERO_RESULTS') {
            $model->vendor_street_address=$streetaddress;
            $model->vendor_lat = $response1->results[0]->geometry->location->lat;
            $model->vendor_long = $response1->results[0]->geometry->location->lng;
        }
        $model->save();
    }

    public static function saveBusinessAddress($vendor_detail, $data) {

        $vendor_detail->billing_businessname = $data['vendor_name'];
        $vendor_detail->billing_home = $data['vendor_address'];
        $vendor_detail->billing_state = $data['vendor_state'];
        $vendor_detail->billing_city = $data['vendor_city'];
        $vendor_detail->billing_zip = $data['vendor_zip'];
        $vendor_detail->billing_country = $data['vendor_country'];
    }

    public function setTimezone() {
        if (!empty($this->vendor_lat) && !empty($this->vendor_long)) {
            $response = \GoogleMaps::load('timezone')
                    ->setParam([
                        'location' => "$this->vendor_lat,$this->vendor_long",
                        'timestamp' => 1458000000,
                    ])
                    ->get();
            $responseTime = json_decode($response);
            $timezone = $responseTime->timeZoneId;
        } else {
            $timezone = 'America/New_York';
        }
        $model_user = User::find($this->user_id);
        $model_user->timezone = $timezone;
        $model_user->save();
    }

    public static function getVendorDetails($vendor_id) {
        $details = VendorDetail::select('*', 'stripe_users.user_id as vendor_id')
                ->leftjoin('stripe_users', 'stripe_users.user_id', 'vendor_detail.user_id')
                ->leftjoin('subscriptions', 'subscriptions.user_id', 'vendor_detail.user_id')
                ->leftjoin('country', 'country.id', 'vendor_detail.vendor_country')
                ->where('vendor_detail.user_id', $vendor_id)
                ->first();
        return $details;
    }

    public static function getNearestVendor($data) {
        $user = Auth()->user()->userDetail;
        $circle_radius = \Config::get('constants.EARTH_RADIUS');
        $coupontotal = [];
        $lat = $user->latitude;
        $lng = $user->longitude;
        $query = VendorDetail::select(DB::raw('vendor_lat,vendor_long,vendor_logo,vendor_name,billing_businessname,vendor_id,((' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(vendor_lat)) * cos(radians(vendor_long) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(vendor_lat)))) ) as distance'))
                ->havingRaw('(5 >= distance)');
        $result = $query->groupBy('vendor_id')->orderBy('distance', 'asc')->orderBy('vendor_id', 'desc')->simplePaginate(\Config::get('constants.PAGINATE'));
        return $result;
    }

}
