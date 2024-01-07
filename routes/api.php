<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FindDuplicatesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AttendanceController::class)->group(function (){

    Route::post('/v1/uploadAttendance','uploadAttendance');

    Route::get('/v1/employee-attendance','getEmployeeAttendanceInfo');

});

Route::post('/v1/find-duplicates', [FindDuplicatesController::class, 'findDuplicates']);
