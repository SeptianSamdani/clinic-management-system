<!-- ========================================== -->
<!-- resources/views/doctor/medical-records/show.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <a href="{{ route('doctor.medical-records.index') }}" class="text-primary-600 hover:text-primary-700 inline-flex items-center text-sm mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Rekam Medis</h1>
                    <p class="text-gray-600 mt-1">Informasi lengkap rekam medis pasien</p>
                </div>
                <a href="{{ route('doctor.medical-records.edit', $record->id) }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <div class="space-y-6">
            
            <!-- Patient Info -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Pasien</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="h-16 w-16 rounded-full bg-primary-600 flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr($record->patient_name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">{{ $record->patient_name }}</h4>
                            <p class="text-sm text-gray-500">{{ $record->patient_number }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">NIK</p>
                            <p class="font-mono text-gray-900">{{ $record->nik }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Golongan Darah</p>
                            <p class="text-gray-900">{{ $record->blood_type }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Jenis Kelamin</p>
                            <p class="text-gray-900">{{ $record->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tanggal Lahir</p>
                            <p class="text-gray-900">{{ \Carbon\Carbon::parse($record->birth_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Record Details -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Detail Pemeriksaan</h3>
                        <span class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($record->visit_date)->format('d M Y') }}
                        </span>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Keluhan Pasien</h4>
                        <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $record->complaint }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Diagnosis</h4>
                        <p class="text-gray-900 bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">{{ $record->diagnosis }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Penanganan</h4>
                        <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $record->treatment }}</p>
                    </div>

                    @if($record->prescription)
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Resep Obat</h4>
                            <p class="text-gray-900 bg-green-50 p-4 rounded-lg border-l-4 border-green-500">{{ $record->prescription }}</p>
                        </div>
                    @endif

                    @if($record->notes)
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan</h4>
                            <!-- VULNERABLE: No HTML escaping - XSS akan ter-execute di sini -->
                            <div class="text-gray-900 bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                                {!! $record->notes !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Patient Medical History -->
            @if($record->medical_history)
                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Riwayat Medis Pasien</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-900">{{ $record->medical_history }}</p>
                        @if($record->allergies)
                            <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-sm font-semibold text-red-800">Alergi:</p>
                                <p class="text-sm text-red-700">{{ $record->allergies }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection
