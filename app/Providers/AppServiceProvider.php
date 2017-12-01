<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Support\Facades\Input;
use Auth;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        // greater than other field
        Validator::extend('greater_than', function($attribute, $value, $parameters) {
            $other = Input::get($parameters[0]);

            if (!empty($other) && $other != '') {

                return isset($other) and intval($value) > intval($other);
            }
            return true;
        });
        
        //less than other field
        Validator::extend('less_than', function($attribute, $value, $parameters) {
            $other = Input::get($parameters[0]);

            return isset($other) and intval($value) < intval($other);
        });
        
         //less than other field
        Validator::extend('currentpassword', function($attribute, $value, $parameters) {
                   $hasher = app('hash');
if ($hasher->check($value, Auth::user()->password)) {
            return true;
       
}
return false;
        
        });
        
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
