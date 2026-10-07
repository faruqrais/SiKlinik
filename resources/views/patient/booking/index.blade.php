@extends('layouts.app')

@section('title', 'Booking Kunjungan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Booking Kunjungan Baru</h1>
    <p class="text-sm text-slate-500">Jadwalkan konsultasi medis dengan dokter spesialis kami dalam 4 langkah mudah.</p>
</div>

<!-- Step Wizard Indicator (Statically Styled via Tailwind and custom booking.css) -->
<div class="bg-white border border-slate-200 rounded-xl p-4 mb-8 shadow-sm flex items-center justify-between sm:justify-around text-center select-none overflow-x-auto gap-4">
    <!-- Step 1 -->
    <div class="step-indicator active flex flex-col sm:flex-row items-center gap-2" id="ind-1">
        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition">1</span>
        <span class="text-xs font-semibold tracking-wide whitespace-nowrap text-slate-500">Pilih Keluhan</span>
    </div>
    <div class="h-px bg-slate-200 flex-1 hidden sm:block"></div>
    
    <!-- Step 2 -->
    <div class="step-indicator flex flex-col sm:flex-row items-center gap-2" id="ind-2">
        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition">2</span>
        <span class="text-xs font-semibold tracking-wide whitespace-nowrap text-slate-500">Pilih Dokter</span>
    </div>
    <div class="h-px bg-slate-200 flex-1 hidden sm:block"></div>

    <!-- Step 3 -->
    <div class="step-indicator flex flex-col sm:flex-row items-center gap-2" id="ind-3">
        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition">3</span>
        <span class="text-xs font-semibold tracking-wide whitespace-nowrap text-slate-500">Tanggal & Waktu</span>
    </div>
    <div class="h-px bg-slate-200 flex-1 hidden sm:block"></div>

    <!-- Step 4 -->
    <div class="step-indicator flex flex-col sm:flex-row items-center gap-2" id="ind-4">
        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition">4</span>
        <span class="text-xs font-semibold tracking-wide whitespace-nowrap text-slate-500">Konfirmasi</span>
    </div>
</div>

<!-- Main Form Wizard Container -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden p-6 sm:p-8 max-w-3xl">
    <form id="booking-form" action="{{ route('patient.booking.store') }}" method="POST" class="flex flex-col gap-6">
        @csrf

        <!-- ==============================================
             STEP 1: PILIH KELUHAN
             ============================================== -->
        <div id="step-panel-1" class="wizard-panel flex flex-col gap-4">
            <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Langkah 1: Apa yang Anda Rasakan?</h2>
            
            <div class="flex flex-col gap-2">
                <label for="complaint_id" class="text-sm font-semibold text-slate-700">Pilih Jenis Keluhan / Gejala Utama</label>
                <select name="complaint_id" id="complaint_id" required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-blue-500 focus:outline-none bg-white text-sm">
                    <option value="" disabled selected>-- Pilih Gejala/Keluhan Anda --</option>
                    @foreach($complaints as $complaint)
                        <option value="{{ $complaint->id }}">{{ $complaint->name }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-400 mt-1">Sistem akan secara otomatis menyaring dokter dengan spesialisasi yang sesuai dengan keluhan Anda.</p>
            </div>
        </div>

        <!-- ==============================================
             STEP 2: PILIH DOKTER (DYNAMICALLY LOADED VIA AJAX)
             ============================================== -->
        <div id="step-panel-2" class="wizard-panel hidden flex flex-col gap-4">
            <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Langkah 2: Pilih Dokter Spesialis</h2>
            
            <!-- Hidden Doctor input to bind select event -->
            <input type="hidden" name="doctor_id" id="doctor_id" required>

            <!-- Loading overlay state -->
            <div id="doctor-loading" class="hidden flex flex-col items-center justify-center p-8 gap-3">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <span class="text-sm text-slate-500">Mencari dokter yang tersedia...</span>
            </div>

            <!-- Doctor grid list cards -->
            <div id="doctor-container" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Rendered Dynamically via public/js/booking.js -->
            </div>
            
            <!-- Error / Empty doctors results -->
            <div id="doctor-empty" class="hidden p-8 text-center text-slate-500 text-sm border border-dashed border-slate-200 rounded-xl">
                Dokter tidak tersedia untuk keluhan ini.
            </div>
        </div>

        <!-- ==============================================
             STEP 3: TANGGAL & WAKTU BOOKING
             ============================================== -->
        <div id="step-panel-3" class="wizard-panel hidden flex flex-col gap-4">
            <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Langkah 3: Tentukan Tanggal & Jam</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Date input -->
                <div class="flex flex-col gap-1.5">
                    <label for="booking_date" class="text-sm font-semibold text-slate-700">Tanggal Kunjungan</label>
                    <input type="date" name="booking_date" id="booking_date" min="{{ date('Y-m-d') }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-blue-500 focus:outline-none text-sm">
                </div>

                <!-- Time input -->
                <div class="flex flex-col gap-1.5">
                    <label for="booking_time" class="text-sm font-semibold text-slate-700">Jam Kunjungan</label>
                    <input type="time" name="booking_time" id="booking_time" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-blue-500 focus:outline-none text-sm">
                </div>
            </div>
        </div>

        <!-- ==============================================
             STEP 4: KONFIRMASI RINGKASAN & HARGA
             ============================================== -->
        <div id="step-panel-4" class="wizard-panel hidden flex flex-col gap-4">
            <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Langkah 4: Ringkasan & Harga</h2>
            
            <div class="p-5 bg-slate-50 border border-slate-200 rounded-xl flex flex-col gap-4 text-sm text-slate-600">
                <div class="flex justify-between border-b border-slate-100 pb-2">
                    <span class="font-semibold text-slate-400">Keluhan / Gejala</span>
                    <span id="summary-complaint" class="font-bold text-slate-800"></span>
                </div>
                
                <div class="flex justify-between border-b border-slate-100 pb-2">
                    <span class="font-semibold text-slate-400">Dokter Spesialis</span>
                    <div class="text-right">
                        <div id="summary-doctor-name" class="font-bold text-slate-800"></div>
                        <div id="summary-doctor-spec" class="text-xs text-slate-400"></div>
                    </div>
                </div>

                <div class="flex justify-between border-b border-slate-100 pb-2">
                    <span class="font-semibold text-slate-400">Jadwal Praktek</span>
                    <span id="summary-doctor-schedule" class="font-medium text-slate-800"></span>
                </div>

                <div class="flex justify-between border-b border-slate-100 pb-3">
                    <span class="font-semibold text-slate-400">Jadwal Kunjungan Anda</span>
                    <div class="text-right">
                        <span id="summary-booking-datetime" class="font-bold text-slate-850"></span>
                    </div>
                </div>

                <!-- Price Details Breakdown -->
                <div class="flex justify-between text-slate-500">
                    <span>Tarif Konsultasi</span>
                    <span id="summary-consultation-fee" class="font-semibold text-slate-800"></span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-3 text-slate-500">
                    <span>Biaya Admin</span>
                    <span id="summary-admin-fee" class="font-semibold text-slate-800"></span>
                </div>

                <!-- Total Fee -->
                <div class="flex justify-between pt-1 text-slate-900 font-bold text-base">
                    <span>TOTAL</span>
                    <span id="summary-total-fee" class="text-blue-600"></span>
                </div>
            </div>

            <!-- Payment instruction notes -->
            <p class="text-xs text-slate-500 italic mt-1">
                *Pembayaran dilakukan di klinik saat kunjungan
            </p>

            <div class="p-3 bg-blue-50 text-blue-800 border border-blue-100 text-xs rounded-lg font-medium">
                Pendaftaran booking ini memiliki status awal "menunggu" sampai dikonfirmasi oleh staf administrasi kami.
            </div>
        </div>

        <!-- ==============================================
             WIZARD NAVIGATION CONTROLS
             ============================================== -->
        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <!-- Back Button -->
            <button type="button" id="prev-btn" class="hidden px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                Kembali
            </button>
            
            <div class="flex-1"></div>

            <!-- Next Button -->
            <button type="button" id="next-btn" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-bold shadow hover:bg-blue-700 transition">
                Lanjutkan
            </button>

            <!-- Submit Confirm Button -->
            <button type="submit" id="submit-btn" class="hidden px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                Konfirmasi Booking
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/booking.js') }}"></script>
@endpush
