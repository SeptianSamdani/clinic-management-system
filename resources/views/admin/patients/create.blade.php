<!-- ========================================== -->
<!-- resources/views/admin/patients/create.blade.php -->
<!-- ========================================== -->

@extends('layouts.app')

@section('title', 'Tambah Pasien Baru')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <a href="{{ route('admin.patients.index') }}" class="text-primary-600 hover:text-primary-700 inline-flex items-center text-sm mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Pasien Baru</h1>
            <p class="text-gray-600 mt-1">Isi form di bawah untuk mendaftarkan pasien baru</p>
        </div>

        <!-- Form -->
        <div class="card">
            <form method="POST" action="{{ route('admin.patients.store') }}" class="p-6 space-y-6">
                
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="label">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="input-field" required>
                        </div>

                        <div>
                            <label for="nik" class="label">NIK (16 digit) <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="input-field" maxlength="16" pattern="[0-9]{16}" required>
                        </div>

                        <div>
                            <label for="birth_date" class="label">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" class="input-field" required>
                        </div>

                        <div>
                            <label for="gender" class="label">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" class="input-field" required>
                                <option value="">Pilih...</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label for="blood_type" class="label">Golongan Darah <span class="text-red-500">*</span></label>
                            <select name="blood_type" id="blood_type" class="input-field" required>
                                <option value="">Pilih...</option>
                                <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                                <option value="Unknown" {{ old('blood_type') == 'Unknown' ? 'selected' : '' }}>Tidak Tahu</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Contact Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="label">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="input-field" required>
                        </div>

                        <div>
                            <label for="phone" class="label">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="input-field" required>
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="label">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="address" id="address" rows="3" class="input-field" required>{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Medical Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Medis</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="medical_history" class="label">Riwayat Penyakit</label>
                            <textarea name="medical_history" id="medical_history" rows="3" class="input-field" placeholder="Contoh: Hipertensi, Diabetes, dll.">{{ old('medical_history') }}</textarea>
                        </div>

                        <div>
                            <label for="allergies" class="label">Alergi</label>
                            <textarea name="allergies" id="allergies" rows="2" class="input-field" placeholder="Contoh: Alergi seafood, penisilin, dll.">{{ old('allergies') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('admin.patients.index') }}" class="btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Pasien
                    </button>
                </div>
            </form>
        </div>

        <!-- Note -->
        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-blue-800">
                <strong>Catatan:</strong> Password default untuk pasien baru adalah <code class="bg-blue-100 px-2 py-1 rounded">password</code>. Pasien dapat mengubahnya setelah login pertama kali.
            </p>
        </div>

    </div>
</div>
@endsection