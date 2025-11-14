<!-- ========================================== -->
<!-- resources/views/admin/dashboard.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <!-- VULNERABLE: Reflected XSS - adminName dari query parameter -->
            <h1 class="text-3xl font-bold text-gray-900">
                Selamat Datang, {!! $adminName !!}
            </h1>
            <p class="text-gray-600 mt-1">Dashboard Administrator</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Patients -->
            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Pasien</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_patients'] }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Doctors -->
            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Dokter</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_doctors'] }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Records -->
            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Rekam Medis</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_records'] }}</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Appointments -->
            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Janji Temu Pending</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_appointments'] }}</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Recent Patients with VULNERABLE search -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Pasien Terbaru</h2>
                        <a href="{{ route('admin.patients.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                            Lihat Semua →
                        </a>
                    </div>
                    
                    <!-- VULNERABLE SEARCH - SQL Injection -->
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="mt-3">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="patient_search" 
                                value="{{ $search ?? '' }}"
                                placeholder="Cari pasien..." 
                                class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm"
                            >
                            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentPatients as $patient)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ substr($patient->name ?? $patient->user->name ?? 'P', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $patient->name ?? $patient->user->name ?? 'Unknown' }}</p>
                                        <p class="text-sm text-gray-500">{{ $patient->patient_number ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.patients.show', $patient->id) }}" class="text-primary-600 hover:text-primary-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-4">Tidak ada data pasien</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Janji Temu Terbaru</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentAppointments as $appointment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $appointment->patient->user->name }}</p>
                                    <p class="text-sm text-gray-500">Dr. {{ $appointment->doctor->user->name }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $appointment->appointment_date->format('d M Y, H:i') }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($appointment->status === 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-4">Tidak ada janji temu</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection