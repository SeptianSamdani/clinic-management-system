<?php

// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // VULNERABLE: Reflected XSS in welcome message
        $adminName = $request->input('name', auth()->user()->name);
        
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_records' => MedicalRecord::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
        ];

        $recentAppointments = Appointment::with(['patient.user', 'doctor.user'])
            ->latest()
            ->limit(5)
            ->get();

        // Recent patients with VULNERABLE query
        $search = $request->input('patient_search', '');
        if ($search) {
            $recentPatients = DB::select("
                SELECT patients.*, users.name, users.email 
                FROM patients 
                JOIN users ON patients.user_id = users.id 
                WHERE users.name LIKE '%{$search}%'
                ORDER BY patients.created_at DESC 
                LIMIT 5
            ");
        } else {
            $recentPatients = Patient::with('user')->latest()->limit(5)->get();
        }

        return view('admin.dashboard', compact('stats', 'recentAppointments', 'recentPatients', 'adminName', 'search'));
    }
}