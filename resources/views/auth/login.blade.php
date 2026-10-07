@extends('layouts.guest')

@section('title', 'Login')

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

        <!-- Login Form -->
        <form action="{{ url('/login') }}" method="POST" class="flex flex-col gap-4">
            @csrf

            <!-- Email Input -->
            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-sm font-semibold text-slate-700">Email Pasien / Admin</label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2.5 rounded-xl border @error('email') border-red-300 bg-red-50/30 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                        placeholder="nama@email.com">
                </div>
                @error('email')
                    <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="flex flex-col gap-1.5">
                <div class="flex items-center justify-between">
                    <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
                </div>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2.5 rounded-xl border @error('password') border-red-300 bg-red-50/30 @else border-slate-300 focus:border-blue-500 @enderror focus:outline-none transition text-sm"
                    placeholder="••••••••">
                @error('password')
                    <span class="text-xs text-red-600 font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me Option -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <label for="remember" class="text-xs text-slate-500 cursor-pointer select-none font-medium">Ingat Saya di Perangkat Ini</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-2.5 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                Masuk Portal
            </button>

            <!-- Navigation Switch -->
            <div class="text-center text-xs text-slate-500 mt-2 font-medium">
                Belum punya akun pasien? 
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Daftar Sekarang</a>
            </div>
        </form>
    </div>
</div>
@endsection
