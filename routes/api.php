<?php

// Utilities
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers Imported
use App\Http\Controllers\ApiController;

// Web Routing


Route::get('/', [ApiController::class , 'default_api_page']);




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
