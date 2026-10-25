@extends('layouts.app')

@section('content')
<div class="w-full max-w-xl mx-auto">
    <!-- Active Shift & Location Card -->
    <div class="bg-surface rounded-lg border border-neutral-strong p-4 mb-4 shadow-[0_1px_2px_0_rgba(16,32,31,0.06)] flex items-center justify-between">
        <div>
            <div class="text-xs font-semibold uppercase tracking-wider text-on-surface-muted">
                Jadwal Kerja Aktif
            </div>
            <div class="text-sm sm:text-base font-bold text-on-surface flex items-center gap-2 mt-0.5">
                <span>{{ $activeShift['name'] }}</span>
                <span class="text-xs px-2 py-0.5 bg-neutral rounded tabular text-on-surface-muted">
                    {{ $activeShift['startTime'] }} - {{ $activeShift['endTime'] }}
                </span>
            </div>
        </div>
        <div class="text-right">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-success-subtle text-success">
                <span class="w-2 h-2 rounded-full bg-success animate-pulse"></span>
                {{ $activeShift['office'] }}
            </span>
        </div>
    </div>

    <!-- Main Webcam & Attendance Card -->
    <div class="bg-surface rounded-lg border border-neutral-strong p-5 sm:p-6 shadow-[0_1px_2px_0_rgba(16,32,31,0.06)]">
        <div class="flex items-center justify-between pb-3 mb-4 border-b border-neutral-strong">
            <h1 class="text-lg sm:text-xl font-bold text-on-surface flex items-center gap-2">
                <span>Absensi Wajah</span>
            </h1>
            <div id="camera-status-pill" class="text-xs font-semibold px-2.5 py-1 rounded-full bg-neutral text-on-surface-muted flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-yellow-500" id="camera-indicator"></span>
                <span id="camera-status-text">Menyiapkan Kamera...</span>
            </div>
        </div>

        <!-- Camera Error Notification Box (Hidden by default) -->
        <div id="camera-error-box" class="hidden mb-4 p-4 rounded-md bg-danger-subtle border border-danger text-danger text-sm">
            <div class="font-bold flex items-center gap-1.5 mb-1">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/></svg>
                <span>Akses Kamera Tidak Tersedia</span>
            </div>
            <p id="camera-error-message" class="text-xs text-danger mb-3 leading-relaxed">
                Browser belum diberikan izin kamera atau perangkat webcam tidak terdeteksi. Silakan berikan izin akses webcam pada browser Anda.
            </p>
            <button type="button" id="btn-retry-camera" class="touch-target px-4 py-2 bg-danger text-on-danger hover:bg-danger-hover rounded-md text-xs font-semibold transition inline-flex items-center gap-2">
                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/></svg>
                <span>Coba Lagi Akses Kamera</span>
            </button>
        </div>

        <!-- Camera Frame (4:3 aspect ratio, bg-camera-bg #10201F) -->
        <div class="relative w-full aspect-[4/3] bg-camera-bg rounded-lg overflow-hidden flex items-center justify-center border border-neutral-strong shadow-inner">
            <!-- Live Webcam Video Stream -->
            <video id="webcam-video" autoplay playsinline muted class="w-full h-full object-cover"></video>

            <!-- Oval Face Positioning Guide Overlay -->
            <div id="camera-guide-overlay" class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                <div class="w-44 h-56 sm:w-52 sm:h-64 border-2 border-dashed border-white/50 rounded-[50%] flex items-center justify-center">
                    <span class="text-xs text-white/80 font-medium px-4 text-center select-none bg-black/40 py-1 rounded backdrop-blur-xs">
                        Posisikan Wajah di Sini
                    </span>
                </div>
            </div>

            <!-- Snapshot Review Display (Hidden initially) -->
            <div id="snapshot-preview-container" class="hidden absolute inset-0 bg-camera-bg flex flex-col items-center justify-center p-3">
                <img id="snapshot-preview" src="" alt="Pratinjau Snapshot Foto" class="max-w-full max-h-full rounded-md object-contain border border-neutral-strong shadow-md">
                <div class="absolute bottom-3 left-3 right-3 bg-black/70 backdrop-blur-xs text-white text-xs px-3 py-1.5 rounded-md flex items-center justify-between">
                    <span id="snapshot-timestamp" class="tabular font-medium">--:--:-- WIB</span>
                    <span class="text-success-subtle font-semibold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span> Foto Siap Dikirim
                    </span>
                </div>
            </div>

            <!-- Hidden Canvas for frame snapshot capture -->
            <canvas id="webcam-canvas" class="hidden"></canvas>
        </div>

        <!-- Action Buttons Control Bar -->
        <div class="mt-5 flex flex-col gap-3">
            <!-- Initial State Controls: Capture Photo Button -->
            <div id="controls-capture" class="w-full">
                <button type="button" id="btn-capture" class="touch-target w-full bg-primary hover:bg-primary-hover active:bg-primary-active text-on-primary rounded-md font-semibold text-sm transition flex items-center justify-center gap-2 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M4 4h3l2-2h6l2 2h3a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm8 3a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z"/></svg>
                    <span>Ambil Foto Presensi</span>
                </button>
            </div>

            <!-- Post-Capture Controls: Retake & Submit (Hidden initially) -->
            <div id="controls-submit" class="hidden grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                <button type="button" id="btn-retake" class="touch-target sm:col-span-1 bg-surface border border-neutral-strong hover:bg-secondary-subtle text-secondary rounded-md font-semibold text-sm transition flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/></svg>
                    <span>Ulangi</span>
                </button>
                <button type="button" id="btn-checkin" class="touch-target sm:col-span-1 bg-primary hover:bg-primary-hover active:bg-primary-active text-on-primary rounded-md font-semibold text-sm transition flex items-center justify-center gap-1.5 shadow-sm disabled:opacity-50">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    <span>Absen Masuk</span>
                </button>
                <button type="button" id="btn-checkout" class="touch-target sm:col-span-1 bg-secondary hover:bg-secondary-hover text-on-secondary rounded-md font-semibold text-sm transition flex items-center justify-center gap-1.5 shadow-sm disabled:opacity-50">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/></svg>
                    <span>Absen Pulang</span>
                </button>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-neutral-strong text-center">
            <span class="text-xs text-on-surface-muted">
                Foto akan diverifikasi dan disimpan secara aman di server. Tidak ada foto disimpan di memori publik browser.
            </span>
        </div>
    </div>
</div>
@endsection
