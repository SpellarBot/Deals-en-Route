<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;
use Redirect;
use App\Http\Requests\RegisterFormRequest;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Transformer\VendorTransformer;
use App\Http\Services\ResponseTrait;
use App\Http\Services\ImageTrait;
use App\Http\Services\MailTrait;
use Auth;

class VendorController extends Controller {

    use ImageTrait;
    use ResponseTrait;
    use MailTrait;
    /*     * **************Update Vendor************************** */

    public function update(Request $request) {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $user_id = Auth::id();
            foreach($data as $key=>$value){
                if(!$value || $value == 'undefined'){
                    unset($data[$key]);
                }
            }
            $user = \App\VendorDetail::updateVendorDetails($data, $user_id);
            if ($request->file('vendor_logo')) {
                $this->updateImage($request, $user, 'vendor_logo');
            }

            // save the user
        } catch (\Exception $e) {
            DB::rollback();
  throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
// If we reach here, then// data is valid and working.//
        $user->vendor = $user;
        DB::commit();
        $data = (new VendorTransformer)->transformLogin($user);
        return $this->responseJson('success', \Config::get('constants.USER_UPDATED_SUCCESSFULLY'), 200, $data);
    }
    
}
