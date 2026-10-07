<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') - SiKlinik</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Global CSS -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    
    <!-- Auth CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    
    <!-- Page Specific CSS File -->
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-blue-500 via-sky-100 to-white font-sans text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200/55 shadow-2xl p-6 sm:p-8 flex flex-col gap-6 transition duration-300">
        
        <!-- App Title and Brand -->
        <div class="flex flex-col items-center text-center gap-2">
            <span class="p-3 bg-blue-600 rounded-2xl text-white shadow-xl shadow-blue-100">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 10.5V20a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-9.5m14 0V9a2 2 0 0 0-2-2h-3.5m5 3.5V5a2 2 0 0 0-2-2h-3.5M12 3v14m-7-7h14" />
                </svg>
            </span>
            <h1 class="text-2xl font-extrabold text-blue-900 tracking-tight mt-2">SiKlinik</h1>
            <p class="text-sm text-slate-500">Sistem Informasi Klinik Sederhana</p>
        </div>

        <!-- Success and Error Session Banner -->
        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-green-50 border border-green-200 text-green-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <svg class="h-4 w-4 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <svg class="h-4 w-4 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Auth Content Area -->
        @yield('content')
    </div>

    <!-- Global JS -->
    <script src="{{ asset('js/global.js') }}"></script>
    
    <!-- Auth JS -->
    <script src="{{ asset('js/auth.js') }}"></script>
    
    <!-- Page Specific JS File -->
    @stack('scripts')
</body>
</html>
