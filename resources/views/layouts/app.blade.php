<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Presensi — Sistem Absensi Karyawan' }}</title>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral text-on-surface antialiased min-h-screen flex flex-col font-sans">
    <!-- Top Navbar (60px height) -->
    <header class="bg-surface border-b border-neutral-strong h-[60px] sticky top-0 z-40 flex items-center justify-between px-4 sm:px-6 shadow-[0_1px_2px_0_rgba(16,32,31,0.06)]">
        <div class="flex items-center gap-3">
            <a href="{{ route('presensi.index') }}" class="flex items-center gap-2.5 text-primary font-bold text-lg tracking-tight focus:outline-none focus:ring-2 focus:ring-primary rounded">
                <span class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold text-base shadow-sm">
                    P
                </span>
                <span>Presensi</span>
            </a>
            <span class="hidden sm:inline-block text-xs font-semibold px-2 py-0.5 rounded-full bg-primary-subtle text-primary">
                Kiosk Mode
            </span>
        </div>

        <!-- Clock & User Status -->
        <div class="flex items-center gap-4 text-sm">
            <div class="text-right hidden sm:block">
                <div id="live-clock" class="font-bold text-on-surface tabular text-base tracking-wide">
                    {{ $currentTime ?? now()->format('H:i:s') }} <span class="text-xs text-on-surface-muted font-medium">WIB</span>
                </div>
                <div class="text-xs text-on-surface-muted">
                    {{ $currentDate ?? now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
            <div class="h-8 w-px bg-neutral-strong hidden sm:block"></div>
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-full bg-secondary text-on-secondary flex items-center justify-center font-semibold text-sm">
                    AF
                </div>
                <div class="text-left hidden md:block">
                    <div class="font-semibold text-xs text-on-surface">Ahmad Fauzi</div>
                    <div class="text-[11px] text-on-surface-muted">Staff Operasional</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 w-full max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8 flex flex-col justify-center">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-neutral-strong py-3 text-center text-xs text-on-surface-muted">
        Presensi &bull; Sistem Absensi Berbasis Webcam &bull; Standar WCAG 2.1 AA
    </footer>

    <!-- Global Toast Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none"></div>

    @stack('scripts')
</body>
</html>
