@extends('layouts.admin')

@section('title', 'Kelola Booking')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kelola Booking Kunjungan</h1>
    <p class="text-sm text-slate-500">Konfirmasi jadwal pemeriksaan pasien, perbarui status booking, dan kelola alur kedatangan pasien.</p>
</div>

<!-- Filters Panel -->
<div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 mb-8 shadow-sm flex flex-col sm:flex-row sm:items-end gap-4">
    <form action="{{ route('admin.bookings.index') }}" method="GET" class="w-full flex flex-col sm:flex-row sm:items-end gap-4">
        
        <!-- Filter Status -->
        <div class="flex-1 flex flex-col gap-1.5">
            <label for="status" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Booking</label>
            <select name="status" id="status"
                class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-blue-500 focus:outline-none text-sm bg-white">
                <option value="">-- Semua Status --</option>
                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="dikonfirmasi" {{ request('status') === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>

        <!-- Filter Tanggal -->
        <div class="flex-1 flex flex-col gap-1.5">
            <label for="date" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal Kunjungan</label>
            <input type="date" name="date" id="date" value="{{ request('date') }}"
                class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-blue-500 focus:outline-none text-sm">
        </div>

        <!-- Search Actions Buttons -->
        <div class="flex gap-2">
            <!-- Reset Button -->
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 text-sm font-semibold hover:bg-slate-50 transition text-center shrink-0">
                Reset
            </a>
            
            <!-- Submit Filter -->
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow transition shrink-0">
                Saring Data
            </button>
        </div>

    </form>
</div>

<!-- Data Table Card -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    @if($bookings->isEmpty())
        <div class="p-12 text-center text-slate-500 text-sm">
            <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Tidak ada data booking kunjungan ditemukan untuk penyaringan saat ini.
        </div>
    @else
        <div class="overflow-x-auto">
             <table class="w-full text-left text-sm text-slate-700">
                 <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                     <tr>
                         <th class="px-6 py-3">Kode Booking</th>
                         <th class="px-6 py-3">Nama Pasien</th>
                         <th class="px-6 py-3">Keluhan</th>
                         <th class="px-6 py-3">Dokter Pilihan</th>
                         <th class="px-6 py-3">Jadwal Kunjungan</th>
                         <th class="px-6 py-3">Total Biaya</th>
                         <th class="px-6 py-3 text-center">Status Bayar</th>
                         <th class="px-6 py-3">Status Booking</th>
                         <th class="px-6 py-3 text-center">Aksi / Tindakan</th>
                     </tr>
                 </thead>
                 <tbody class="divide-y divide-slate-100">
                     @foreach($bookings as $booking)
                         <tr class="hover:bg-slate-50 transition-colors">
                             <!-- Booking Code -->
                             <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-bold text-slate-800">
                                 {{ $booking->booking_code ?? '-' }}
                             </td>

                             <!-- Patient Details -->
                             <td class="px-6 py-4 whitespace-nowrap">
                                 <div class="font-bold text-slate-900">{{ $booking->patient->name ?? 'Pasien Terhapus' }}</div>
                                 <div class="text-xs text-slate-400 font-mono">NIK: {{ $booking->patient->nik ?? '-' }}</div>
                             </td>
                             
                             <!-- Complaint -->
                             <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">
                                 {{ $booking->complaint }}
                             </td>
                             
                             <!-- Doctor -->
                             <td class="px-6 py-4 whitespace-nowrap">
                                 <div class="font-semibold text-slate-800">{{ $booking->doctor->name ?? 'Dokter Terhapus' }}</div>
                                 <div class="text-xs text-slate-400">{{ $booking->doctor->specialization ?? '-' }}</div>
                             </td>
                             
                             <!-- Booking Schedule -->
                             <td class="px-6 py-4 whitespace-nowrap">
                                 <div class="font-semibold text-slate-900">{{ $booking->booking_date ? $booking->booking_date->format('d-m-Y') : '-' }}</div>
                                 <div class="text-xs text-slate-500 font-medium">Jam: {{ $booking->booking_time ? substr($booking->booking_time, 0, 5) : '-' }} WIB</div>
                             </td>

                             <!-- Total Cost -->
                             <td class="px-6 py-4 whitespace-nowrap font-semibold text-slate-850">
                                 @if($booking->total_fee)
                                     Rp {{ number_format($booking->total_fee, 0, ',', '.') }}
                                 @else
                                     -
                                 @endif
                             </td>

                             <!-- Payment Status Badge -->
                             <td class="px-6 py-4 whitespace-nowrap text-center">
                                 @if($booking->payment_status === 'sudah_bayar')
                                     <span class="px-2.5 py-0.5 rounded-full bg-green-100 text-green-800 text-xs font-bold capitalize">Sudah Bayar</span>
                                 @else
                                     <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 text-xs font-bold capitalize">Belum Bayar</span>
                                 @endif
                             </td>
                             
                             <!-- Booking Status Badge -->
                             <td class="px-6 py-4 whitespace-nowrap">
                                 @if($booking->status === 'menunggu')
                                     <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold capitalize">Menunggu</span>
                                 @elseif($booking->status === 'dikonfirmasi')
                                     <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-xs font-bold capitalize">Dikonfirmasi</span>
                                 @elseif($booking->status === 'selesai')
                                     <span class="px-2.5 py-0.5 rounded-full bg-green-100 text-green-800 text-xs font-bold capitalize">Selesai</span>
                                 @elseif($booking->status === 'dibatalkan')
                                     <span class="px-2.5 py-0.5 rounded-full bg-red-100 text-red-800 text-xs font-bold capitalize">Dibatalkan</span>
                                 @endif
                             </td>

                             <!-- Action status & Payment status togglers -->
                             <td class="px-6 py-4 whitespace-nowrap text-center">
                                 <div class="flex items-center justify-center gap-1.5">
                                     <!-- Confirm Status -->
                                     @if($booking->status === 'menunggu')
                                         <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST" class="inline">
                                             @csrf
                                             @method('PATCH')
                                             <input type="hidden" name="status" value="dikonfirmasi">
                                             <button type="submit" class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition" title="Konfirmasi">
                                                 Konfirmasi
                                             </button>
                                         </form>
                                         
                                         <!-- Cancel Status -->
                                         <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST" class="inline">
                                             @csrf
                                             @method('PATCH')
                                             <input type="hidden" name="status" value="dibatalkan">
                                             <button type="submit" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-bold rounded-lg transition" title="Batalkan">
                                                 Batalkan
                                             </button>
                                         </form>
                                     @elseif($booking->status === 'dikonfirmasi')
                                         <!-- Complete Status -->
                                         <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST" class="inline">
                                             @csrf
                                             @method('PATCH')
                                             <input type="hidden" name="status" value="selesai">
                                             <button type="submit" class="px-2.5 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition" title="Pemeriksaan Selesai">
                                                 Selesai Periksa
                                             </button>
                                         </form>
                                     @endif

                                     <!-- Confirm Payment Action -->
                                     @if($booking->booking_code && $booking->payment_status !== 'sudah_bayar')
                                         <form action="{{ route('admin.bookings.update_payment', $booking->id) }}" method="POST" class="inline">
                                             @csrf
                                             @method('PATCH')
                                             <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition" title="Tandai Sudah Bayar">
                                                 Tandai Sudah Bayar
                                             </button>
                                         </form>
                                     @endif

                                     @if($booking->status !== 'menunggu' && $booking->status !== 'dikonfirmasi' && (!$booking->booking_code || $booking->payment_status === 'sudah_bayar'))
                                         <span class="text-xs text-slate-400 font-semibold">-</span>
                                     @endif
                                 </div>
                             </td>
                         </tr>
                     @endforeach
                 </tbody>
             </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
