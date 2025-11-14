<!-- ========================================== -->
<!-- resources/views/patient/profile.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-gray-600 mt-1">Informasi pribadi dan data medis Anda</p>
        </div>

        <div class="space-y-6">
            
            <!-- Personal Information -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-6 mb-6">
                        <div class="h-24 w-24 rounded-full bg-primary-600 flex items-center justify-center text-white text-4xl font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                            <p class="text-gray-500">{{ auth()->user()->email }}</p>
                            <div class="mt-2 flex items-center space-x-3">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $patient->patient_number }}
                                </span>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ $patient->blood_type }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="text-gray-500 font-medium mb-1">NIK</p>
                            <p class="text-gray-900 font-mono">{{ $patient->nik }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 font-medium mb-1">Jenis Kelamin</p>
                            <p class="text-gray-900">{{ $patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 font-medium mb-1">Tanggal Lahir</p>
                            <p class="text-gray-900">{{ $patient->birth_date->format('d M Y') }} ({{ $patient->birth_date->age }} tahun)</p>
                        </div>
                        <div>
                            <p class="text-gray-500 font-medium mb-1">Golongan Darah</p>
                            <p class="text-gray-900">{{ $patient->blood_type }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 font-medium mb-1">Nomor Telepon</p>
                            <p class="text-gray-900">{{ auth()->user()->phone }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 font-medium mb-1">Alamat</p>
                            <p class="text-gray-900">{{ auth()->user()->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Information -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Medis</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Riwayat Penyakit</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900">{{ $patient->medical_history ?? 'Tidak ada riwayat penyakit yang tercatat' }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Alergi</h4>
                        <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                            <p class="text-red-900">{{ $patient->allergies ?? 'Tidak ada alergi yang tercatat' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card">
                    <div class="p-6 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 mb-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $patient->medicalRecords->count() }}</p>
                        <p class="text-sm text-gray-500">Rekam Medis</p>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $patient->appointments->where('status', 'completed')->count() }}</p>
                        <p class="text-sm text-gray-500">Kunjungan Selesai</p>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-yellow-100 mb-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $patient->appointments->whereIn('status', ['pending', 'confirmed'])->count() }}</p>
                        <p class="text-sm text-gray-500">Janji Mendatang</p>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact Info -->
            <div class="card bg-red-50 border border-red-200">
                <div class="p-6">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-red-800 mb-2">Kontak Darurat Klinik</h4>
                            <p class="text-sm text-red-700">📞 Telepon: (021) 123-4567</p>
                            <p class="text-sm text-red-700">🚑 Ambulans: 118</p>
                            <p class="text-sm text-red-700 mt-2">Tersedia 24 jam untuk keadaan darurat</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection