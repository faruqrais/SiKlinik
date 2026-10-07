@extends('layouts.admin')

@section('title', 'Catat Kunjungan Baru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <a href="{{ route('visits.index') }}" class="text-sm font-semibold text-blue-600 hover:underline flex items-center gap-1 mb-2">&larr; Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Catat Kunjungan Medis Baru</h1>
    <p class="text-sm text-slate-500">Formulir pencatatan riwayat konsultasi, keluhan, serta diagnosa klinis pasien.</p>
</div>

<!-- Form Card -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm max-w-2xl p-6 sm:p-8">
    <form action="{{ route('visits.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <!-- Pilih Pasien -->
        <div class="flex flex-col gap-1.5">
            <label for="patient_id" class="text-sm font-semibold text-slate-700">Pasien</label>
            <select name="patient_id" id="patient_id" required
                class="w-full px-4 py-2.5 rounded-lg border @error('patient_id') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm bg-white">
                <option value="" disabled selected>-- Pilih Pasien --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }} (NIK: {{ $patient->nik }})
                    </option>
                @endforeach
            </select>
            @error('patient_id')
                <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <!-- Pilih Dokter -->
        <div class="flex flex-col gap-1.5">
            <label for="doctor_id" class="text-sm font-semibold text-slate-700">Dokter yang Menangani</label>
            <select name="doctor_id" id="doctor_id" required
                class="w-full px-4 py-2.5 rounded-lg border @error('doctor_id') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm bg-white">
                <option value="" disabled selected>-- Pilih Dokter --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->name }} (Spesialisasi: {{ $doctor->specialization }})
                    </option>
                @endforeach
            </select>
            @error('doctor_id')
                <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tanggal Kunjungan -->
        <div class="flex flex-col gap-1.5">
            <label for="visit_date" class="text-sm font-semibold text-slate-700">Tanggal Pemeriksaan</label>
            <input type="date" name="visit_date" id="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" required
                class="w-full px-4 py-2.5 rounded-lg border @error('visit_date') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm">
            @error('visit_date')
                <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <!-- Keluhan Pasien -->
        <div class="flex flex-col gap-1.5">
            <label for="complaint" class="text-sm font-semibold text-slate-700">Keluhan Pasien</label>
            <textarea name="complaint" id="complaint" rows="3" required
                class="w-full px-4 py-2 rounded-lg border @error('complaint') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                placeholder="Deskripsi singkat keluhan fisik yang dirasakan pasien">{{ old('complaint') }}</textarea>
            @error('complaint')
                <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <!-- Diagnosa Dokter -->
        <div class="flex flex-col gap-1.5">
            <label for="diagnosis" class="text-sm font-semibold text-slate-700">Diagnosa & Terapi Medis</label>
            <textarea name="diagnosis" id="diagnosis" rows="3" required
                class="w-full px-4 py-2 rounded-lg border @error('diagnosis') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                placeholder="Hasil diagnosis klinis dokter dan obat-obatan/tindakan medis">{{ old('diagnosis') }}</textarea>
            @error('diagnosis')
                <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
            <a href="{{ route('visits.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow transition">
                Simpan Catatan
            </button>
        </div>
    </form>
</div>
@endsection
