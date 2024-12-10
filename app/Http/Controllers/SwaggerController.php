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
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 *  )
 */
class SwaggerController extends Controller
{
    //
}
