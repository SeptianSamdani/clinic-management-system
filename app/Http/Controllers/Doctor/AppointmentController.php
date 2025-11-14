<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $doctor = auth()->user()->doctor;
        $status = $request->input('status', 'all');
        
        $query = Appointment::where('doctor_id', $doctor->id)
            ->with('patient.user');
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $appointments = $query->orderBy('appointment_date', 'desc')->get();
        
        return view('doctor.appointments.index', compact('appointments', 'status'));
    }

    public function show($id)
    {
        // VULNERABLE: SQL Injection
        $query = "
            SELECT appointments.*, 
                   patients.patient_number, patients.nik,
                   users.name as patient_name, users.email, users.phone
            FROM appointments
            JOIN patients ON appointments.patient_id = patients.id
            JOIN users ON patients.user_id = users.id
            WHERE appointments.id = {$id}
        ";
        
        $appointment = DB::select($query);
        
        if (empty($appointment)) {
            abort(404);
        }
        
        $appointment = $appointment[0];
        
        return view('doctor.appointments.show', compact('appointment'));
    }

    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }
        
        $appointment->update(['status' => 'confirmed']);
        
        return redirect()->route('doctor.appointments.show', $id)
            ->with('success', 'Appointment dikonfirmasi');
    }

    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);
        
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }
        
        $appointment->update(['status' => 'completed']);
        
        return redirect()->route('doctor.appointments.show', $id)
            ->with('success', 'Appointment diselesaikan');
    }
}