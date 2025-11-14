<!-- ========================================== -->
<!-- resources/views/admin/doctors/index.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Daftar Dokter')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Daftar Dokter</h1>
                <p class="text-gray-600 mt-1">Kelola data dokter klinik</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.doctors.create') }}" class="border-2 border-primary-600 p-4 text-primary-600 inline-flex items-center rounded-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Dokter
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="card mb-6">
            <div class="p-6">
                <form method="GET" action="{{ route('admin.doctors.index') }}" class="flex items-center space-x-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search ?? '' }}"
                                placeholder="Cari nama dokter, spesialisasi, atau nomor lisensi..." 
                                class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            >
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Cari</button>
                    @if($search)
                        <a href="{{ route('admin.doctors.index') }}" class="btn-secondary">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Doctors Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($doctors as $doctor)
                <div class="card group hover:shadow-lg transition-all duration-300 border border-gray-200 overflow-hidden">
                    <!-- Header dengan background primary -->
                    <div class="bg-primary-600 p-5">
                        <div class="flex items-center space-x-4">
                            <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center text-white text-xl font-bold border-2 border-white/30">
                                {{ substr($doctor->name ?? $doctor->user->name ?? 'D', 0, 1) }}
                            </div>
                            <div class="flex-1 text-white">
                                <h3 class="text-lg font-bold truncate">{{ $doctor->name ?? $doctor->user->name ?? 'N/A' }}</h3>
                                <p class="text-primary-100 text-sm truncate">{{ $doctor->specialization ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Informasi Dokter -->
                        <div class="space-y-4 mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <span class="text-xs text-gray-500 block">Lisensi</span>
                                    <span class="font-mono text-sm text-gray-900">{{ $doctor->license_number ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <span class="text-xs text-gray-500 block">Pengalaman</span>
                                    <span class="text-sm text-gray-900">{{ $doctor->experience_years ?? 0 }} tahun</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <span class="text-xs text-gray-500 block">Email</span>
                                    <span class="text-sm text-gray-900 truncate">{{ $doctor->email ?? $doctor->user->email ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Status Availability -->
                        @if($doctor->is_available ?? true)
                            <div class="flex items-center justify-center space-x-2 p-3 bg-green-50 border border-green-200 rounded-lg mb-4">
                                <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                <span class="text-xs font-medium text-green-700">Tersedia</span>
                            </div>
                        @else
                            <div class="flex items-center justify-center space-x-2 p-3 bg-red-50 border border-red-200 rounded-lg mb-4">
                                <div class="h-2 w-2 rounded-full bg-red-500"></div>
                                <span class="text-xs font-medium text-red-700">Tidak Tersedia</span>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.doctors.show', $doctor->id) }}" 
                            class="text-primary-600 hover:text-primary-700 text-sm font-medium inline-flex items-center space-x-1 transition-colors">
                                <span>Lihat Detail</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            
                            <div class="flex items-center space-x-1">
                                <a href="{{ route('admin.doctors.edit', $doctor->id) }}" 
                                class="p-2 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors duration-200"
                                title="Edit Dokter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" 
                                    class="inline" onsubmit="return confirm('Yakin ingin menghapus dokter ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                            title="Hapus Dokter">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="mt-4 text-lg font-medium text-gray-500">Belum ada data dokter</p>
                    <p class="text-sm text-gray-400 mt-1">Tambahkan dokter pertama Anda untuk memulai</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection