<?php

// app/Http/Controllers/Doctor/DashboardController.php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = auth()->user()->doctor;

        $stats = [
            'today_appointments' => Appointment::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', Carbon::today())
                ->count(),
            'total_patients' => MedicalRecord::where('doctor_id', $doctor->id)
                ->distinct('patient_id')
                ->count(),
            'pending_appointments' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'pending')
                ->count(),
        ];

        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', Carbon::today())
            ->with('patient.user')
            ->get();

        $recentRecords = MedicalRecord::where('doctor_id', $doctor->id)
            ->with('patient.user')
            ->latest('visit_date')
            ->limit(5)
            ->get();

        return view('doctor.dashboard', compact('stats', 'todayAppointments', 'recentRecords'));
    }
}