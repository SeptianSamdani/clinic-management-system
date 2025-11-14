<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = auth()->user()->patient;
        
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor.user')
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        return view('patient.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();
        return view('patient.appointments.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:now',
            'reason' => 'required|string',
        ]);

        $patient = auth()->user()->patient;

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'status' => 'pending',
            'reason' => $request->reason,
        ]);

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Janji temu berhasil dibuat');
    }

    public function show($id)
    {
        $patient = auth()->user()->patient;
        
        $appointment = Appointment::where('patient_id', $patient->id)
            ->where('id', $id)
            ->with('doctor.user')
            ->firstOrFail();
        
        return view('patient.appointments.show', compact('appointment'));
    }

    public function cancel($id)
    {
        $patient = auth()->user()->patient;
        
        $appointment = Appointment::where('patient_id', $patient->id)
            ->where('id', $id)
            ->firstOrFail();
        
        if ($appointment->status === 'completed') {
            return back()->with('error', 'Tidak dapat membatalkan appointment yang sudah selesai');
        }
        
        $appointment->update(['status' => 'cancelled']);
        
        return redirect()->route('patient.appointments.index')
            ->with('success', 'Janji temu berhasil dibatalkan');
    }
}