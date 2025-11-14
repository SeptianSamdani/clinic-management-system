<!-- ========================================== -->
<!-- resources/views/doctor/medical-records/index.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Rekam Medis')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Rekam Medis Pasien</h1>
                <p class="text-gray-600 mt-1">Kelola rekam medis pasien Anda</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('doctor.medical-records.create') }}" class="btn-primary inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Rekam Medis
                </a>
            </div>
        </div>

        <!-- Search - VULNERABLE -->
        <div class="card mb-6">
            <div class="p-6">
                <form method="GET" action="{{ route('doctor.medical-records.index') }}" class="flex items-center space-x-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search ?? '' }}"
                                placeholder="Cari nama pasien, diagnosis, atau nomor pasien..." 
                                class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            >
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Cari</button>
                    @if($search)
                        <a href="{{ route('doctor.medical-records.index') }}" class="btn-secondary">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Medical Records List -->
        <div class="space-y-4">
            @forelse($records as $record)
                <div class="card hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="h-12 w-12 rounded-full bg-primary-600 flex items-center justify-center text-white font-semibold">
                                        {{ substr($record->patient_name ?? $record->patient->user->name ?? 'P', 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $record->patient_name ?? $record->patient->user->name ?? 'Unknown Patient' }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $record->patient_number ?? $record->patient->patient_number ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500 mb-1">Tanggal Kunjungan</p>
                                        <p class="text-gray-900 font-medium">
                                            {{ \Carbon\Carbon::parse($record->visit_date)->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 mb-1">Keluhan</p>
                                        <p class="text-gray-900">{{ Str::limit($record->complaint, 60) }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <p class="text-gray-500 mb-1">Diagnosis</p>
                                        <p class="text-gray-900 font-medium">{{ $record->diagnosis }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="ml-4 flex flex-col space-y-2">
                                <a href="{{ route('doctor.medical-records.show', $record->id) }}" class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                    Lihat Detail
                                </a>
                                <a href="{{ route('doctor.medical-records.edit', $record->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('doctor.medical-records.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rekam medis ini?')">
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                        Hapus
                                    </button>
                                </form>
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
                        <p class="mt-2 text-sm text-gray-500">Belum ada rekam medis</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
