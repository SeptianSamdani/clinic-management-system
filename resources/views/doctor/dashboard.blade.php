<!-- ========================================== -->
<!-- resources/views/doctor/dashboard.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Dokter</h1>
            <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">Janji Temu Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['today_appointments'] }}</p>
                </div>
            </div>

            <div class="card">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">Total Pasien</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_patients'] }}</p>
                </div>
            </div>

            <div class="card">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">Pending Appointments</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_appointments'] }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Today's Appointments -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Jadwal Hari Ini</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($todayAppointments as $appointment)
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-gray-900">{{ $appointment->patient->user->name }}</p>
                                    <span class="text-sm text-gray-500">{{ $appointment->appointment_date->format('H:i') }}</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $appointment->reason }}</p>
                                <div class="mt-3">
                                    <a href="{{ route('doctor.appointments.show', $appointment->id) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                        Lihat Detail →
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">Tidak ada jadwal hari ini</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Medical Records -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Rekam Medis Terbaru</h2>
                    <a href="{{ route('doctor.medical-records.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentRecords as $record)
                            <div class="p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-gray-900">{{ $record->patient->user->name }}</p>
                                    <span class="text-sm text-gray-500">{{ $record->visit_date->format('d M Y') }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-1"><strong>Diagnosis:</strong> {{ Str::limit($record->diagnosis, 50) }}</p>
                                <a href="{{ route('doctor.medical-records.show', $record->id) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                    Lihat Detail →
                                </a>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">Belum ada rekam medis</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('doctor.medical-records.create') }}" class="card p-6 hover:shadow-lg transition cursor-pointer">
                <div class="flex items-center space-x-4">
                    <div class="bg-primary-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Tambah Rekam Medis</p>
                        <p class="text-sm text-gray-500">Buat rekam medis baru</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('doctor.appointments.index') }}" class="card p-6 hover:shadow-lg transition cursor-pointer">
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Lihat Jadwal</p>
                        <p class="text-sm text-gray-500">Kelola janji temu</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('doctor.medical-records.index') }}" class="card p-6 hover:shadow-lg transition cursor-pointer">
                <div class="flex items-center space-x-4">
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Rekam Medis</p>
                        <p class="text-sm text-gray-500">Lihat semua rekam medis</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection