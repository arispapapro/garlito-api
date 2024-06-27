<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *     title="Garlito API Documentation",
 *     version="1.0.0"
 * )
 * @OA\Server(
 *       url= L5_SWAGGER_CONST_HOST,
 *       description="Development API Server"
 *  )
 *  @OA\SecurityScheme(
 *      type="http",
 *      description="API token is required to access this API",
 *      in="header",
 *      scheme="bearer",
 *      securityScheme="BearerAuth",
 *  )
 */
class SwaggerController extends Controller
{
    //
}
