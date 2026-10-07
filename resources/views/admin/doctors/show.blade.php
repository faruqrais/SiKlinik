@extends('layouts.admin')

@section('title', 'Profil Dokter')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6">
    <a href="{{ route('doctors.index') }}" class="text-sm font-semibold text-blue-600 hover:underline flex items-center gap-1 mb-2">&larr; Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Profil & Detail Dokter</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Profile Card (Left) -->
    <div class="lg:col-span-1 bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col items-center text-center gap-4">
        <div class="p-4 rounded-full bg-blue-50 text-blue-600">
            <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-bold text-slate-950">{{ $doctor->name }}</h2>
            <span class="px-3 py-0.5 self-center rounded-full bg-blue-100 text-blue-800 text-xs font-bold capitalize">{{ $doctor->specialization }}</span>
        </div>
        <div class="w-full border-t border-slate-100 pt-4 flex flex-col gap-3 text-left text-sm text-slate-600">
            <div class="flex flex-col gap-0.5">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jadwal Praktek</span>
                <span class="font-medium text-slate-800">{{ $doctor->schedule }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nomor Telepon</span>
                <span class="font-medium text-slate-800">{{ $doctor->phone }}</span>
            </div>
            <div class="flex flex-col gap-0.5">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Terdaftar Pada</span>
                <span class="font-medium text-slate-800">{{ $doctor->created_at ? $doctor->created_at->format('d M Y, H:i') : '-' }}</span>
            </div>
        </div>
        
        <div class="w-full flex items-center gap-2 mt-2">
            <a href="{{ route('doctors.edit', $doctor->id) }}" class="flex-1 py-2 text-center border border-slate-300 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition">
                Edit
            </a>
        </div>
    </div>

    <!-- Visits Log Card (Right) -->
    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden flex flex-col justify-between">
        <div>
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-950">Log Kunjungan Pasien</h3>
                <p class="text-xs text-slate-500">Daftar riwayat pemeriksaan yang ditangani oleh {{ $doctor->name }}.</p>
            </div>

            @if($visits->isEmpty())
                <div class="p-12 text-center text-slate-500 text-sm">
                    Dokter ini belum memiliki catatan riwayat kunjungan pasien.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700">
                        <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Nama Pasien</th>
                                <th class="px-6 py-3">Keluhan</th>
                                <th class="px-6 py-3">Diagnosa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($visits as $visit)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">
                                        {{ $visit->visit_date ? $visit->visit_date->format('d-m-Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $visit->patient->name ?? 'Pasien Terhapus' }}
                                    </td>
                                    <td class="px-6 py-4 max-w-xs truncate" title="{{ $visit->complaint }}">
                                        {{ $visit->complaint }}
                                    </td>
                                    <td class="px-6 py-4 max-w-xs truncate" title="{{ $visit->diagnosis }}">
                                        {{ $visit->diagnosis }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Pagination Links -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $visits->links() }}
        </div>
    </div>

</div>
@endsection
