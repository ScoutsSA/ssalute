<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-layout.head/>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen">
<!-- Top Navigation -->
<header class="sticky top-0 z-20 backdrop-blur supports-[backdrop-filter]:bg-white/70 bg-white/90 dark:supports-[backdrop-filter]:bg-[#0a0a0a]/70 dark:bg-[#0a0a0a]/90 border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
    <x-layout.nav/>
</header>

<main class="max-w-4xl mx-auto px-6 lg:px-8 py-8 lg:py-12">
    @yield('content')

    <footer class="mt-6 text-xs text-[#706f6c] dark:text-[#A1A09A] text-center">
        <p>&copy; {{ date('Y') }} Scouts South Africa • Ssalute</p>
    </footer>
</main>
</body>
</html>
