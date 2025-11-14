<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\MedicalRecordController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\ForensicController;

/*
|--------------------------------------------------------------------------
| Web Routes - VULNERABLE VERSION (For Forensic Training)
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes (VULNERABLE - No CSRF, SQL Injection possible)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Menggunakan auth middleware)
Route::middleware(['auth'])->group(function () {
    
    // ===========================================
    // ADMIN ROUTES
    // ===========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Patient Management (VULNERABLE to SQL Injection)
        Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
        Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
        Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
        Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
        Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
        Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
        Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
        
        // Doctor Management
        Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
        Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
        Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
        Route::get('/doctors/{id}', [DoctorController::class, 'show'])->name('doctors.show');
        Route::get('/doctors/{id}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
        Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('doctors.update');
        Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
        
        // Reports (VULNERABLE to SQL Injection)
        Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    });
    
    // ===========================================
    // DOCTOR ROUTES
    // ===========================================
    Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
        
        // Medical Records (VULNERABLE to SQL Injection & XSS)
        Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
        Route::get('/medical-records/create', [MedicalRecordController::class, 'create'])->name('medical-records.create');
        Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
        Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
        Route::get('/medical-records/{id}/edit', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
        Route::put('/medical-records/{id}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
        Route::delete('/medical-records/{id}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');
        
        // Appointments
        Route::get('/appointments', [PatientAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{id}', [PatientAppointmentController::class, 'show'])->name('appointments.show');
        Route::put('/appointments/{id}/confirm', [PatientAppointmentController::class, 'confirm'])->name('appointments.confirm');
        Route::put('/appointments/{id}/complete', [PatientAppointmentController::class, 'complete'])->name('appointments.complete');
    });
    
    // ===========================================
    // PATIENT ROUTES
    // ===========================================
    Route::middleware(['role:patient'])->prefix('patient')->name('patient.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
        
        // My Medical Records (View Only)
        Route::get('/medical-records', [PatientDashboardController::class, 'medicalRecords'])->name('medical-records.index');
        Route::get('/medical-records/{id}', [PatientDashboardController::class, 'showMedicalRecord'])->name('medical-records.show');
        
        // Appointments
        Route::get('/appointments', [PatientAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/create', [PatientAppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [PatientAppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/appointments/{id}', [PatientAppointmentController::class, 'show'])->name('appointments.show');
        Route::put('/appointments/{id}/cancel', [PatientAppointmentController::class, 'cancel'])->name('appointments.cancel');
        
        // Profile
        Route::get('/profile', [PatientDashboardController::class, 'profile'])->name('profile');
    });
});

// ===========================================
// FORENSIC ROUTES (For Investigation)
// ===========================================
Route::prefix('forensic')->name('forensic.')->group(function () {
    Route::get('/login', [ForensicController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ForensicController::class, 'authenticate'])->name('authenticate');
    
    Route::middleware(['forensic.auth'])->group(function () {
        Route::get('/dashboard', [ForensicController::class, 'index'])->name('dashboard');
        Route::get('/request-logs', [ForensicController::class, 'requestLogs'])->name('request-logs');
        Route::get('/sql-logs', [ForensicController::class, 'sqlLogs'])->name('sql-logs');
        Route::get('/audit-trails', [ForensicController::class, 'auditTrails'])->name('audit-trails');
        Route::get('/security-events', [ForensicController::class, 'securityEvents'])->name('security-events');
        Route::get('/export', [ForensicController::class, 'export'])->name('export');
        Route::post('/logout', [ForensicController::class, 'logout'])->name('logout');
    });
});