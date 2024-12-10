<?php

namespace App\Http\Controllers;

// Utilities
use App\Helpers\GarlitoApiResponseHelper;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class ApiController extends BaseApiController
{
    public function default_api_page(): JsonResponse
    {
        return GarlitoApiResponseHelper::json_response([
            'name' => env('GARLITO_API_NAME') ?? 'Garlito API',
            'api_url' => url('/api'),
            'swagger_url' =>  url('/api/documentation'),
            'version' => env('GARLITO_API_VERSION') ?? '1.0.0'
        ]);
    }

}
