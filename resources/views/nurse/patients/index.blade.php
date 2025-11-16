@extends('layouts.app')
@section('title', 'Daftar Pasien')
@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Daftar Pasien</h1>
            <a href="{{ route('nurse.patients.create') }}" class="btn-primary">Daftar Pasien Baru</a>
        </div>

        <div class="card overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kontak</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($patients as $patient)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $patient->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $patient->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $patient->patient_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $patient->nik }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $patient->user->phone }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('nurse.patients.show', $patient->id) }}" class="text-primary-600 hover:text-primary-900">Lihat</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $patients->links() }}</div>
    </div>
</div>
@endsection