@extends('layouts.admin')

@section('title', 'Tambah Dokter Baru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <a href="{{ route('doctors.index') }}" class="text-sm font-semibold text-blue-600 hover:underline flex items-center gap-1 mb-2">&larr; Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Tambah Dokter Baru</h1>
    <p class="text-sm text-slate-500">Isi formulir di bawah ini untuk mendaftarkan dokter baru ke klinik.</p>
</div>

<!-- Form Card -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm max-w-2xl p-6 sm:p-8">
    <form action="{{ route('doctors.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <!-- Nama Dokter -->
        <div class="flex flex-col gap-1.5">
            <label for="name" class="text-sm font-semibold text-slate-700">Nama Lengkap Dokter</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full px-4 py-2.5 rounded-lg border @error('name') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                placeholder="Contoh: dr. Ahmad Subarjo, Sp.A">
            @error('name')
                <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <!-- Spesialisasi -->
        <div class="flex flex-col gap-1.5">
            <label for="specialization" class="text-sm font-semibold text-slate-700">Spesialisasi</label>
            <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" required
                class="w-full px-4 py-2.5 rounded-lg border @error('specialization') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                placeholder="Contoh: Spesialis Anak / Dokter Umum">
            @error('specialization')
                <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <!-- Jadwal Praktek -->
        <div class="flex flex-col gap-1.5">
            <label for="schedule" class="text-sm font-semibold text-slate-700">Jadwal Praktek</label>
            <input type="text" name="schedule" id="schedule" value="{{ old('schedule') }}" required
                class="w-full px-4 py-2.5 rounded-lg border @error('schedule') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                placeholder="Contoh: Senin - Jumat, 08:00 - 14:00">
            @error('schedule')
                <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <!-- Nomor Telepon -->
        <div class="flex flex-col gap-1.5">
            <label for="phone" class="text-sm font-semibold text-slate-700">Nomor Telepon</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                class="w-full px-4 py-2.5 rounded-lg border @error('phone') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                placeholder="Contoh: 08123456789">
            @error('phone')
                <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
            <a href="{{ route('doctors.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow transition">
                Simpan Dokter
            </button>
        </div>
    </form>
</div>
@endsection
