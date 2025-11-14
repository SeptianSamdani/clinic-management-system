<!-- ========================================== -->
<!-- resources/views/admin/patients/show.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Detail Pasien')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <a href="{{ route('admin.patients.index') }}" class="text-primary-600 hover:text-primary-700 inline-flex items-center text-sm mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Pasien</h1>
                    <p class="text-gray-600 mt-1">Informasi lengkap pasien</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Data
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Patient Info Card -->
            <div class="lg:col-span-1">
                <div class="card">
                    <div class="p-6">
                        <div class="text-center">
                            <div class="mx-auto h-24 w-24 rounded-full bg-primary-600 flex items-center justify-center text-white text-3xl font-bold mb-4">
                                {{ substr($patient->name, 0, 1) }}
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $patient->name }}</h2>
                            <p class="text-gray-500 mt-1">{{ $patient->email }}</p>
                            <div class="mt-4 flex items-center justify-center space-x-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $patient->patient_number }}
                                </span>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ $patient->blood_type }}
                                </span>
                            </div>
                        </div>

                        <hr class="my-6">

                        <div class="space-y-4 text-sm">
                            <div>
                                <p class="text-gray-500 font-medium">NIK</p>
                                <p class="text-gray-900 font-mono">{{ $patient->nik }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-medium">Jenis Kelamin</p>
                                <p class="text-gray-900">{{ $patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-medium">Tanggal Lahir</p>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($patient->birth_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-medium">Nomor Telepon</p>
                                <p class="text-gray-900">{{ $patient->phone }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-medium">Alamat</p>
                                <p class="text-gray-900">{{ $patient->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Info & Records -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Medical Information -->
                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Medis</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Riwayat Penyakit</p>
                            <p class="text-gray-900">{{ $patient->medical_history ?? 'Tidak ada riwayat penyakit' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Alergi</p>
                            <p class="text-gray-900">{{ $patient->allergies ?? 'Tidak ada alergi' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Medical Records -->
                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Riwayat Rekam Medis</h3>
                    </div>
                    <div class="p-6">
                        @if(count($medicalRecords) > 0)
                            <div class="space-y-4">
                                @foreach($medicalRecords as $record)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-primary-300 transition">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($record->visit_date)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900 mb-1">
                                            <strong>Diagnosis:</strong> {{ $record->diagnosis }}
                                        </p>
                                        <p class="text-sm text-gray-600 mb-1">
                                            <strong>Keluhan:</strong> {{ $record->complaint }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <strong>Penanganan:</strong> {{ $record->treatment }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Belum ada rekam medis</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection