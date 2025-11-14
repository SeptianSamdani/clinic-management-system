<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\User;
use App\Observers\AuditObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Audit Observers for forensic logging
        Patient::observe(AuditObserver::class);
        Doctor::observe(AuditObserver::class);
        MedicalRecord::observe(AuditObserver::class);
        Appointment::observe(AuditObserver::class);
        User::observe(AuditObserver::class);
        
        // Custom Blade Directives for Roles (optional, makes blade cleaner)
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });
        
        Blade::if('doctor', function () {
            return auth()->check() && auth()->user()->isDoctor();
        });
        
        Blade::if('patient', function () {
            return auth()->check() && auth()->user()->isPatient();
        });
        
        // VULNERABLE: Disable query escaping for demonstration (Don't do this in production!)
        // This makes SQL injection easier to demonstrate
        // DB::statement("SET sql_mode=''");
    }
}