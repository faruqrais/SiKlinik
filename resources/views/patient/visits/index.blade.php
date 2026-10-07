@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan Medis')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Riwayat Kunjungan & Rekam Medis</h1>
    <p class="text-sm text-slate-500">Daftar lengkap seluruh kunjungan, diagnosa, dan terapi obat yang pernah Anda terima.</p>
</div>

<!-- Table Card -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    @if($visits->isEmpty())
        <div class="p-12 text-center text-slate-500 text-sm">
            <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Anda belum memiliki riwayat rekam medis (kunjungan) terdaftar di klinik kami.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3">Tanggal Pemeriksaan</th>
                        <th class="px-6 py-3">Dokter Pemeriksa</th>
                        <th class="px-6 py-3">Keluhan Fisik</th>
                        <th class="px-6 py-3">Diagnosa & Terapi</th>
                        <th class="px-6 py-3 text-center">Struk Booking</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($visits as $visit)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900">
                                {{ $visit->visit_date ? $visit->visit_date->format('d-m-Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-semibold text-slate-800">{{ $visit->doctor->name ?? 'Dokter' }}</div>
                                <div class="text-xs text-slate-400">Spesialisasi: {{ $visit->doctor->specialization ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 max-w-xs whitespace-pre-wrap text-slate-600 font-medium">
                                {{ $visit->complaint }}
                            </td>
                            <td class="px-6 py-4 max-w-xs whitespace-pre-wrap text-blue-900 font-semibold bg-blue-50/20">
                                {{ $visit->diagnosis }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($visit->booking_code)
                                    <a href="{{ route('patient.booking.struk', $visit->booking_code) }}" 
                                       class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 text-xs font-bold rounded-lg transition inline-block" 
                                       title="Lihat Struk">
                                        Lihat Struk
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 font-semibold">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $visits->links() }}
        </div>
    @endif
</div>
@endsection
