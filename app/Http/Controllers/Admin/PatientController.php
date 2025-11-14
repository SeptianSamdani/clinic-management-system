<?php

// app/Http/Controllers/Admin/PatientController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // VULNERABLE: SQL Injection in search
        $search = $request->input('search', '');
        
        if ($search) {
            // Vulnerable query - direct string concatenation
            $patients = DB::select("
                SELECT patients.*, users.name, users.email 
                FROM patients 
                JOIN users ON patients.user_id = users.id 
                WHERE users.name LIKE '%{$search}%' 
                   OR patients.patient_number LIKE '%{$search}%'
                   OR patients.nik LIKE '%{$search}%'
                ORDER BY patients.created_at DESC
            ");
        } else {
            $patients = Patient::with('user')->latest()->get();
        }

        return view('admin.patients.index', compact('patients', 'search'));
    }

    public function show($id)
    {
        // VULNERABLE: SQL Injection in where clause
        $query = "SELECT patients.*, users.name, users.email, users.phone, users.address 
                  FROM patients 
                  JOIN users ON patients.user_id = users.id 
                  WHERE patients.id = {$id}";
        
        $patient = DB::select($query);
        
        if (empty($patient)) {
            abort(404);
        }
        
        $patient = $patient[0];
        $medicalRecords = DB::select("SELECT * FROM medical_records WHERE patient_id = {$id}");

        return view('admin.patients.show', compact('patient', 'medicalRecords'));
    }

    public function create()
    {
        return view('admin.patients.create');
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

        return redirect()->route('admin.patients.index')
            ->with('success', 'Pasien berhasil didaftarkan');
    }

    public function edit($id)
    {
        // VULNERABLE: SQL Injection
        $query = "SELECT patients.*, users.name, users.email, users.phone, users.address 
                  FROM patients 
                  JOIN users ON patients.user_id = users.id 
                  WHERE patients.id = {$id}";
        
        $patient = DB::select($query);
        
        if (empty($patient)) {
            abort(404);
        }
        
        $patient = $patient[0];
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'phone' => 'required|string',
            'address' => 'required|string',
            'nik' => 'required|string|size:16|unique:patients,nik,' . $id,
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'blood_type' => 'required|in:A,B,AB,O,Unknown',
        ]);

        $patient->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $patient->update([
            'nik' => $request->nik,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'blood_type' => $request->blood_type,
            'medical_history' => $request->medical_history,
            'allergies' => $request->allergies,
        ]);

        return redirect()->route('admin.patients.show', $id)
            ->with('success', 'Data pasien berhasil diupdate');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->user->delete(); // Will cascade delete patient record
        
        return redirect()->route('admin.patients.index')
            ->with('success', 'Pasien berhasil dihapus');
    }
}