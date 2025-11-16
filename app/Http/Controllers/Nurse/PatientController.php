<?php

namespace App\Http\Controllers\Nurse;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')->latest()->paginate(20);
        return view('nurse.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('nurse.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'address' => 'required|string',
            'nik' => 'required|string|size:16|unique:patients',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'blood_type' => 'required|in:A,B,AB,O,Unknown',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $patientNumber = 'P' . date('Y') . str_pad(Patient::count() + 1, 5, '0', STR_PAD_LEFT);

        Patient::create([
            'user_id' => $user->id,
            'patient_number' => $patientNumber,
            'nik' => $request->nik,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'blood_type' => $request->blood_type,
            'medical_history' => $request->medical_history,
            'allergies' => $request->allergies,
        ]);

        return redirect()->route('nurse.patients.index')
            ->with('success', 'Pasien berhasil didaftarkan');
    }

    public function show($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        $appointments = $patient->appointments()->with('doctor.user')->latest()->get();
        
        return view('nurse.patients.show', compact('patient', 'appointments'));
    }

    public function viewMedicalRecords($patientId)
    {
        // VULNERABLE: Nurse seharusnya tidak bisa akses medical records!
        // No authorization check
        
        $patient = Patient::with('user')->findOrFail($patientId);
        
        // VULNERABLE SQL INJECTION 
        $query = "
            SELECT medical_records.*, 
                   doctors.id as doctor_id,
                   doctor_users.name as doctor_name,
                   doctors.specialization
            FROM medical_records
            JOIN doctors ON medical_records.doctor_id = doctors.id
            JOIN users as doctor_users ON doctors.user_id = doctor_users.id
            WHERE medical_records.patient_id = {$patientId}
            ORDER BY medical_records.visit_date DESC
        ";
        
        $medicalRecords = DB::select($query);
        
        // LOG UNAUTHORIZED ACCESS
        $nurse = auth()->user()->nurse;
        
        DB::table('audit_trails')->insert([
            'table_name' => 'medical_records',
            'action' => 'unauthorized_nurse_access',
            'record_id' => $patientId,
            'old_values' => null,
            'new_values' => json_encode([
                'nurse_id' => $nurse->id,
                'patient_id' => $patientId,
                'records_count' => count($medicalRecords),
            ]),
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
        
        DB::table('security_events')->insert([
            'event_type' => 'nurse_unauthorized_medical_access',
            'severity' => 'critical',
            'description' => "Nurse accessed medical records (patient #{$patientId})",
            'evidence' => json_encode([
                'nurse_id' => $nurse->id,
                'patient_id' => $patientId,
                'records_viewed' => count($medicalRecords),
            ]),
            'ip_address' => request()->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
        ]);

        return view('nurse.patients.medical-records', compact('patient', 'medicalRecords'));
    }
}