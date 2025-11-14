<!-- ========================================== -->
<!-- resources/views/doctor/medical-records/create.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Tambah Rekam Medis')

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
            <h1 class="text-3xl font-bold text-gray-900">Tambah Rekam Medis Baru</h1>
            <p class="text-gray-600 mt-1">Catat hasil pemeriksaan pasien</p>
        </div>

        <!-- Form -->
        <div class="card">
            <form method="POST" action="{{ route('doctor.medical-records.store') }}" class="p-6 space-y-6">
                
                <!-- Patient Selection -->
                <div>
                    <label for="patient_id" class="label">Pilih Pasien <span class="text-red-500">*</span></label>
                    <select name="patient_id" id="patient_id" class="input-field" required>
                        <option value="">Pilih pasien...</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} - {{ $patient->patient_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Visit Date -->
                <div>
                    <label for="visit_date" class="label">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                    <input type="date" name="visit_date" id="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" class="input-field" required>
                </div>

                <hr>

                <!-- Medical Details -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pemeriksaan</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="complaint" class="label">Keluhan Pasien <span class="text-red-500">*</span></label>
                            <textarea name="complaint" id="complaint" rows="3" class="input-field" placeholder="Jelaskan keluhan pasien..." required>{{ old('complaint') }}</textarea>
                        </div>

                        <div>
                            <label for="diagnosis" class="label">Diagnosis <span class="text-red-500">*</span></label>
                            <textarea name="diagnosis" id="diagnosis" rows="3" class="input-field" placeholder="Tuliskan diagnosis..." required>{{ old('diagnosis') }}</textarea>
                        </div>

                        <div>
                            <label for="treatment" class="label">Penanganan <span class="text-red-500">*</span></label>
                            <textarea name="treatment" id="treatment" rows="3" class="input-field" placeholder="Jelaskan penanganan yang diberikan..." required>{{ old('treatment') }}</textarea>
                        </div>

                        <div>
                            <label for="prescription" class="label">Resep Obat</label>
                            <textarea name="prescription" id="prescription" rows="3" class="input-field" placeholder="Tuliskan resep obat jika ada...">{{ old('prescription') }}</textarea>
                        </div>

                        <!-- VULNERABLE FIELD - XSS Target -->
                        <div>
                            <label for="notes" class="label">Catatan Tambahan</label>
                            <textarea name="notes" id="notes" rows="3" class="input-field" placeholder="Catatan tambahan untuk pasien...">{{ old('notes') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Field ini mendukung HTML untuk formatting (VULNERABLE untuk XSS)</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('doctor.medical-records.index') }}" class="btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Rekam Medis
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection