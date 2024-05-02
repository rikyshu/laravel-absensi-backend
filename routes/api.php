<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\PermissionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//login
Route::post('/login', [AuthController::class, 'login']);

//logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//company
Route::get('/company', [CompanyController::class, 'show'])->middleware('auth:sanctum');

//checkin
Route::post('/checkin', [AttendanceController::class, 'checkin'])->middleware('auth:sanctum');

//checkout
Route::post('/checkout', [AttendanceController::class, 'checkout'])->middleware('auth:sanctum');

//is checkedin
Route::get('/is-checkin', [AttendanceController::class, 'isCheckedin'])->middleware('auth:sanctum');

//update profile
Route::post('/update-profile', [AttendanceController::class, 'updateProfile'])->middleware('auth:sanctum');

//create permission
Route::apiResource('/api-permissions', PermissionController::class)->middleware('auth:sanctum');

//note
Route::apiResource('/api-notes', NoteController::class)->middleware('auth:sanctum');
