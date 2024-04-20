<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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
    'middleware' => 'api'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [UserController::class, 'signup']);
    Route::post('logout', [AuthController::class, 'logout']);
});
