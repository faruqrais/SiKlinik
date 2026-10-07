@extends('layouts.app')

@section('title', 'Dashboard Pasien')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
@endpush

@section('content')
@php
    // Scan all images in public/image/ dynamically for patient slider
    $imagePaths = glob(public_path('image/*'));
    $images = array_map(function($path) {
        return 'image/' . basename($path);
    }, $imagePaths);
    
    if (empty($images)) {
        $images = ['image/hero.siklinik.jpg'];
    }
@endphp

<!-- Hero Section Pasien (Compact 220px) -->
<div class="hero-section hero-patient">
    <!-- Slider Container -->
    <div class="hero-slides-container">
        @foreach($images as $index => $image)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset($image) }}');"></div>
        @endforeach
    </div>

    <!-- Overlay -->
    <div class="hero-overlay"></div>

    <!-- Hero Content -->
    <div class="hero-content">
        <h1 class="hero-title">Selamat datang, {{ Auth::user()->name }}! 👋</h1>
        <p class="hero-subtitle">Bagaimana kondisi kesehatan Anda hari ini?</p>
        <div class="hero-actions">
            <a href="{{ route('patient.booking.index') }}" class="hero-btn hero-btn-primary">
                Booking Kunjungan Sekarang
            </a>
        </div>
    </div>

    <!-- Slider Navigations (Only if more than 1 image exists) -->
    @if(count($images) > 1)
        <button class="hero-control hero-prev" aria-label="Previous image">
            <i class="ti ti-chevron-left"></i>
        </button>
        <button class="hero-control hero-next" aria-label="Next image">
            <i class="ti ti-chevron-right"></i>
        </button>
        <div class="hero-indicators">
            @foreach($images as $index => $image)
                <button class="hero-indicator-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" aria-label="Go to slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Profile Widget (Left) -->
    <div class="lg:col-span-1 bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col gap-4">
        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Informasi Akun Anda</h2>
        
        <div class="flex flex-col gap-3.5 text-sm text-slate-600">
            <div class="flex flex-col gap-0.5">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</span>
                <span class="font-bold text-slate-800">{{ $patient->name }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">NIK (No. Kependudukan)</span>
                <span class="font-semibold text-slate-800 font-mono text-xs">{{ $patient->nik }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Lahir</span>
                <span class="font-medium text-slate-800">{{ $patient->birth_date ? $patient->birth_date->format('d M Y') : '-' }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nomor HP</span>
                <span class="font-medium text-slate-800">{{ $patient->phone }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Alamat Terdaftar</span>
                <span class="font-medium text-slate-800 leading-relaxed">{{ $patient->address }}</span>
            </div>
        </div>
        
        <a href="{{ route('patient.profile.edit') }}" class="mt-2 py-2 text-center bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-lg text-sm font-bold border border-slate-200 transition">
            Perbarui Profil Diri
        </a>
    </div>

    <!-- Right: Stats & Recent Activity -->
    <div class="lg:col-span-2 flex flex-col gap-6">
        
        <!-- Stats Card -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <span class="text-sm font-bold text-slate-400 uppercase tracking-wider">Total Kunjungan Medis</span>
                <span class="text-sm text-slate-500">Jumlah rekam konsultasi yang telah Anda lakukan di SiKlinik.</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-4xl font-extrabold text-blue-600">{{ $totalVisits }}</span>
                <span class="text-sm font-bold text-slate-400">Kali</span>
            </div>
        </div>

        <!-- Recent Visits Card -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden flex flex-col justify-between">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-950">Kunjungan Medis Terakhir Anda</h3>
                <a href="{{ route('patient.visits.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua &rarr;</a>
            </div>

            @if($recentVisits->isEmpty())
                <div class="p-8 text-center text-slate-500 text-sm">
                    Anda belum memiliki catatan kunjungan pemeriksaan di SiKlinik.
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($recentVisits as $visit)
                        <div class="p-6 hover:bg-slate-50/50 transition-colors flex flex-col gap-3">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-sm font-bold text-slate-900">{{ $visit->visit_date ? $visit->visit_date->format('d F Y') : '-' }}</span>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-700">Oleh: {{ $visit->doctor->name ?? 'Dokter' }}</span>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-bold text-slate-400 uppercase tracking-wider">Keluhan</span>
                                    <p class="font-medium text-slate-700 truncate" title="{{ $visit->complaint }}">{{ $visit->complaint }}</p>
                                </div>
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-bold text-blue-600 uppercase tracking-wider">Hasil Diagnosa & Terapi</span>
                                    <p class="font-semibold text-blue-900 truncate" title="{{ $visit->diagnosis }}">{{ $visit->diagnosis }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/hero-slider.js') }}"></script>
@endpush
