@extends('layouts.app')

@section('title', 'Riwayat Booking')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Riwayat Booking Kunjungan</h1>
        <p class="text-sm text-slate-500">Pantau dan kelola jadwal pemeriksaan medis Anda.</p>
    </div>
    <div>
        <a href="{{ route('patient.booking.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Booking Kunjungan Baru
        </a>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    @if($bookings->isEmpty())
        <div class="p-12 text-center text-slate-500 text-sm">
            <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Anda belum pernah melakukan booking kunjungan medis.
        </div>
    @else
        <div class="overflow-x-auto">
             <table class="w-full text-left text-sm text-slate-700">
                 <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                     <tr>
                         <th class="px-6 py-3 text-center">No</th>
                         <th class="px-6 py-3">Kode Booking</th>
                         <th class="px-6 py-3">Keluhan</th>
                         <th class="px-6 py-3">Dokter</th>
                         <th class="px-6 py-3 font-semibold">Jadwal Kunjungan</th>
                         <th class="px-6 py-3">Total Biaya</th>
                         <th class="px-6 py-3">Status Bayar</th>
                         <th class="px-6 py-3">Status Booking</th>
                         <th class="px-6 py-3 text-center">Aksi</th>
                     </tr>
                 </thead>
                 <tbody class="divide-y divide-slate-100">
                     @foreach($bookings as $index => $booking)
                         <tr class="hover:bg-slate-50 transition-colors">
                             <!-- Numbering -->
                             <td class="px-6 py-4 whitespace-nowrap text-center font-semibold text-slate-500">
                                 {{ $bookings->firstItem() + $index }}
                             </td>
                             
                             <!-- Booking Code -->
                             <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-bold text-slate-800">
                                 {{ $booking->booking_code ?? '-' }}
                             </td>
                             
                             <!-- Complaint -->
                             <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">
                                 {{ $booking->complaint }}
                             </td>
                             
                             <!-- Doctor -->
                             <td class="px-6 py-4 whitespace-nowrap">
                                 <div class="font-semibold text-slate-800">{{ $booking->doctor->name ?? 'Dokter' }}</div>
                                 <div class="text-xs text-slate-400">{{ $booking->doctor->specialization ?? '-' }}</div>
                             </td>
                             
                             <!-- Schedule DateTime -->
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

                             <!-- Payment Status -->
                             <td class="px-6 py-4 whitespace-nowrap">
                                 @if($booking->payment_status === 'sudah_bayar')
                                     <span class="px-2.5 py-0.5 rounded-full bg-green-150 text-green-800 text-xs font-bold capitalize">Sudah Bayar</span>
                                 @else
                                     <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 text-xs font-bold capitalize">Belum Bayar</span>
                                 @endif
                             </td>

                             <!-- Booking Status -->
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

                             <!-- Actions -->
                             <td class="px-6 py-4 whitespace-nowrap text-center">
                                 <div class="flex items-center justify-center gap-1.5">
                                     <!-- View Receipt Button -->
                                     @if($booking->booking_code)
                                         <a href="{{ route('patient.booking.struk', $booking->booking_code) }}" 
                                            class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 text-xs font-bold rounded-lg transition" 
                                            title="Lihat Struk">
                                             Lihat Struk
                                         </a>
                                     @endif

                                     <!-- Cancel Booking Button -->
                                     @if($booking->status === 'menunggu')
                                         <form action="{{ route('patient.booking.cancel', $booking->id) }}" method="POST" class="inline delete-form-confirm">
                                             @csrf
                                             @method('PATCH')
                                             <button type="submit" class="px-2.5 py-1 bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold rounded-lg border border-red-200 transition" title="Batalkan">
                                                 Batalkan
                                             </button>
                                         </form>
                                     @endif

                                     @if(!$booking->booking_code && $booking->status !== 'menunggu')
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
