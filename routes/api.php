<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix("employee")->group(function () {
    Route::get('', [EmployeeController::class, 'list']);
    Route::post('', [EmployeeController::class, 'create']);
    Route::delete('{employee_id}', [EmployeeController::class, 'destroy']);
    Route::put('{employee_id}', [EmployeeController::class, 'update']);
});


