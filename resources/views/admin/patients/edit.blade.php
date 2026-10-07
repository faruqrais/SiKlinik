@extends('layouts.admin')

@section('title', 'Edit Pasien')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <a href="{{ route('patients.index') }}" class="text-sm font-semibold text-blue-600 hover:underline flex items-center gap-1 mb-2">&larr; Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Data Pasien</h1>
    <p class="text-sm text-slate-500">Perbarui informasi diri dan kredensial login portal pasien.</p>
</div>

<!-- Form Card -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm max-w-2xl p-6 sm:p-8">
    <form action="{{ route('patients.update', $patient->id) }}" method="POST" class="flex flex-col gap-6">
        @csrf
        @method('PUT')

        <!-- SECTION 1: PROFIL PASIEN -->
        <div>
            <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">Informasi Profil Pasien</h2>
            <div class="flex flex-col gap-4">
                <!-- Nama Lengkap -->
                <div class="flex flex-col gap-1.5">
                    <label for="name" class="text-sm font-semibold text-slate-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}" required
                        class="w-full px-4 py-2 rounded-lg border @error('name') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                        placeholder="Nama lengkap sesuai KTP">
                    @error('name')
                        <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIK (16 digit) -->
                <div class="flex flex-col gap-1.5">
                    <label for="nik" class="text-sm font-semibold text-slate-700">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $patient->nik) }}" required maxlength="16"
                        class="w-full px-4 py-2 rounded-lg border @error('nik') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                        placeholder="16 Digit NIK KTP">
                    @error('nik')
                        <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tanggal Lahir & Nomor HP Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label for="birth_date" class="text-sm font-semibold text-slate-700">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '') }}" required
                            class="w-full px-4 py-2 rounded-lg border @error('birth_date') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm">
                        @error('birth_date')
                            <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="phone" class="text-sm font-semibold text-slate-700">Nomor HP</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}" required
                            class="w-full px-4 py-2 rounded-lg border @error('phone') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                            placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Alamat Lengkap -->
                <div class="flex flex-col gap-1.5">
                    <label for="address" class="text-sm font-semibold text-slate-700">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3" required
                        class="w-full px-4 py-2 rounded-lg border @error('address') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                        placeholder="Alamat lengkap tempat tinggal">{{ old('address', $patient->address) }}</textarea>
                    @error('address')
                        <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 2: AKUN LOGIN PORTAL -->
        <div>
            <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">Informasi Kredensial Login Pasien</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Email -->
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-sm font-semibold text-slate-700">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $patient->user->email ?? '') }}" required
                        class="w-full px-4 py-2 rounded-lg border @error('email') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                        placeholder="email@siklinik.com">
                    @error('email')
                        <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-1.5">
                    <label for="password" class="text-sm font-semibold text-slate-700">Password Baru (Opsional)</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 rounded-lg border @error('password') border-red-300 bg-red-50/20 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                        placeholder="Kosongkan jika tidak diubah">
                    @error('password')
                        <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('patients.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow transition">
                Perbarui Pasien & Akun
            </button>
        </div>
    </form>
</div>
@endsection
