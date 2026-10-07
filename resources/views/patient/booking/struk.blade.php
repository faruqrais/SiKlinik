@extends('layouts.app')

@section('title', 'Bukti Booking Kunjungan')

@push('styles')
    <!-- Print CSS style sheet -->
    <link rel="stylesheet" href="{{ asset('css/struk.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 no-print">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Bukti Pendaftaran Booking</h1>
    <p class="text-sm text-slate-500">Gunakan struk bukti booking ini saat kedatangan Anda di klinik.</p>
</div>

<!-- Container for Centered Receipt -->
<div class="flex flex-col items-center justify-center py-4 sm:py-8">
    
    <!-- Thermal Receipt Card -->
    <div class="struk-container w-full max-w-md bg-white border border-slate-200 rounded-2xl shadow-lg p-6 sm:p-8 relative overflow-hidden text-slate-800 font-mono text-sm leading-relaxed">
        
        <!-- Ticket Cutout circles for aesthetic styling -->
        <div class="absolute left-0 top-1/2 w-4 h-8 bg-slate-50 border-r border-t border-b border-slate-200 rounded-r-full -translate-y-1/2 no-print"></div>
        <div class="absolute right-0 top-1/2 w-4 h-8 bg-slate-50 border-l border-t border-b border-slate-200 rounded-l-full -translate-y-1/2 no-print"></div>

        <!-- Receipt Header -->
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold tracking-wider text-slate-950 flex items-center justify-center gap-1">
                🏥 SiKlinik
            </h2>
            <p class="text-xs text-slate-500 mt-1 font-sans">Sistem Informasi Klinik</p>
            <p class="text-xs text-slate-400 font-sans">Jl. Kesehatan No.12, Banda Aceh</p>
            <p class="text-xs text-slate-400 font-sans">(0651) 123-4567</p>
        </div>

        <!-- Divider -->
        <div class="border-b border-dashed border-slate-200 my-4"></div>

        <!-- Receipt Title -->
        <div class="text-center font-bold text-slate-900 mb-4 tracking-wide uppercase">
            BUKTI BOOKING KUNJUNGAN
        </div>

        <!-- Meta Info -->
        <div class="flex flex-col gap-1.5 text-xs text-slate-600 mb-4">
            <div class="flex justify-between">
                <span>Kode Booking</span>
                <span class="font-bold text-slate-900">{{ $booking->booking_code }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal Cetak</span>
                <span class="font-medium text-slate-800">{{ now()->translatedFormat('d F Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Status</span>
                <span class="font-bold text-blue-600">
                    @if($booking->status === 'menunggu')
                        Menunggu Konfirmasi
                    @elseif($booking->status === 'dikonfirmasi')
                        Dikonfirmasi
                    @elseif($booking->status === 'selesai')
                        Selesai
                    @elseif($booking->status === 'dibatalkan')
                        Dibatalkan
                    @else
                        {{ ucfirst($booking->status) }}
                    @endif
                </span>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-b border-dashed border-slate-200 my-4"></div>

        <!-- Patient Info -->
        <div class="mb-4">
            <div class="font-bold text-slate-900 mb-2 uppercase text-xs tracking-wider">DATA PASIEN</div>
            <div class="flex flex-col gap-1 text-xs text-slate-600">
                <div class="flex">
                    <span class="w-20 shrink-0">Nama</span>
                    <span class="mr-2">:</span>
                    <span class="font-semibold text-slate-800">{{ $booking->patient->name ?? 'Pasien' }}</span>
                </div>
                <div class="flex">
                    <span class="w-20 shrink-0">NIK</span>
                    <span class="mr-2">:</span>
                    <span class="font-medium text-slate-800">{{ $booking->patient->nik ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-b border-dashed border-slate-200 my-4"></div>

        <!-- Appointment Info -->
        <div class="mb-4">
            <div class="font-bold text-slate-900 mb-2 uppercase text-xs tracking-wider">DETAIL KUNJUNGAN</div>
            <div class="flex flex-col gap-1 text-xs text-slate-600">
                <div class="flex items-start">
                    <span class="w-24 shrink-0">Keluhan</span>
                    <span class="mr-2">:</span>
                    <span class="font-semibold text-slate-800">{{ $booking->complaint }}</span>
                </div>
                <div class="flex">
                    <span class="w-24 shrink-0">Dokter</span>
                    <span class="mr-2">:</span>
                    <span class="font-semibold text-slate-800">{{ $booking->doctor->name ?? '-' }}</span>
                </div>
                <div class="flex">
                    <span class="w-24 shrink-0">Spesialisasi</span>
                    <span class="mr-2">:</span>
                    <span class="font-medium text-slate-800">{{ $booking->doctor->specialization ?? '-' }}</span>
                </div>
                <div class="flex">
                    <span class="w-24 shrink-0">Tanggal</span>
                    <span class="mr-2">:</span>
                    <span class="font-semibold text-slate-800">
                        @php
                            $days = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
                            $months = ['Jan' => 'Jun', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr', 'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Agu', 'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'];
                            
                            $carbonDate = \Carbon\Carbon::parse($booking->booking_date);
                            $dayName = $days[$carbonDate->format('l')] ?? $carbonDate->format('l');
                            $dayNum = $carbonDate->format('j');
                            $monthName = $months[$carbonDate->format('M')] ?? $carbonDate->format('M');
                            $year = $carbonDate->format('Y');
                            $formattedDate = "{$dayName}, {$dayNum} {$monthName} {$year}";
                        @endphp
                        {{ $formattedDate }}
                    </span>
                </div>
                <div class="flex">
                    <span class="w-24 shrink-0">Waktu</span>
                    <span class="mr-2">:</span>
                    <span class="font-semibold text-slate-800">{{ $booking->booking_time ? substr($booking->booking_time, 0, 5) : '-' }} WIB</span>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-b border-dashed border-slate-200 my-4"></div>

        <!-- Pricing Info -->
        <div class="mb-4">
            <div class="font-bold text-slate-900 mb-2 uppercase text-xs tracking-wider">RINCIAN BIAYA</div>
            <div class="flex flex-col gap-1.5 text-xs text-slate-600">
                <div class="flex justify-between">
                    <span>Tarif Konsultasi</span>
                    <span class="font-semibold text-slate-800">Rp {{ number_format($booking->consultation_fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Biaya Admin</span>
                    <span class="font-semibold text-slate-800">Rp {{ number_format($booking->admin_fee, 0, ',', '.') }}</span>
                </div>
                <!-- Mini Solid Line -->
                <div class="border-b border-slate-200 my-1"></div>
                <div class="flex justify-between text-sm font-bold text-slate-900">
                    <span>TOTAL</span>
                    <span>Rp {{ number_format($booking->total_fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mt-1 text-[11px] text-slate-500">
                    <span>Metode Bayar</span>
                    <span class="font-semibold uppercase">Bayar di Klinik</span>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-b border-dashed border-slate-200 my-4"></div>

        <!-- Footer Message -->
        <div class="text-center text-xs text-slate-500 mt-6 leading-relaxed font-sans">
            <p>Harap tunjukkan bukti ini</p>
            <p>kepada petugas saat tiba di klinik</p>
            <p class="mt-4 font-semibold text-slate-650">Terima kasih telah mempercayakan</p>
            <p class="font-semibold text-slate-650">kesehatan Anda kepada SiKlinik 🙏</p>
        </div>

    </div>

    <!-- Action Buttons (Hidden on Print) -->
    <div class="btn-actions-container no-print mt-8 flex flex-col sm:flex-row gap-3 w-full max-w-md">
        <!-- Download PDF Button -->
        <a href="{{ route('patient.booking.download_pdf', $booking->booking_code) }}" 
           class="flex-1 flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Download PDF
        </a>

        <!-- Print Button -->
        <button id="print-receipt-btn" 
                class="flex-1 flex items-center justify-center gap-2 px-5 py-3 bg-white hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-bold border border-slate-300 transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Struk
        </button>

        <!-- Dashboard Link -->
        <a href="{{ route('patient.dashboard') }}" 
           class="flex-1 flex items-center justify-center gap-2 px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-bold transition">
            Kembali ke Dashboard
        </a>
    </div>

</div>
@endsection
