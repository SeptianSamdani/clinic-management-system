<?php

// ==========================================
// app/Http/Controllers/Admin/DoctorController.php
// ==========================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        
        if ($search) {
            // VULNERABLE: SQL Injection
            $doctors = DB::select("
                SELECT doctors.*, users.name, users.email, users.phone
                FROM doctors 
                JOIN users ON doctors.user_id = users.id 
                WHERE users.name LIKE '%{$search}%' 
                   OR doctors.license_number LIKE '%{$search}%'
                   OR doctors.specialization LIKE '%{$search}%'
                ORDER BY doctors.created_at DESC
            ");
        } else {
            $doctors = Doctor::with('user')->latest()->get();
        }

        return view('admin.doctors.index', compact('doctors', 'search'));
    }

    public function show($id)
    {
        // VULNERABLE: SQL Injection
        $query = "SELECT doctors.*, users.name, users.email, users.phone, users.address 
                  FROM doctors 
                  JOIN users ON doctors.user_id = users.id 
                  WHERE doctors.id = {$id}";
        
        $doctor = DB::select($query);
        
        if (empty($doctor)) {
            abort(404);
        }
        
        $doctor = $doctor[0];
        
        // Get doctor's statistics
        $stats = [
            'total_patients' => DB::scalar("SELECT COUNT(DISTINCT patient_id) FROM medical_records WHERE doctor_id = {$id}"),
            'total_records' => DB::scalar("SELECT COUNT(*) FROM medical_records WHERE doctor_id = {$id}"),
            'total_appointments' => DB::scalar("SELECT COUNT(*) FROM appointments WHERE doctor_id = {$id}"),
        ];

        return view('admin.doctors.show', compact('doctor', 'stats'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'address' => 'required|string',
            'license_number' => 'required|string|unique:doctors',
            'specialization' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'bio' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'license_number' => $request->license_number,
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'bio' => $request->bio,
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Dokter berhasil ditambahkan');
    }

    public function edit($id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'phone' => 'required|string',
            'address' => 'required|string',
            'license_number' => 'required|string|unique:doctors,license_number,' . $id,
            'specialization' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'bio' => 'nullable|string',
        ]);

        $doctor->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $doctor->update([
            'license_number' => $request->license_number,
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'bio' => $request->bio,
        ]);

        return redirect()->route('admin.doctors.show', $id)
            ->with('success', 'Data dokter berhasil diupdate');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->user->delete(); // Will cascade delete doctor record
        
        return redirect()->route('admin.doctors.index')
            ->with('success', 'Dokter berhasil dihapus');
    }
}
