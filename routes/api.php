<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SubdivisionController;

Route::group([
    'prefix' => 'employee',
    'controller' => EmployeeController::class,
    'middleware' => ['jwt.auth', 'role:moderator,admin']
], function () {
    Route::get('', 'list');
    Route::post('', 'create');
    Route::delete('{employee_id}', 'destroy');
    Route::put('{employee_id}', 'update');
});

Route::group([
    'prefix' => 'position',
    'controller' => PositionController::class,
    'middleware' => ['jwt.auth', 'role:moderator,admin']
], function () {
    Route::get('', 'list');
});

Route::group([
    'prefix' => 'subdivision',
    'controller' => SubdivisionController::class,
    'middleware' => ['jwt.auth', 'role:moderator,admin']
], function () {
    Route::get('', 'list');
});

Route::group([
    'middleware' => 'api'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [UserController::class, 'signup'])
        ->middleware('role:admin');
    Route::post('logout', [AuthController::class, 'logout']);
});
