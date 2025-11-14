<!-- ========================================== -->
<!-- resources/views/patient/medical-records/show.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <a href="{{ route('patient.medical-records.index') }}" class="text-primary-600 hover:text-primary-700 inline-flex items-center text-sm mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Detail Rekam Medis</h1>
            <p class="text-gray-600 mt-1">Hasil pemeriksaan kesehatan Anda</p>
        </div>

        <div class="space-y-6">
            
            <!-- Visit Info -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200 bg-primary-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Kunjungan</h3>
                        <span class="text-sm text-gray-600">{{ $record->visit_date->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        <div class="h-16 w-16 rounded-full bg-green-600 flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr($record->doctor->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">{{ $record->doctor->user->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $record->doctor->specialization }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $record->doctor->experience_years }} tahun pengalaman</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Details -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Detail Pemeriksaan</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Keluhan Anda
                        </h4>
                        <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $record->complaint }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-blue-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Diagnosis Dokter
                        </h4>
                        <p class="text-gray-900 bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500 font-medium">{{ $record->diagnosis }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Penanganan
                        </h4>
                        <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $record->treatment }}</p>
                    </div>

                    @if($record->prescription)
                        <div>
                            <h4 class="text-sm font-semibold text-green-700 mb-2 flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                                Resep Obat
                            </h4>
                            <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                                <p class="text-gray-900 whitespace-pre-line">{{ $record->prescription }}</p>
                                <p class="text-xs text-green-600 mt-3">💊 Pastikan mengikuti dosis dan aturan pakai yang diberikan</p>
                            </div>
                        </div>
                    @endif

                    @if($record->notes)
                        <div>
                            <h4 class="text-sm font-semibold text-yellow-700 mb-2 flex items-center">
                                <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Catatan Dokter
                            </h4>
                            <!-- VULNERABLE: XSS akan ter-execute di sini -->
                            <div class="text-gray-900 bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                                {!! $record->notes !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Button -->
            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Butuh konsultasi lanjutan?</p>
                            <p class="text-xs text-gray-500">Buat janji temu dengan dokter yang sama</p>
                        </div>
                        <a href="{{ route('patient.appointments.create') }}" class="btn-primary">
                            Buat Janji Temu
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection