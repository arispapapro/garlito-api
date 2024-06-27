<?php

namespace App\Http\Controllers;

// Utilities
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{

    public function json_response( array $value = array() ): JsonResponse
    {
        return response()->json($value);
    }

}
