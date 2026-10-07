<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Selamat Datang') - SiKlinik</title>
    
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
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Content slot -->
    <div class="flex-grow">
        @yield('content')
    </div>

    <!-- Global Footer -->
    @include('layouts.partials.footer')

    <!-- Global Custom JS File (Strictly external, no inline scripts) -->
    <script src="{{ asset('js/global.js') }}"></script>
    
    <!-- Page Specific JS File (Optional script slot) -->
    @stack('scripts')
</body>
</html>
