<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\DoctorController as FrontendDoctorController;
use App\Http\Controllers\Frontend\SpecialtyController as FrontendSpecialtyController;
use App\Http\Controllers\Frontend\AppointmentController as FrontendAppointmentController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\AppointmentHistoryController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\AboutController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/doctors', [FrontendDoctorController::class, 'index'])->name('doctors');
Route::get('/specialties', [FrontendSpecialtyController::class, 'index'])->name('specialties');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Frontend Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Frontend Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Appointment routes
    Route::get('/appointment', [FrontendAppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment', [FrontendAppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointments/history', [AppointmentHistoryController::class, 'index'])->name('appointments.history');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest admin routes
    Route::middleware('guest')->group(function () {
        Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
    });

    // Protected admin routes - cho phép cả admin và bác sĩ truy cập
    Route::middleware(['auth', 'role:admin,doctor'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

        // Resource routes
        Route::resource('users', UserController::class);
        Route::resource('specialties', SpecialtyController::class);
        Route::resource('doctors', DoctorController::class);
        Route::resource('patients', PatientController::class);
        Route::resource('appointments', AppointmentController::class);
        Route::resource('schedules', ScheduleController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('posts', PostController::class);
        Route::resource('categories', CategoryController::class);
    });
});

// Default auth routes (if needed)
require __DIR__.'/auth.php';

