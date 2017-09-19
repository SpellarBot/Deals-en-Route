<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Services\CategoryTrait;
use App\Http\Services\ResponseTrait;
use App\Http\Controllers\Api\v1\Controller;
use App\Http\Transformer\CategoryTransformer;

class CouponCategoryController extends Controller
{
    use CategoryTrait;
    use ResponseTrait;
    public function categoryList(){

     $categoryListData= \App\CouponCategory::categoryList();

     if(count($categoryListData)>0){
    
      return $this->responseJson('success', \Config::get('constants.CATEGORY_LIST'), 200,
              $categoryListData->makeHidden(['created_at','updated_at','is_active','is_delete']));
     }
     return $this->responseJson('error', \Config::get('constants.NO_RECORDS'), 200);
    }
}
