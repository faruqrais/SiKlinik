@extends('layouts.guest')

@section('title', 'Daftar Pasien Baru')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center p-4 bg-gradient-to-br from-blue-500 via-sky-100 to-white">
    <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200/55 shadow-2xl p-6 sm:p-8 flex flex-col gap-6 transition duration-300">
        
        <!-- App Title and Brand -->
        <div class="flex flex-col items-center text-center gap-2">
            <span class="p-3 bg-blue-600 rounded-2xl text-white shadow-xl shadow-blue-100">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 10.5V20a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-9.5m14 0V9a2 2 0 0 0-2-2h-3.5m5 3.5V5a2 2 0 0 0-2-2h-3.5M12 3v14m-7-7h14" />
                </svg>
            </span>
            <h1 class="text-2xl font-extrabold text-blue-900 tracking-tight mt-2">SiKlinik</h1>
            <p class="text-sm text-slate-500">Sistem Informasi Klinik Sederhana</p>
        </div>

        <!-- Success and Error Session Banner -->
        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-green-50 border border-green-200 text-green-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <svg class="h-4 w-4 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <svg class="h-4 w-4 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Register Form -->
        <form action="{{ url('/register') }}" method="POST" class="flex flex-col gap-4 max-h-[50vh] overflow-y-auto pr-1">
            @csrf

            <!-- Nama Lengkap -->
            <div class="flex flex-col gap-1.5">
                <label for="name" class="text-sm font-semibold text-slate-700">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 rounded-xl border @error('name') border-red-300 bg-red-50/30 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                    placeholder="Nama Lengkap sesuai KTP">
                @error('name')
                    <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- NIK (16 digit) -->
            <div class="flex flex-col gap-1.5">
                <label for="nik" class="text-sm font-semibold text-slate-700">Nomor Induk Kependudukan (NIK)</label>
                <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required maxlength="16"
                    class="w-full px-4 py-2 rounded-xl border @error('nik') border-red-300 bg-red-50/30 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                    placeholder="16 Digit NIK KTP">
                @error('nik')
                    <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-sm font-semibold text-slate-700">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 rounded-xl border @error('email') border-red-300 bg-red-50/30 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                    placeholder="nama@email.com">
                @error('email')
                    <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div class="flex flex-col gap-1.5">
                <label for="birth_date" class="text-sm font-semibold text-slate-700">Tanggal Lahir</label>
                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required
                    class="w-full px-4 py-2 rounded-xl border @error('birth_date') border-red-300 bg-red-50/30 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm">
                @error('birth_date')
                    <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nomor HP -->
            <div class="flex flex-col gap-1.5">
                <label for="phone" class="text-sm font-semibold text-slate-700">Nomor HP</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                    class="w-full px-4 py-2 rounded-xl border @error('phone') border-red-300 bg-red-50/30 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                    placeholder="08xxxxxxxxxx">
                @error('phone')
                    <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Alamat Lengkap -->
            <div class="flex flex-col gap-1.5">
                <label for="address" class="text-sm font-semibold text-slate-700">Alamat Lengkap</label>
                <textarea name="address" id="address" rows="3" required
                    class="w-full px-4 py-2 rounded-xl border @error('address') border-red-300 bg-red-50/30 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                    placeholder="Alamat lengkap domisili saat ini">{{ old('address') }}</textarea>
                @error('address')
                    <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 rounded-xl border @error('password') border-red-300 bg-red-50/30 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                    placeholder="Minimal 8 karakter">
                @error('password')
                    <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="flex flex-col gap-1.5">
                <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 focus:border-blue-500 focus:outline-none transition text-sm"
                    placeholder="Ulangi password">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-2.5 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition mt-2">
                Daftar Sebagai Pasien
            </button>

            <!-- Navigation Switch -->
            <div class="text-center text-xs text-slate-500 mt-2 font-medium">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Masuk</a>
            </div>
        </form>
    </div>
</div>
@endsection
