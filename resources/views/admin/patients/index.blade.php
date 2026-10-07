@extends('layouts.admin')

@section('title', 'Daftar Pasien')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 sm:flex sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Data Pasien</h1>
        <p class="text-sm text-slate-500">Kelola semua profil pasien klinik dan rekam medis mereka.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('patients.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pasien
        </a>
    </div>
</div>

<!-- Data Table Card -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    @if($patients->isEmpty())
        <div class="p-12 text-center text-slate-500 text-sm">
            <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Belum ada data pasien terdaftar. Silakan tambahkan pasien baru.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3">Nama Lengkap</th>
                        <th class="px-6 py-3">NIK</th>
                        <th class="px-6 py-3">Tanggal Lahir</th>
                        <th class="px-6 py-3">Nomor HP</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($patients as $patient)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-slate-900">
                                {{ $patient->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-slate-600 text-xs">
                                {{ $patient->nik }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $patient->birth_date ? $patient->birth_date->format('d-m-Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $patient->phone }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- View Profile & Visits History -->
                                    <a href="{{ route('patients.show', $patient->id) }}" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition" title="Rekam Medis">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </a>
                                    <!-- Edit -->
                                    <a href="{{ route('patients.edit', $patient->id) }}" class="p-1.5 text-slate-500 hover:text-amber-600 rounded-lg hover:bg-slate-100 transition" title="Edit">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <!-- Delete Button -->
                                    <button type="button" class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg hover:bg-slate-100 transition delete-btn" data-url="{{ route('patients.destroy', $patient->id) }}" data-name="{{ $patient->name }}" title="Hapus">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $patients->links() }}
        </div>
    @endif
</div>

<!-- Soft Delete Confirmation Dialog -->
<div id="delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
    <div class="w-full max-w-md bg-white rounded-xl shadow-xl border border-slate-200 p-6 flex flex-col gap-4">
        <div class="flex items-center gap-3 text-red-600">
            <span class="p-2 rounded-lg bg-red-50">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </span>
            <h3 class="text-lg font-bold">Konfirmasi Hapus</h3>
        </div>
        <p class="text-sm text-slate-500">Apakah Anda yakin ingin menghapus data pasien <span id="delete-target-name" class="font-semibold text-slate-800"></span>? Rekam medis terkait akan ikut dinonaktifkan (soft-delete).</p>
        <div class="flex items-center justify-end gap-3 mt-2">
            <button id="cancel-delete-btn" type="button" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                Batal
            </button>
            <form id="delete-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-bold shadow transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/crud.js') }}"></script>
@endpush
