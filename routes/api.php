<?php

// Utilities
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers Imported
use App\Http\Controllers\ApiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthenticationController;

// Default Routes
Route::get('/', [ApiController::class , 'default_api_page']);


//----------------------------------------------------------------------------------------------------------------------
// Unauthenticated Routes
//----------------------------------------------------------------------------------------------------------------------
Route::post('register', [AuthenticationController::class , 'register']);
Route::post('login', [AuthenticationController::class , 'login']);
Route::post('forgot-password' , [AuthenticationController::class, 'forgot_password']);
Route::post('reset-password', [AuthenticationController::class , 'reset_password']);
Route::get('activate-account/{token}', [AuthenticationController::class , 'activate_account']);

//----------------------------------------------------------------------------------------------------------------------
// Authenticated Routes
//----------------------------------------------------------------------------------------------------------------------
Route::middleware(['auth:api'])->group(function(){

    // Generic Request for Every Role
    Route::put('change-password' , [AuthenticationController::class, 'change_password']);


// Authorized Routes [ Garlito Super Admin ]
Route::middleware(['role:garlito_super_admin'])->group(function(){

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

});
//----------------------------------------------------------------------------------------------------------------------




});
//----------------------------------------------------------------------------------------------------------------------
