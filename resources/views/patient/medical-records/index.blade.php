<!-- ========================================== -->
<!-- resources/views/patient/medical-records/index.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Riwayat Rekam Medis')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Rekam Medis</h1>
            <p class="text-gray-600 mt-1">Lihat riwayat pemeriksaan kesehatan Anda</p>
        </div>

        <!-- Medical Records Timeline -->
        <div class="space-y-6">
            @forelse($medicalRecords as $record)
                <div class="card hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <!-- Timeline indicator -->
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-green-600 flex items-center justify-center text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $record->visit_date->format('d M Y') }}
                                    </h3>
                                    <a href="{{ route('patient.medical-records.show', $record->id) }}" class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                        Lihat Detail →
                                    </a>
                                </div>

                                <p class="text-sm text-gray-500 mb-3">Dr. {{ $record->doctor->user->name }} - {{ $record->doctor->specialization }}</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="p-4 bg-gray-50 rounded-lg">
                                        <p class="text-xs text-gray-500 mb-1">Keluhan</p>
                                        <p class="text-sm text-gray-900">{{ Str::limit($record->complaint, 100) }}</p>
                                    </div>
                                    <div class="p-4 bg-blue-50 rounded-lg">
                                        <p class="text-xs text-blue-600 mb-1">Diagnosis</p>
                                        <p class="text-sm text-blue-900 font-medium">{{ $record->diagnosis }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Belum ada riwayat rekam medis</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($medicalRecords->hasPages())
            <div class="mt-6">
                {{ $medicalRecords->links() }}
            </div>
        @endif

    </div>
</div>
@endsection