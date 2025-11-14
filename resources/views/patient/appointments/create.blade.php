<!-- ========================================== -->
<!-- resources/views/patient/appointments/create.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Buat Janji Temu')

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
            <h1 class="text-3xl font-bold text-gray-900">Buat Janji Temu Baru</h1>
            <p class="text-gray-600 mt-1">Jadwalkan konsultasi dengan dokter</p>
        </div>

        <!-- Form -->
        <div class="card">
            <form method="POST" action="{{ route('patient.appointments.store') }}" class="p-6 space-y-6">
                
                <!-- Doctor Selection -->
                <div>
                    <label for="doctor_id" class="label">Pilih Dokter <span class="text-red-500">*</span></label>
                    <select name="doctor_id" id="doctor_id" class="input-field" required x-data x-on:change="
                        const selected = $event.target.selectedOptions[0];
                        const specialization = selected.dataset.specialization;
                        const experience = selected.dataset.experience;
                        if (selected.value) {
                            document.getElementById('doctor-info').classList.remove('hidden');
                            document.getElementById('doctor-specialization').textContent = specialization;
                            document.getElementById('doctor-experience').textContent = experience + ' tahun';
                        } else {
                            document.getElementById('doctor-info').classList.add('hidden');
                        }
                    ">
                        <option value="">Pilih dokter...</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" 
                                    data-specialization="{{ $doctor->specialization }}"
                                    data-experience="{{ $doctor->experience_years }}"
                                    {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->user->name }} - {{ $doctor->specialization }}
                            </option>
                        @endforeach
                    </select>

                    <div id="doctor-info" class="hidden mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-blue-600 font-medium">Spesialisasi</p>
                                <p id="doctor-specialization" class="text-blue-900"></p>
                            </div>
                            <div>
                                <p class="text-blue-600 font-medium">Pengalaman</p>
                                <p id="doctor-experience" class="text-blue-900"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointment Date & Time -->
                <div>
                    <label for="appointment_date" class="label">Tanggal & Waktu <span class="text-red-500">*</span></label>
                    <input 
                        type="datetime-local" 
                        name="appointment_date" 
                        id="appointment_date" 
                        value="{{ old('appointment_date') }}" 
                        class="input-field" 
                        min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                        required>
                    <p class="mt-1 text-xs text-gray-500">Pilih tanggal minimal 1 hari ke depan</p>
                </div>

                <!-- Reason -->
                <div>
                    <label for="reason" class="label">Alasan Konsultasi <span class="text-red-500">*</span></label>
                    <textarea 
                        name="reason" 
                        id="reason" 
                        rows="4" 
                        class="input-field" 
                        placeholder="Jelaskan keluhan atau alasan Anda ingin berkonsultasi..."
                        required>{{ old('reason') }}</textarea>
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-yellow-800">
                            <p class="font-semibold mb-1">Catatan Penting:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Janji temu akan dikonfirmasi oleh dokter</li>
                                <li>Datang 15 menit sebelum jadwal</li>
                                <li>Bawa kartu identitas dan riwayat medis jika ada</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('patient.appointments.index') }}" class="btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Buat Janji Temu
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection