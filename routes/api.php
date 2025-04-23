<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\SpecialtyController;
use App\Http\Controllers\Api\RoomController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Public routes
Route::get('/specialties/{specialty}/doctors', [SpecialtyController::class, 'doctors']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Patient routes
    Route::middleware('patient')->group(function () {
        Route::apiResource('appointments', AppointmentController::class);
    });

    // Doctor routes
    Route::middleware('doctor')->group(function () {
        Route::apiResource('schedules', ScheduleController::class);
        Route::get('appointments', [AppointmentController::class, 'doctorAppointments']);
    });

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::apiResource('doctors', DoctorController::class);
        Route::apiResource('specialties', SpecialtyController::class);
        Route::apiResource('rooms', RoomController::class);
    });
});
