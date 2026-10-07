<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Portal') - SiKlinik</title>
    
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
                    colors: {
                        clinic: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Tabler Icons Webfont CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <!-- Global Custom CSS File (Strictly external, no inline styles) -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    
    <!-- Footer Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    
    <!-- Page Specific CSS File (Optional style slot) -->
    @stack('styles')
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="px-4 sm:px-6 lg:px-8 flex h-16 items-center justify-between">
            <!-- Brand Logo -->
            <div class="flex items-center gap-2">
                <span class="p-2 bg-blue-600 rounded-lg text-white shadow-md shadow-blue-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 10.5V20a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-9.5m14 0V9a2 2 0 0 0-2-2h-3.5m5 3.5V5a2 2 0 0 0-2-2h-3.5M12 3v14m-7-7h14" />
                    </svg>
                </span>
                <span class="text-xl font-bold tracking-tight text-blue-900">SiKlinik</span>
            </div>

            <!-- User Info Badge & Mobile Menu Toggler -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                    <span class="text-xs font-medium px-2 py-0.5 self-end rounded-full bg-blue-100 text-blue-800 capitalize">{{ Auth::user()->role }}</span>
                </div>
                
                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-slate-100 transition-colors" title="Keluar">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1" />
                        </svg>
                    </button>
                </form>

                <!-- Mobile Menu Button (Hamburger) -->
                <button id="mobile-menu-btn" class="sm:hidden p-2 text-slate-500 rounded-lg hover:bg-slate-100" aria-label="Toggle Menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <div class="flex flex-1 relative">
        <!-- Sidebar Navigation -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-200 pt-16 transform -translate-x-full transition-transform duration-300 ease-in-out sm:relative sm:translate-x-0 sm:pt-0 sm:z-0 flex flex-col justify-between shrink-0 shadow-sm">
            <div class="p-4 flex flex-col gap-1.5 overflow-y-auto">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Navigasi Utama</p>

                <!-- Admin Links -->
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Request::is('admin/dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('doctors.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Request::is('admin/doctors*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Data Dokter
                </a>

                <a href="{{ route('patients.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Request::is('admin/patients*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Data Pasien
                </a>

                <a href="{{ route('visits.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Request::is('admin/visits*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Kunjungan Pasien
                </a>

                <a href="{{ route('admin.bookings.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ Request::is('admin/bookings*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Kelola Booking
                </a>
            </div>

            <!-- Footer Badge -->
            <div class="p-4 border-t border-slate-100 text-center text-xs text-slate-400">
                &copy; 2026 SiKlinik App.
            </div>
        </aside>

        <!-- Overlay for mobile sidebar -->
        <div id="sidebar-overlay" class="hidden fixed inset-0 z-20 bg-slate-900/40 backdrop-blur-sm sm:hidden"></div>

        <!-- Main Content Area -->
        <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 overflow-y-auto flex flex-col justify-between">
            <div>
                <!-- Session Flash Alerts -->
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 flex items-start gap-3 shadow-sm transition duration-300">
                        <svg class="h-5 w-5 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm font-medium">{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 flex items-start gap-3 shadow-sm transition duration-300">
                        <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="text-sm font-medium">{{ session('error') }}</div>
                    </div>
                @endif

                @yield('content')
            </div>

            <div class="mt-12">
                @include('layouts.partials.footer')
            </div>
        </main>
    </div>

    <!-- Global Custom JS File (Strictly external, no inline scripts) -->
    <script src="{{ asset('js/global.js') }}"></script>
    
    <!-- Page Specific JS File (Optional script slot) -->
    @stack('scripts')
</body>
</html>
