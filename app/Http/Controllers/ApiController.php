<?php

namespace App\Http\Controllers;

// Utilities
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class ApiController extends BaseApiController
{
    /**
     *
     * @OA\Get(
     *     path="/",
     *     tags={"Default"},
     *     operationId="defaultRootPage",
     *     summary="Fetch Default Root Page.",
     *     @OA\Response(
     *      response=200,
     *      description="Response Successful",
     *      @OA\JsonContent(
     *       example={"name":"Garlito API","version":"1.0.1"}
     *      )
     *     )
     * )
     */
    public function default_api_page(): JsonResponse
    {
        return $this->json_response([
            'name' => env('GARLITO_API_NAME') ?? 'Garlito API',
            'api_url' => url('/api'),
            'swagger_url' =>  url('/api/documentation'),
            'version' => env('GARLITO_API_VERSION') ?? '1.0.0'
        ]);
    }

}
