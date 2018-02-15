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

Route::post('/vendor/password/reset', ['uses' => 'Api\v1\Auth\ResetPasswordController@postReset', 'as' => 'password.request']);

Route::group(['namespace' => 'Api\v1', 'prefix' => 'v1'], function() {
    Route::post('/user/register', 'Auth\RegisterController@create');
    Route::post('/user/login', 'Auth\LoginController@login');
    Route::post('/user/socialregister', 'Auth\RegisterController@registerwithfb');
    Route::post('/user/addemail', 'Auth\RegisterController@addemail');
    Route::post('/user/forgetpassword', 'Auth\ResetPasswordController@postEmail');
    /*     * **                  Vendor            ** */
    Route::post('/vendor/register', 'Auth\VendorRegisterController@create');
    Route::post('/vendor/login', 'Auth\LoginController@vendorlogin');
    Route::get('/vendor/category/list', 'CouponCategoryController@categoryList');
    /*     * **                  Vendor            ** */

    Route::get('/user/cron', 'CouponController@CouponNotification');

    Route::any('/stripe/endpoint', 'StripeController@handleStripeResponse');

    // cron notification
    Route::post('/coupon/reddemleft', 'NotificationController@couponNotificationFavLeft');
    Route::post('/coupon/favexpire', 'NotificationController@couponNotificationFavExpire');

    Route::get('/vendor/commisionPayout', 'CouponController@commisionPayout');
    Route::get('/vendor/getCountry', 'HomeController@getCountry');
    Route::get('/vendor/htmltopdfview', array('as' => 'htmltopdfview', 'uses' => 'HomeController@htmltopdfview'));

    Route::group(['middleware' => ['auth:api', 'check-permission:user']], function() {
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
        Route::post('/activity/commentedit', 'ActivityController@commentEdit');
        
        // user logout
        Route::post('/user/logout', 'Auth\LoginController@logout');

        //notification list
        Route::post('/notification/isread', 'ActivityController@addnotificationread');
        Route::post('/notification/list', 'ActivityController@notificationList');
        Route::post('/notification/allread', 'ActivityController@addnotificationallread');
        //contact us 
        Route::post('/contact/addcontact', 'CouponController@addContact');

        //geonotification
        Route::post('/coupon/geonotify', 'NotificationController@couponGeoNotification');

        // additional routes here
    });
    //vendor routes
    Route::group(['middleware' => ['auth:api', 'check-permission:vendor']], function() {
        Route::post('/vendor/update', 'Auth\VendorRegisterController@update');
        Route::post('/vendor/logout', 'Auth\LoginController@vendorlogout');
        Route::post('/vendor/getCoupons', 'CouponController@getCoupons');
        Route::post('/vendor/couponRedemption', 'CouponController@CouponRedemption');
        Route::post('/vendor/dashboard', 'HomeController@dashboard');
        Route::post('/vendor/getReedeemCouponByYear', 'HomeController@getReedeemCouponByYear');
        Route::post('/vendor/editCreditCard', 'StripeController@editCreditCard');
        Route::post('/vendor/changeSubscription', 'StripeController@changeSubscription');
        Route::post('/vendor/cancelSubscription', 'StripeController@cancelSubscription');
        Route::get('/vendor/settings', 'HomeController@getSettings');
        Route::post('/vendor/purchaseMiles', 'StripeAddOnsController@purchaseMiles');
        Route::post('/vendor/purchaseGeoFence', 'StripeAddOnsController@purchaseGeoFence');
        Route::post('/vendor/purchaseDeals', 'StripeAddOnsController@purchaseDeals');
        Route::post('/vendor/addcontact', 'CouponController@addContact');
        Route::post('vendor/updatePassword', 'Auth\ResetPasswordController@updatePasssword');
    });
});

Route::group(['namespace' => 'Api\v2', 'prefix' => 'v2'], function() {
    Route::post('/user/register', 'Auth\RegisterController@create');
    Route::post('/user/login', 'Auth\LoginController@login');
    Route::post('/user/socialregister', 'Auth\RegisterController@registerwithfb');
    Route::post('/user/addemail', 'Auth\RegisterController@addemail');
    Route::post('/user/forgetpassword', 'Auth\ResetPasswordController@postEmail');
    /*     * **                  Vendor            ** */
    Route::post('/vendor/register', 'Auth\VendorRegisterController@create');
    Route::post('/vendor/login', 'Auth\LoginController@vendorlogin');
    Route::get('/vendor/category/list', 'CouponCategoryController@categoryList');
    /*     * **                  Vendor            ** */

    Route::get('/user/cron', 'CouponController@CouponNotification');

    Route::any('/stripe/endpoint', 'StripeController@handleStripeResponse');

    // cron notification
    Route::post('/coupon/reddemleft', 'NotificationController@couponNotificationFavLeft');
    Route::post('/coupon/favexpire', 'NotificationController@couponNotificationFavExpire');

    Route::get('/vendor/commisionPayout', 'CouponController@commisionPayout');
    Route::get('/vendor/getCountry', 'HomeController@getCountry');
    Route::get('/vendor/htmltopdfview', array('as' => 'htmltopdfview', 'uses' => 'HomeController@htmltopdfview'));

    Route::group(['middleware' => ['auth:api', 'check-permission:user']], function() {
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
        Route::post('/activity/comment/like', 'ActivityController@acivityAddCommentLike');
        Route::post('/activity/commentlist', 'ActivityController@commentList');
        Route::post('/activity/share', 'ActivityController@shareActivity');
        Route::post('/activity/commentedit', 'ActivityController@commentEdit');
        Route::post('/activity/getActivityComments', 'ActivityController@getActivityComments');

        // user logout
        Route::post('/user/logout', 'Auth\LoginController@logout');

        //notification list
        Route::post('/notification/isread', 'ActivityController@addnotificationread');
        Route::post('/notification/list', 'ActivityController@notificationList');
        Route::post('/notification/allread', 'ActivityController@addnotificationallread');
        //contact us 
        Route::post('/contact/addcontact', 'CouponController@addContact');

        //geonotification
        Route::post('/coupon/geonotify', 'NotificationController@couponGeoNotification');

        //Deal(Coupon) Likes and Comments Routes

        Route::post('/coupon/likedeal', 'CouponController@addlike');
        Route::post('/coupon/commentdeal', 'CouponController@addComment');
        Route::post('/coupon/commentdeal/like', 'CouponController@addCommentLike');
        Route::post('/coupon/editcommentdeal', 'CouponController@editComment');
        Route::post('/coupon/vendorFromCoupon', 'CouponController@getVendorDetails');
        Route::post('/coupon/getCommentsofDeal', 'CouponController@getCommentsofDeal');
        Route::post('/user/vendorRating', 'VendorController@vendorRating');
        Route::post('/user/getVendorRatingDetails', 'VendorController@getVendorRatingsDetails');
        Route::post('/user/getNearByVendorlist', 'VendorController@getNearByVendors');
        Route::post('/user/getCouponsByVendor', 'CouponController@getCouponsByVendor');
        Route::post('/user/getVendorDetails', 'VendorController@getVendorDetails');
        
        //tag friends
          Route::post('/tag/friendlist', 'TagController@getAllUsers');
        
          //report content
          Route::post('/services/addreport', 'ServicesController@addReportContent');

        // additional routes here
    });
    //vendor routes
    Route::group(['middleware' => ['auth:api', 'check-permission:vendor']], function() {
        Route::post('/vendor/update', 'Auth\VendorRegisterController@update');
        Route::post('/vendor/logout', 'Auth\LoginController@vendorlogout');
        Route::post('/vendor/getCoupons', 'CouponController@getCoupons');
        Route::post('/vendor/couponRedemption', 'CouponController@CouponRedemption');
        Route::post('/vendor/dashboard', 'HomeController@dashboard');
        Route::post('/vendor/getReedeemCouponByYear', 'HomeController@getReedeemCouponByYear');
        Route::post('/vendor/editCreditCard', 'StripeController@editCreditCard');
        Route::post('/vendor/changeSubscription', 'StripeController@changeSubscription');
        Route::post('/vendor/cancelSubscription', 'StripeController@cancelSubscription');
        Route::get('/vendor/settings', 'HomeController@getSettings');
        Route::post('/vendor/purchaseMiles', 'StripeAddOnsController@purchaseMiles');
        Route::post('/vendor/purchaseGeoFence', 'StripeAddOnsController@purchaseGeoFence');
        Route::post('/vendor/purchaseDeals', 'StripeAddOnsController@purchaseDeals');
        Route::post('/vendor/addcontact', 'CouponController@addContact');
        Route::post('vendor/updatePassword', 'Auth\ResetPasswordController@updatePasssword');
    });
});
//Route::group(['prefix' => 'v2'], function()
//{ 
//    
//     Route::get('/test/user', 'api\v2\Auth\LoginController@test2');
//     
//});
