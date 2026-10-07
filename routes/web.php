<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\Admin\BookingManagementController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboard;
use App\Http\Controllers\Patient\ProfileController;
use App\Http\Controllers\Patient\VisitHistoryController;
use App\Http\Controllers\Patient\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes - SiKlinik
|--------------------------------------------------------------------------
*/

// Root URL: welcome landing page or dashboard redirects depending on auth status
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('patient.dashboard');
    }
    return view('welcome');
});

// Authentication routes (Guest access)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated Logout route
Route::any('/logout', [LoginController::class, 'logout'])->name('logout');

// 1. ADMIN PANEL ROUTE GROUP (Protected by 'auth' & 'role:admin')
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    
    // CRUD Resources (using Route::resource)
    Route::resource('doctors', DoctorController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('visits', VisitController::class);

    // Bookings Management
    Route::get('/bookings', [BookingManagementController::class, 'index'])->name('admin.bookings.index');
    Route::patch('/bookings/{id}/status', [BookingManagementController::class, 'updateStatus'])->name('admin.bookings.update_status');
    Route::patch('/bookings/{id}/payment', [BookingManagementController::class, 'updatePaymentStatus'])->name('admin.bookings.update_payment');
});

// 2. PATIENT PORTAL ROUTE GROUP (Protected by 'auth' & 'role:patient')
Route::middleware(['auth', 'role:patient'])->prefix('patient')->group(function () {
    // Patient Dashboard
    Route::get('/dashboard', [PatientDashboard::class, 'index'])->name('patient.dashboard');
    
    // Patient Profile Update
    Route::get('/profile', [ProfileController::class, 'edit'])->name('patient.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('patient.profile.update');
    
    // Read-only visit logs
    Route::get('/visits', [VisitHistoryController::class, 'index'])->name('patient.visits.index');

    // Visit Bookings
    Route::get('/booking', [BookingController::class, 'index'])->name('patient.booking.index');
    Route::get('/booking/doctors', [BookingController::class, 'getDoctor'])->name('patient.booking.doctors');
    Route::post('/booking', [BookingController::class, 'store'])->name('patient.booking.store');
    Route::get('/booking/history', [BookingController::class, 'history'])->name('patient.booking.history');
    Route::patch('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('patient.booking.cancel');
    Route::get('/booking/{booking_code}/struk', [BookingController::class, 'struk'])->name('patient.booking.struk');
    Route::get('/booking/{booking_code}/download-pdf', [BookingController::class, 'downloadPdf'])->name('patient.booking.download_pdf');
});


