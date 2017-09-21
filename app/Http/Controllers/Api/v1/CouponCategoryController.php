<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Services\CategoryTrait;
use App\Http\Services\ResponseTrait;
use App\Http\Controllers\Api\v1\Controller;
use App\Http\Transformer\CategoryTransformer;
use Auth;

class CouponCategoryController extends Controller
{
    use CategoryTrait;
    use ResponseTrait;
    
    
    
     
    public function categoryList(){

     $categoryListData= \App\CouponCategory::categoryList();

     if(count($categoryListData)>0){
     $data = (new CategoryTransformer)->transformList($categoryListData);   
     return $this->responseJson('success', \Config::get('constants.CATEGORY_LIST'), 200,
             $data);
     }
     return $this->responseJson('error', \Config::get('constants.NO_RECORDS'), 200);
    }
    
    
    
    
    public function categorySave(Request $request){
     $data=$request->all();
     $categorySave= \App\UserDetail::saveUserDetail($data,Auth::id());

     if($categorySave){
     $categoryListData=\App\CouponCategory::categorySavedList($categorySave->category_id);    
    
     $data = (new CategoryTransformer)->transformList($categoryListData);   
     return $this->responseJson('success', \Config::get('constants.CATEGORY_SAVE'), 200,
             $data);
     }
       return $this->responseJson('error', \Config::get('constants.APP_ERROR'), 400);
    }
    
}
