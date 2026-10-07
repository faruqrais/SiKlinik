@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Dashboard Admin</h1>
    <p class="text-sm text-slate-500">Ringkasan operasional harian SiKlinik.</p>
</div>

<!-- Stats Dashboard Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Doctors Widget -->
    <div class="bg-white border border-slate-200 rounded-xl p-6 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
        <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-slate-500">Total Dokter</span>
            <span class="text-3xl font-bold text-slate-900">{{ $totalDoctors }}</span>
        </div>
        <div class="p-4 rounded-xl bg-blue-50 text-blue-600">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
    </div>

    <!-- Patients Widget -->
    <div class="bg-white border border-slate-200 rounded-xl p-6 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
        <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-slate-500">Total Pasien</span>
            <span class="text-3xl font-bold text-slate-900">{{ $totalPatients }}</span>
        </div>
        <div class="p-4 rounded-xl bg-emerald-50 text-emerald-600">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
    </div>

    <!-- Today's Visits Widget -->
    <div class="bg-white border border-slate-200 rounded-xl p-6 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
        <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-slate-500">Kunjungan Hari Ini</span>
            <span class="text-3xl font-bold text-slate-900">{{ $todayVisits }}</span>
        </div>
        <div class="p-4 rounded-xl bg-sky-50 text-sky-600">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    </div>

    <!-- Today's Earnings Widget -->
    <div class="bg-white border border-slate-200 rounded-xl p-6 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
        <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-slate-500">Pendapatan Hari Ini</span>
            <span class="text-3xl font-bold text-slate-900">Rp {{ number_format($todayEarnings, 0, ',', '.') }}</span>
        </div>
        <div class="p-4 rounded-xl bg-amber-50 text-amber-600">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>

</div>

<!-- Recent Visits Table Card -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="text-lg font-bold text-slate-950">Aktivitas Kunjungan Terbaru</h2>
        <a href="{{ route('visits.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lihat Semua Kunjungan &rarr;</a>
    </div>

    @if($recentVisits->isEmpty())
        <div class="p-8 text-center text-slate-500 text-sm">
            Belum ada data kunjungan terbaru saat ini.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Pasien</th>
                        <th class="px-6 py-3">Dokter</th>
                        <th class="px-6 py-3">Keluhan</th>
                        <th class="px-6 py-3">Diagnosa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($recentVisits as $visit)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">
                                {{ $visit->visit_date ? $visit->visit_date->format('d-m-Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-semibold text-slate-800">{{ $visit->patient->name ?? 'Pasien Terhapus' }}</div>
                                <div class="text-xs text-slate-400">NIK: {{ $visit->patient->nik ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-semibold text-slate-800">{{ $visit->doctor->name ?? 'Dokter Terhapus' }}</div>
                                <div class="text-xs text-slate-400">Spesialis: {{ $visit->doctor->specialization ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate">
                                {{ $visit->complaint }}
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate">
                                {{ $visit->diagnosis }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
