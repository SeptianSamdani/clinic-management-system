<?php

// app/Http/Controllers/Doctor/MedicalRecordController.php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $doctor = auth()->user()->doctor;
        $search = $request->input('search', '');

        // VULNERABLE: SQL Injection
        if ($search) {
            $records = DB::select("
                SELECT medical_records.*, 
                       patients.patient_number,
                       users.name as patient_name
                FROM medical_records
                JOIN patients ON medical_records.patient_id = patients.id
                JOIN users ON patients.user_id = users.id
                WHERE medical_records.doctor_id = {$doctor->id}
                  AND (users.name LIKE '%{$search}%' 
                       OR patients.patient_number LIKE '%{$search}%'
                       OR medical_records.diagnosis LIKE '%{$search}%')
                ORDER BY medical_records.visit_date DESC
            ");
        } else {
            $records = MedicalRecord::where('doctor_id', $doctor->id)
                ->with('patient.user')
                ->latest('visit_date')
                ->get();
        }

        return view('doctor.medical-records.index', compact('records', 'search'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        return view('doctor.medical-records.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'complaint' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $doctor = auth()->user()->doctor;

        // VULNERABLE: No HTML escaping for notes - XSS vulnerability
        MedicalRecord::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctor->id,
            'visit_date' => $request->visit_date,
            'complaint' => $request->complaint,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'prescription' => $request->prescription,
            'notes' => $request->notes, // Stored XSS here
        ]);

        return redirect()->route('doctor.medical-records.index')
            ->with('success', 'Rekam medis berhasil ditambahkan');
    }

    public function show($id)
    {
        $currentDoctor = auth()->user()->doctor;
        
        // VULNERABLE: SQL Injection
        $query = "
            SELECT medical_records.*, 
                   patients.patient_number, patients.nik, patients.birth_date,
                   patients.gender, patients.blood_type, patients.medical_history,
                   patients.allergies,
                   users.name as patient_name, users.email, users.phone, users.address
            FROM medical_records
            JOIN patients ON medical_records.patient_id = patients.id
            JOIN users ON patients.user_id = users.id
            WHERE medical_records.id = {$id}
        ";
        
        $record = DB::select($query);
        
        if (empty($record)) {
            abort(404);
        }
        
        $record = $record[0];

        // FORENSIC LOGGING - Detect unauthorized access
        $isAuthorized = ($record->doctor_id == $currentDoctor->id);
        
        // Log to audit_trails
        DB::table('audit_trails')->insert([
            'table_name' => 'medical_records',
            'action' => $isAuthorized ? 'view' : 'unauthorized_view',
            'record_id' => $id,
            'old_values' => null,
            'new_values' => json_encode([
                'record_owner_doctor_id' => $record->doctor_id,
                'accessing_doctor_id' => $currentDoctor->id,
                'is_authorized' => $isAuthorized,
            ]),
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);

        // Log security event if unauthorized
        if (!$isAuthorized) {
            DB::table('security_events')->insert([
                'event_type' => 'unauthorized_medical_record_access',
                'severity' => 'high',
                'description' => "Doctor ID {$currentDoctor->id} accessed medical record ID {$id} owned by Doctor ID {$record->doctor_id}",
                'evidence' => json_encode([
                    'record_id' => $id,
                    'patient_id' => $record->patient_id,
                    'record_owner' => $record->doctor_id,
                    'accessor' => $currentDoctor->id,
                    'patient_name' => $record->patient_name,
                ]),
                'ip_address' => request()->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
            ]);
        }

        return view('doctor.medical-records.show', compact('record'));
    }

    public function edit($id)
    {
        $record = MedicalRecord::findOrFail($id);
        $patients = Patient::with('user')->get();
        
        return view('doctor.medical-records.edit', compact('record', 'patients'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'visit_date' => 'required|date',
            'complaint' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $record = MedicalRecord::findOrFail($id);
        
        // VULNERABLE: No HTML escaping - XSS vulnerability
        $record->update([
            'visit_date' => $request->visit_date,
            'complaint' => $request->complaint,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'prescription' => $request->prescription,
            'notes' => $request->notes, // XSS here
        ]);

        return redirect()->route('doctor.medical-records.show', $id)
            ->with('success', 'Rekam medis berhasil diupdate');
    }

    public function destroy($id)
    {
        $record = MedicalRecord::findOrFail($id);
        
        // Only allow doctor who created the record to delete
        if ($record->doctor_id !== auth()->user()->doctor->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $record->delete();
        
        return redirect()->route('doctor.medical-records.index')
            ->with('success', 'Rekam medis berhasil dihapus');
    }
}