<!-- ========================================== -->
<!-- resources/views/patient/dashboard.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Pasien</h1>
            <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
        </div>

        <!-- Patient Info Card -->
        <div class="card mb-6">
            <div class="p-6">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-primary-600 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3 text-sm">
                            <div>
                                <p class="text-gray-500">No. Pasien</p>
                                <p class="font-semibold">{{ $patient->patient_number }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">NIK</p>
                                <p class="font-semibold">{{ $patient->nik }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Golongan Darah</p>
                                <p class="font-semibold">{{ $patient->blood_type }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Jenis Kelamin</p>
                                <p class="font-semibold">{{ $patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Upcoming Appointments -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Janji Temu Mendatang</h2>
                    <a href="{{ route('patient.appointments.create') }}" class="btn-primary text-sm py-2 px-4">
                        Buat Baru
                    </a>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($upcomingAppointments as $appointment)
                            <div class="p-4 border-l-4 border-primary-500 bg-primary-50 rounded-r-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-semibold text-gray-900">Dr. {{ $appointment->doctor->user->name }}</p>
                                    <span class="text-sm px-2 py-1 bg-blue-100 text-blue-800 rounded-full font-medium">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">{{ $appointment->doctor->specialization }}</p>
                                <div class="flex items-center text-sm text-gray-500 space-x-4 mt-2">
                                    <span>📅 {{ $appointment->appointment_date->format('d M Y') }}</span>
                                    <span>🕐 {{ $appointment->appointment_date->format('H:i') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500">Tidak ada janji temu mendatang</p>
                                <a href="{{ route('patient.appointments.create') }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm mt-2 inline-block">
                                    Buat Janji Temu Sekarang →
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Medical Records -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Riwayat Rekam Medis</h2>
                    <a href="{{ route('patient.medical-records.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($medicalRecords as $record)
                            <div class="p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-gray-900">Dr. {{ $record->doctor->user->name }}</p>
                                    <span class="text-sm text-gray-500">{{ $record->visit_date->format('d M Y') }}</span>
                                </div>
                                <p class="text-sm text-gray-600"><strong>Diagnosis:</strong> {{ Str::limit($record->diagnosis, 60) }}</p>
                                <a href="{{ route('patient.medical-records.show', $record->id) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium mt-2 inline-block">
                                    Lihat Detail →
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500">Belum ada rekam medis</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection