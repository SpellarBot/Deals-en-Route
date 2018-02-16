<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use Auth;
use App\Http\Transformer\ActivityTransformer;
use App\Http\Transformer\UserTransformer;
use Carbon\Carbon;
use App\ActivityCommentLike;
use URL;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller {

    use \App\Http\Services\ResponseTrait;
    use \App\Http\Services\ActivityTrait;



    public function addReportContent(Request $request) {
        try {
            // get the request
            $data = $request->all();
            
        $validator = Validator::make($data, [
            'report_content' => 'required',
            'comment_id' => 'required',
            'type' => 'required',
        ]);
          
            if ($validator->fails()) {
                return $this->responseJson('error', $validator->errors()->first(), 400);
            }
            //add like
            $reportcontent = \App\ReportContent::addReportContent($data);
            if ($reportcontent) {
                return $this->responseJson('success', \Config::get('constants.CONTENT_ADD'), 200);
            }
            
        } catch (\Exception $e) {
           // throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function fetchCityRequest(Request $request) {
        try {
            // get the request
            $data = $request->all();
            
        $validator = Validator::make($data, [
            'name' => 'required',

        ]);
          
            if ($validator->fails()) {
                return $this->responseJson('error', $validator->errors()->first(), 400);
            }
            //add like
            $reportcontent = \App\UsCity::searchCity($data);
          if($reportcontent){
             return $this->responseJson('success', \Config::get('constants.CITY_REQUEST'), 200,'true');
          }
              return $this->responseJson('success', \Config::get('constants.CITY_REQUEST'), 200,'false');
        } catch (\Exception $e) {
           // throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }

    public function addCityList(Request $request) {
        try {
            // get the request
            $data = $request->all();
          
            //add like
            $citylist =\App\UsCity::cityListRequest($data);
            if ($citylist) {
                return $this->responseJson('success', \Config::get('constants.CITY_LIST'), 200,$citylist);
            }
            
        } catch (\Exception $e) {
            throw $e;
            return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
        }
    }


    
    
    

}
