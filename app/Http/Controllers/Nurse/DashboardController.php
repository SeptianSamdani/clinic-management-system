<?php

namespace App\Http\Controllers\Nurse;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'today_appointments' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
            'pending_queue' => Appointment::where('status', 'pending')->whereDate('appointment_date', Carbon::today())->count(),
        ];

        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())
            ->with(['patient.user', 'doctor.user'])
            ->orderBy('appointment_date')
            ->get();

        $recentPatients = Patient::with('user')->latest()->limit(5)->get();

        return view('nurse.dashboard', compact('stats', 'todayAppointments', 'recentPatients'));
    }
}