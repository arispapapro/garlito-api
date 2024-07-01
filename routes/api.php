<?php

// Utilities
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers Imported
use App\Http\Controllers\ApiController;
use App\Http\Controllers\RoleController;

// Default Routes
Route::get('/', [ApiController::class , 'default_api_page']);


//----------------------------------------------------------------------------------------------------------------------
// Model : Role
//----------------------------------------------------------------------------------------------------------------------

//======================================================================================================================

$model_single = 'role';
$model_plural = 'roles';
$model_controller = RoleController::class;
//======================================================================================================================

// Create
Route::post('/'.$model_single, [$model_controller , 'create_model']);

// Update Single
Route::put('/'.$model_single.'/{id}', [$model_controller , 'update_model']);

// Delete Single
Route::delete('/'.$model_single.'/{id}', [$model_controller , 'delete_model']);

// Fetch Single
Route::get('/'.$model_single.'/{id}', [$model_controller , 'single_model']);

// Fetch All
Route::get('/'.$model_plural, [$model_controller , 'all_models']);

// Fetch Options
Route::get('/'.$model_single.'/options', [$model_controller , 'model_options']);

//----------------------------------------------------------------------------------------------------------------------
