<?php

// Utilities
use Illuminate\Support\Facades\Route;

// Controllers Imported
use App\Http\Controllers\ApiController;

// Web Routing
Route::get('/', [ApiController::class , 'default_api_page']);
