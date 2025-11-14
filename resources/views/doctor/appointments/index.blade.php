<!-- ========================================== -->
<!-- resources/views/doctor/appointments/index.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Jadwal Appointments')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Jadwal Appointments</h1>
            <p class="text-gray-600 mt-1">Kelola janji temu dengan pasien</p>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6" x-data="{ activeTab: '{{ $status }}' }">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="{{ route('doctor.appointments.index', ['status' => 'all']) }}" 
                       class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition
                       {{ $status === 'all' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Semua
                    </a>
                    <a href="{{ route('doctor.appointments.index', ['status' => 'pending']) }}" 
                       class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition
                       {{ $status === 'pending' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Pending
                    </a>
                    <a href="{{ route('doctor.appointments.index', ['status' => 'confirmed']) }}" 
                       class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition
                       {{ $status === 'confirmed' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Dikonfirmasi
                    </a>
                    <a href="{{ route('doctor.appointments.index', ['status' => 'completed']) }}" 
                       class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition
                       {{ $status === 'completed' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Selesai
                    </a>
                    <a href="{{ route('doctor.appointments.index', ['status' => 'cancelled']) }}" 
                       class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition
                       {{ $status === 'cancelled' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Dibatalkan
                    </a>
                </nav>
            </div>
        </div>

        <!-- Appointments List -->
        <div class="space-y-4">
            @forelse($appointments as $appointment)
                <div class="card hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4 flex-1">
                                <div class="h-12 w-12 rounded-full bg-primary-600 flex items-center justify-center text-white font-semibold flex-shrink-0">
                                    {{ substr($appointment->patient->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $appointment->patient->user->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-2">{{ $appointment->patient->patient_number }}</p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm mt-3">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-gray-900">{{ $appointment->appointment_date->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-gray-900">{{ $appointment->appointment_date->format('H:i') }}</span>
                                        </div>
                                        <div>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                                                @elseif($appointment->status === 'completed') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($appointment->reason)
                                        <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                            <p class="text-sm text-gray-700"><strong>Alasan:</strong> {{ $appointment->reason }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="ml-4 flex flex-col space-y-2">
                                <a href="{{ route('doctor.appointments.show', $appointment->id) }}" class="text-primary-600 hover:text-primary-900 text-sm font-medium whitespace-nowrap">
                                    Lihat Detail
                                </a>
                                
                                @if($appointment->status === 'pending')
                                    <form action="{{ route('doctor.appointments.confirm', $appointment->id) }}" method="POST">
                                        @method('PUT')
                                        <button type="submit" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                            Konfirmasi
                                        </button>
                                    </form>
                                @endif

                                @if($appointment->status === 'confirmed')
                                    <form action="{{ route('doctor.appointments.complete', $appointment->id) }}" method="POST">
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">
                                            Selesaikan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Tidak ada appointment</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection