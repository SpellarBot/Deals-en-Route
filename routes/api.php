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
    
     Route::post('/register/user', 'Auth\RegisterController@create');
     
});

//Route::group(['prefix' => 'v2'], function()
//{ 
//    
//     Route::get('/test/user', 'api\v2\Auth\LoginController@test2');
//     
//});
