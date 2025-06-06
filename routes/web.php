<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Frontend\PatientAuthController;
use App\Http\Controllers\Frontend\AppointmentHistoryController;
use App\Http\Controllers\Frontend\DoctorController as FrontendDoctorController;
use App\Http\Controllers\Frontend\SpecialtyController as FrontendSpecialtyController;
use App\Http\Controllers\Frontend\AppointmentController as FrontendAppointmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('patient')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/doctors', [FrontendDoctorController::class, 'index'])->name('doctors');
Route::get('/specialties', [FrontendSpecialtyController::class, 'index'])->name('specialties');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/specialty/{id}', [FrontendSpecialtyController::class, 'show'])->name('specialties.show');
Route::get('/doctors/{id}', [FrontendDoctorController::class, 'show'])->name('doctors.show');

// Appointment Routes
Route::middleware(['auth:patient'])->group(function () {
    Route::get('/appointments', [FrontendAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [FrontendAppointmentController::class, 'create'])->name('appointments.create');
    Route::get('/appointments/history', [AppointmentHistoryController::class, 'index'])->name('appointments.history');
    Route::post('/appointments', [FrontendAppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [FrontendAppointmentController::class, 'show'])->name('appointments.show');
    Route::delete('/appointments/{appointment}', [FrontendAppointmentController::class, 'destroy'])->name('appointments.destroy');
});

// AJAX routes for appointments
Route::get('/frontend/specialties/{specialty}/doctors', [FrontendAppointmentController::class, 'getDoctorsBySpecialty'])->name('frontend.specialties.doctors');
Route::get('/frontend/doctors/{doctor}/available-slots', [FrontendAppointmentController::class, 'getAvailableSlots'])->name('frontend.doctors.available-slots');

// Patient Auth Routes
Route::middleware('guest:patient')->group(function () {
    Route::get('/login', [PatientAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PatientAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [PatientAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [PatientAuthController::class, 'register'])->name('register.post');
});

// Protected Patient Routes
Route::middleware('auth:patient')->group(function () {
    Route::post('/logout', [PatientAuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [PatientAuthController::class, 'profile'])->name('profile.edit');
    Route::patch('/profile', [PatientAuthController::class, 'updateProfile'])->name('profile.update');

    // Appointment routes
    Route::get('/appointment', [FrontendAppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment', [FrontendAppointmentController::class, 'store'])->name('appointment.store');
});

// Frontend routes
Route::prefix('frontend')->name('frontend.')->group(function () {
    // Lấy danh sách phòng khám theo chuyên khoa
    Route::get('/specialties/{specialty}/rooms', [App\Http\Controllers\Frontend\SpecialtyController::class, 'getRooms'])
        ->name('specialties.rooms');
    
    // Lấy danh sách bác sĩ theo phòng khám
    Route::get('/rooms/{room}/doctors', [App\Http\Controllers\Frontend\RoomController::class, 'getDoctors'])
        ->name('rooms.doctors');

    // Lấy thông tin chi tiết bác sĩ
    Route::get('/doctors/{doctor}', [App\Http\Controllers\Frontend\DoctorController::class, 'getDoctorInfo'])
        ->name('doctors.info');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Routes
    Route::middleware('guest:web')->group(function () {
        Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post');
    });

    // Protected Admin Routes - Cho cả admin và doctor
    Route::middleware(['auth:web', 'role:admin,doctor'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
        
        // Routes cho bác sĩ xem lịch khám của mình
        Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('my-appointments');
        Route::resource('appointments', AppointmentController::class);
    });

    // Routes chỉ dành cho admin
    Route::middleware(['auth:web', 'admin.only'])->group(function () {
        // Resource Routes
        Route::resource('specialties', SpecialtyController::class);
        Route::resource('doctors', DoctorController::class);
        Route::resource('patients', PatientController::class);
        Route::resource('schedules', ScheduleController::class);
        Route::resource('posts', PostController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('rooms', \App\Http\Controllers\Admin\RoomController::class);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });
});


