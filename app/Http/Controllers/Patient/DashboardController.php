<?php

// app/Http/Controllers/Patient/DashboardController.php
namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $patient = auth()->user()->patient;

        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->with('doctor.user')
            ->orderBy('appointment_date')
            ->get();

        $medicalRecords = MedicalRecord::where('patient_id', $patient->id)
            ->with('doctor.user')
            ->latest('visit_date')
            ->limit(5)
            ->get();

        return view('patient.dashboard', compact('upcomingAppointments', 'medicalRecords', 'patient'));
    }

    public function medicalRecords()
    {
        $patient = auth()->user()->patient;
        
        $medicalRecords = MedicalRecord::where('patient_id', $patient->id)
            ->with('doctor.user')
            ->latest('visit_date')
            ->paginate(10);
        
        return view('patient.medical-records.index', compact('medicalRecords'));
    }

    // ============================================
    // VULNERABLE: No ownership check (IDOR)
    // Patient bisa akses medical record patient lain
    // ============================================
    public function showMedicalRecord($id)
    {
        // VULNERABLE: Removed ownership check
        $record = MedicalRecord::where('id', $id)  // ❌ No patient_id check
            ->with('doctor.user')
            ->firstOrFail();
        
        return view('patient.medical-records.show', compact('record'));
    }

    public function profile()
    {
        $patient = auth()->user()->patient;
        return view('patient.profile', compact('patient'));
    }
}