<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix("employee")->group(function () {
    Route::get('', [EmployeeController::class, 'list']);
    Route::post('', [EmployeeController::class, 'create']);
    Route::delete('{employee_id}', [EmployeeController::class, 'destroy']);
    Route::put('{employee_id}', [EmployeeController::class, 'update']);
});




