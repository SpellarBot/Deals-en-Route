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

Route::group(['namespace' => 'Api\v1', 'prefix' => 'v1'], function() {
    Route::post('/user/register', 'Auth\RegisterController@create');
    Route::post('/user/login', 'Auth\LoginController@login');
    Route::post('/user/socialregister', 'Auth\RegisterController@registerwithfb');
    Route::post('/user/addemail', 'Auth\RegisterController@addemail');
     Route::post('/user/forgetpassword', 'Auth\ResetPasswordController@postEmail');
    
   Route::get('/user/cron', 'CouponController@CouponNotification');
    Route::group(['middleware' => ['auth:api','check-permission:user']], function() {
        // Routes that passed auth, confirmed, subscribed, and active middleware
        // additional routes here
    Route::post('/user/update', 'Auth\RegisterController@update');   
    Route::post('/user/adddetail', 'Auth\LoginController@addUserDetail');
    Route::post('/category/list', 'CouponCategoryController@categoryList');
    Route::post('/category/savelist', 'CouponCategoryController@categorySave');
    Route::post('/coupon/categorywise ', 'CouponController@couponListCategoryWise');
    Route::post('/coupon/detail', 'CouponController@couponDetail');
    Route::post('/coupon/addfav', 'CouponController@addFavourite');
    Route::post('/coupon/favlist', 'CouponController@couponFavList');
    Route::post('/coupon/searchlist', 'CouponController@couponSearchList');
    Route::post('/coupon/redeemlist', 'CouponController@redeemCouponList');
    Route::post('/coupon/sharelist', 'CouponController@shareCouponList');
    Route::post('/coupon/addredeem', 'CouponController@addRedeem');
    
    
    //activity feed
    Route::post('/activity/checkfb', 'ActivityController@checkFb');
    Route::post('/activity/addfbfriend', 'ActivityController@addFbFriend');
    Route::post('/activity/activitylist', 'ActivityController@activityList');
    Route::post('/activity/addlike', 'ActivityController@acivityAddLike');
    Route::post('/activity/comment', 'ActivityController@comment');
    Route::post('/activity/commentlist', 'ActivityController@commentList');   
    Route::post('/activity/share', 'ActivityController@shareActivity');
    
    
    Route::post('/user/logout', 'Auth\LoginController@logout');
    
     //notification list
    Route::post('/notification/isread', 'ActivityController@addnotificationread');
    Route::post('/notification/list', 'ActivityController@notificationList');

        // additional routes here
    });
});

//Route::group(['prefix' => 'v2'], function()
//{ 
//    
//     Route::get('/test/user', 'api\v2\Auth\LoginController@test2');
//     
//});
