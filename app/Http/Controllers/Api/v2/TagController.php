<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Transformer\TagTransformer;
use App\User;
use Auth;
use App\Activity;

class TagController extends Controller {

    use \App\Http\Services\ResponseTrait;
    use \App\Http\Services\ActivityTrait;

    public function getAllUsers() {
         try {
// get the request
         $user= Activity::getTagUsers();
         
        if (count($user) > 0) {
            $data = (new TagTransformer)->transformAllUsers($user);
            return $this->responseJson('success', \Config::get('constants.TAG_LIST'), 200, $data);
        }
            return $this->responseJson('success', \Config::get('constants.NO_RECORDS'), 200);
        } catch (\Exception $e) {
//  throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
       

    }

}
