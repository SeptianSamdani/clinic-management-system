@extends('layouts.app')

@section('title', 'Dashboard Perawat')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Perawat</h1>
            <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">Total Pasien</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_patients'] }}</p>
                </div>
            </div>

            <div class="card">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">Appointment Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['today_appointments'] }}</p>
                </div>
            </div>

            <div class="card">
                <div class="p-6">
                    <p class="text-sm font-medium text-gray-600">Antrian Pending</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_queue'] }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('nurse.patients.create') }}" class="card p-6 hover:shadow-lg transition cursor-pointer">
                <div class="flex items-center space-x-4">
                    <div class="bg-primary-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Daftar Pasien Baru</p>
                        <p class="text-sm text-gray-500">Registrasi pasien baru</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('nurse.patients.index') }}" class="card p-6 hover:shadow-lg transition cursor-pointer">
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Lihat Semua Pasien</p>
                        <p class="text-sm text-gray-500">Data pasien terdaftar</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection