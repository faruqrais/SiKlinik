@extends('layouts.admin')

@section('title', 'Detail Kunjungan Medis')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('visits.index') }}" class="text-sm font-semibold text-blue-600 hover:underline flex items-center gap-1 mb-2">&larr; Kembali ke Daftar</a>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Detail Rekam Kunjungan</h1>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('visits.edit', $visit->id) }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
            Edit Rekam Medis
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Left Column: Patient & Doctor Cards -->
    <div class="lg:col-span-1 flex flex-col gap-6">
        
        <!-- Patient Info Card -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Informasi Pasien</h2>
            <div class="flex flex-col gap-3">
                <div class="flex flex-col gap-0.5">
                    <span class="text-xs text-slate-400 font-medium">Nama Pasien</span>
                    <a href="{{ $visit->patient_id ? route('patients.show', $visit->patient_id) : '#' }}" class="font-bold text-blue-600 hover:underline">
                        {{ $visit->patient->name ?? 'Pasien Terhapus' }}
                    </a>
                </div>
                <div class="flex flex-col gap-0.5">
                    <span class="text-xs text-slate-400 font-medium">NIK</span>
                    <span class="font-semibold text-slate-800 font-mono text-xs">{{ $visit->patient->nik ?? '-' }}</span>
                </div>
                <div class="flex flex-col gap-0.5">
                    <span class="text-xs text-slate-400 font-medium">Nomor Telepon</span>
                    <span class="font-semibold text-slate-800">{{ $visit->patient->phone ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Doctor Info Card -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Dokter Pemeriksa</h2>
            <div class="flex flex-col gap-3">
                <div class="flex flex-col gap-0.5">
                    <span class="text-xs text-slate-400 font-medium">Nama Dokter</span>
                    <a href="{{ $visit->doctor_id ? route('doctors.show', $visit->doctor_id) : '#' }}" class="font-bold text-blue-600 hover:underline">
                        {{ $visit->doctor->name ?? 'Dokter Terhapus' }}
                    </a>
                </div>
                <div class="flex flex-col gap-0.5">
                    <span class="text-xs text-slate-400 font-medium">Spesialisasi</span>
                    <span class="font-semibold text-slate-800">{{ $visit->doctor->specialization ?? '-' }}</span>
                </div>
                <div class="flex flex-col gap-0.5">
                    <span class="text-xs text-slate-400 font-medium">Nomor Telepon</span>
                    <span class="font-semibold text-slate-800">{{ $visit->doctor->phone ?? '-' }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column: Medical Examination Card -->
    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl p-6 sm:p-8 shadow-sm flex flex-col gap-6">
        <div>
            <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">Hasil Pemeriksaan Klinis</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="flex flex-col gap-0.5">
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Tanggal Pemeriksaan</span>
                    <span class="text-base font-semibold text-slate-800">{{ $visit->visit_date ? $visit->visit_date->format('d F Y') : '-' }}</span>
                </div>
                <div class="flex flex-col gap-0.5">
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">ID Rekam Medis</span>
                    <span class="text-base font-semibold text-slate-800 font-mono text-sm">#SK-VISIT-{{ $visit->id }}</span>
                </div>
            </div>

            <!-- Complaint -->
            <div class="mb-6 flex flex-col gap-1.5 p-4 rounded-lg bg-slate-50 border border-slate-200">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Keluhan Fisik Utama</span>
                <p class="text-sm font-medium text-slate-800 leading-relaxed whitespace-pre-wrap">{{ $visit->complaint }}</p>
            </div>

            <!-- Diagnosis -->
            <div class="flex flex-col gap-1.5 p-4 rounded-lg bg-blue-50/50 border border-blue-100">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Diagnosa & Terapi Medis</span>
                <p class="text-sm font-semibold text-blue-900 leading-relaxed whitespace-pre-wrap">{{ $visit->diagnosis }}</p>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-4 flex items-center justify-between text-xs text-slate-400 font-medium">
            <span>Dibuat: {{ $visit->created_at ? $visit->created_at->format('d M Y, H:i') : '-' }}</span>
            <span>Terakhir diubah: {{ $visit->updated_at ? $visit->updated_at->format('d M Y, H:i') : '-' }}</span>
        </div>
    </div>

</div>
@endsection
