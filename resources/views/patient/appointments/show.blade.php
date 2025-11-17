<!-- ========================================== -->
<!-- resources/views/patient/appointments/show.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Detail Janji Temu')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <a href="{{ route('patient.appointments.index') }}" class="text-primary-600 hover:text-primary-700 inline-flex items-center text-sm mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Detail Janji Temu</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap jadwal konsultasi</p>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            <span class="px-4 py-2 text-sm font-semibold rounded-full
                @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                @elseif($appointment->status === 'completed') bg-green-100 text-green-800
                @else bg-red-100 text-red-800
                @endif">
                {{ ucfirst($appointment->status) }}
            </span>
        </div>

        <!-- Doctor Information -->
        <div class="card mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-primary-50">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Dokter</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    <div class="h-16 w-16 rounded-full bg-green-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr($appointment->doctor->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-gray-900">{{ $appointment->doctor->user->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $appointment->doctor->specialization }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $appointment->doctor->experience_years }} tahun pengalaman</p>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1">Email</p>
                        <p class="text-gray-900">{{ $appointment->doctor->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Telepon</p>
                        <p class="text-gray-900">{{ $appointment->doctor->user->phone }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment Details -->
        <div class="card mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Detail Janji Temu</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-primary-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal & Waktu</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $appointment->appointment_date->format('l, d F Y') }}
                        </p>
                        <p class="text-md text-gray-700">
                            Pukul {{ $appointment->appointment_date->format('H:i') }} WIB
                        </p>
                    </div>
                </div>

                @if($appointment->reason)
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-primary-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 mb-2">Alasan Konsultasi</p>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-gray-900">{{ $appointment->reason }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-primary-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-500">Lokasi</p>
                        <p class="text-gray-900">{{ $appointment->doctor->user->address ?? 'Jl. Kesehatan No. 123, Jakarta' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        @if(in_array($appointment->status, ['pending', 'confirmed']))
        <div class="card bg-yellow-50 border border-yellow-200">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-yellow-800">Perlu Dibatalkan?</h4>
                            <p class="text-sm text-yellow-700 mt-1">
                                Jika tidak bisa hadir, mohon batalkan janji temu Anda
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('patient.appointments.cancel', $appointment->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan janji temu ini?')">
                        @method('PUT')
                        <button type="submit" class="btn-danger">
                            Batalkan Janji Temu
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @if($appointment->status === 'completed')
        <div class="card bg-green-50 border border-green-200">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-green-800">Konsultasi Selesai</h4>
                        <p class="text-sm text-green-700 mt-1">
                            Terima kasih telah berkonsultasi. Cek rekam medis Anda untuk hasil pemeriksaan.
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('patient.medical-records.index') }}" class="btn-primary">
                        Lihat Rekam Medis
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if($appointment->status === 'cancelled')
        <div class="card bg-red-50 border border-red-200">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-red-800">Janji Temu Dibatalkan</h4>
                        <p class="text-sm text-red-700 mt-1">
                            Janji temu ini telah dibatalkan. Anda dapat membuat janji temu baru.
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('patient.appointments.create') }}" class="btn-primary">
                        Buat Janji Temu Baru
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Reminder -->
        @if($appointment->status === 'confirmed')
        <div class="mt-6 card bg-blue-50 border border-blue-200">
            <div class="p-6">
                <h4 class="font-semibold text-blue-800 mb-3">📋 Reminder</h4>
                <ul class="space-y-2 text-sm text-blue-700">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Datang 15 menit lebih awal
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Bawa kartu identitas (KTP/SIM)
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Bawa riwayat medis sebelumnya (jika ada)
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Gunakan masker jika sedang sakit
                    </li>
                </ul>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection