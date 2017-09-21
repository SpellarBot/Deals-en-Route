<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api\v1','prefix' => 'v1'], function()
{ 
    
     Route::post('/user/register', 'Auth\RegisterController@create');
     Route::post('/user/login', 'Auth\LoginController@login');
     Route::middleware('auth:api')->post('/user/adddetail', 'Auth\LoginController@addUserDetail');
     Route::middleware('auth:api')->post('/category/list', 'CouponCategoryController@categoryList');
      Route::middleware('auth:api')->post('/category/savelist', 'CouponCategoryController@categorySave');
     Route::middleware('auth:api')->post('/coupon/categorywise ', 'CouponController@couponListCategoryWise');
      Route::middleware('auth:api')->post('/user/logout', 'Auth\LoginController@logout');
     
});

//Route::group(['prefix' => 'v2'], function()
//{ 
//    
//     Route::get('/test/user', 'api\v2\Auth\LoginController@test2');
//     
//});
