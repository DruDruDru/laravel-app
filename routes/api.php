<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SubdivisionController;

// Маршруты employee
Route::group([
    'prefix' => 'employee',
    'controller' => EmployeeController::class,
    'middleware' => ['auth', 'role:moderator,admin']
], function () {
    Route::get('', 'list');
    Route::post('', 'create');
    Route::delete('{employee_id}', 'destroy');
    Route::put('{employee_id}', 'update');
});


// Маршруты position
Route::group([
    'prefix' => 'position',
    'controller' => PositionController::class,
    'middleware' => ['auth', 'role:moderator,admin']
], function () {
    Route::get('', 'list');
    Route::post('', 'create');
    Route::delete('{position_id}', 'destroy');
    Route::put('{position_id}', 'update');
});


// Маршруты subdivision
Route::group([
    'prefix' => 'subdivision',
    'controller' => SubdivisionController::class,
    'middleware' => ['auth', 'role:moderator,admin']
], function () {
    Route::get('', 'list');
});


// Маршруты auth
Route::group([
    'middleware' => 'api'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [UserController::class, 'signup'])
        ->middleware(['auth', 'role:admin']);
    Route::post('logout', [AuthController::class, 'logout']);
});
