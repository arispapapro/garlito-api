<?php

// Utilities
use Illuminate\Support\Facades\Route;

// Controllers Imported
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthenticationWebController;
use App\Http\Controllers\DashboardWebController;
use App\Http\Controllers\UserWebController;
use App\Http\Controllers\SettingsWebController;
use App\Http\Controllers\RoleWebController;
use App\Http\Controllers\AccessTokenWebController;
use App\Http\Controllers\ClientWebController;
use App\Http\Controllers\ErrorWebController;

// Web Routing
Route::get('/', [AuthenticationWebController::class , 'login_page']);

// Web Routing
Route::get('login', [AuthenticationWebController::class , 'login_page'])->name('login');
Route::get('auth/login', [AuthenticationWebController::class , 'login_page'])->name('login-page-web');
Route::post('login', [AuthenticationWebController::class , 'login'])->name('login-web');

// Errors
Route::get('403', [ErrorWebController::class , 'forbidden_page'])->name('forbidden-page');

Route::middleware(['auth', 'role-web:garlito_super_admin'])->group(function(){

    // Authentication
    Route::post('logout', [AuthenticationWebController::class , 'logout'])->name('logout-web');

    // Dashboard
    Route::get('dashboard', [DashboardWebController::class , 'dashboard_page'])->name('dashboard-page-web');

    // Users
    Route::post('user', [UserWebController::class , 'add_user'])->name('add-user-web');
    Route::put('user/{id}', [UserWebController::class , 'edit_user'])->name('edit-user-web');
    Route::get('user/{id}', [UserWebController::class , 'single_user_page'])->name('single-user-page-web');
    Route::post('user/{id}/delete', [UserWebController::class , 'delete_user'])->name('delete-user-web');
    Route::get('users', [UserWebController::class , 'users_page'])->name('users-page-web');

    // Access Tokens
    Route::get('access-tokens', [AccessTokenWebController::class , 'access_tokens_page'])->name('access-tokens-page-web');

    // Clients
    Route::get('clients', [ClientWebController::class , 'clients_page'])->name('clients-page-web');

    // Roles
    Route::get('roles', [RoleWebController::class , 'roles_page'])->name('roles-page-web');

    // Settings
    Route::get('settings', [SettingsWebController::class , 'settings_page'])->name('settings-page-web');




});
