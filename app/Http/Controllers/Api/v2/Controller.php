<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

    /**
     * @SWG\Swagger(
     *   basePath="/dealenroute/api/v1",
     *   @SWG\Info(
     *     title="dealenroute api",
     *     version="1.0.0"
     *   )
     * )
     */
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;
}
