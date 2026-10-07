@extends('layouts.guest')

@section('title', 'Layanan Kesehatan Mudah & Terpercaya')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
@endpush

@section('content')
<!-- Dynamic Navbar for Landing Page -->
<header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex h-16 items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center gap-2">
            <span class="p-2 bg-blue-600 rounded-lg text-white shadow-md shadow-blue-200">
                <i class="ti ti-stethoscope text-xl"></i>
            </span>
            <span class="text-xl font-bold tracking-tight text-blue-900">SiKlinik</span>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-blue-600 transition">
                Masuk Portal
            </a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-md shadow-blue-200 transition">
                Daftar Akun
            </a>
        </div>
    </div>
</header>

<!-- Hero Section -->
@php
    // Scan all images in public/image/ dynamically
    $imagePaths = glob(public_path('image/*'));
    $images = array_map(function($path) {
        return 'image/' . basename($path);
    }, $imagePaths);
    
    // Fallback if folder empty
    if (empty($images)) {
        $images = ['image/hero.siklinik.jpg'];
    }
@endphp

<div class="hero-section hero-guest">
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
        <span class="hero-badge">
            <i class="ti ti-heart-rate-monitor mr-1.5 align-middle"></i> Sistem Informasi Klinik Terpercaya
        </span>
        <h1 class="hero-title">Layanan Kesehatan yang<br>Mudah & Terpercaya</h1>
        <p class="hero-subtitle">
            Booking dokter, pantau riwayat kunjungan, dan kelola kesehatan Anda dari mana saja bersama SiKlinik.
        </p>
        <div class="hero-actions">
            <a href="{{ route('login') }}" class="hero-btn hero-btn-primary">
                Booking Sekarang
            </a>
            <a href="#features" class="hero-btn hero-btn-secondary">
                Pelajari Lebih Lanjut
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

<!-- Section Fitur di bawah Hero -->
<section id="features" class="landing-features">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-3">Keunggulan Layanan Kami</h2>
        <p class="text-slate-500 max-w-xl mx-auto text-sm leading-relaxed">
            SiKlinik berkomitmen untuk memberikan kenyamanan dan aksesibilitas maksimal dalam perjalanan medis Anda.
        </p>
    </div>

    <div class="features-grid">
        <!-- Fitur 1: Booking Mudah -->
        <div class="feature-card">
            <div class="feature-icon-wrapper">
                <i class="ti ti-calendar-plus"></i>
            </div>
            <h3 class="feature-card-title">Booking Mudah</h3>
            <p class="feature-card-desc">
                Reservasi janji temu dengan dokter spesialis pilihan Anda hanya dalam beberapa klik secara daring tanpa antre.
            </p>
        </div>

        <!-- Fitur 2: Pilih Dokter Tepat -->
        <div class="feature-card">
            <div class="feature-icon-wrapper">
                <i class="ti ti-user-check"></i>
            </div>
            <h3 class="feature-card-title">Pilih Dokter Tepat</h3>
            <p class="feature-card-desc">
                Temukan jadwal dan profil lengkap dokter umum serta spesialis yang kompeten untuk penanganan medis optimal.
            </p>
        </div>

        <!-- Fitur 3: Pantau Riwayat -->
        <div class="feature-card">
            <div class="feature-icon-wrapper">
                <i class="ti ti-clipboard-list"></i>
            </div>
            <h3 class="feature-card-title">Pantau Riwayat</h3>
            <p class="feature-card-desc">
                Akses rekam medis, diagnosa dokter, dan riwayat kunjungan lengkap secara transparan langsung dari akun Anda.
            </p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/hero-slider.js') }}"></script>
@endpush
