<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('specialties', SpecialtyController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
});
