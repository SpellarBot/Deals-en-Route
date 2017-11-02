<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIFVendorAuthenticated {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        $auth = Auth::guard('web');

        if ($auth->check()) {

            if (Auth::user()->is_confirmed == 1) {
             
               return $next($request);
            }
            return redirect('/');
        }

 return redirect('/');
    }

}
