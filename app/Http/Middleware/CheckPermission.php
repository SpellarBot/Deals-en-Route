<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Services\ResponseTrait;
class CheckPermission
{
    
    use ResponseTrait;
       /**

     * Handle an incoming request.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Closure  $next

     * @return mixed

     */

    public function handle($request, Closure $next, $permission)

    {
        $permission = explode('|', $permission);

        if(checkPermission($permission)){

            return $next($request);

        }
       $response= $next($request);
        if($response->headers->get('content-type') == 'application/json')
        {
        return $this->responseJson('error', \Config::get('constants.NOT_AUTHORIZED'), 400);
           
        }
        return $response;

    }
}
