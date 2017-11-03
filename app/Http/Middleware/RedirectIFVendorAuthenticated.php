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
    public function handle($request, Closure $next, $guard = 'web') {
        $auth = Auth::guard('web');

        if (!$auth->check()) {
           return redirect('/');
        }
    
        return $next($request);
    }

}
