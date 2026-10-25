<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Display the webcam attendance kiosk view.
     */
    public function index(): View
    {
        return view('attendance.index', [
            'currentTime' => now()->format('H:i:s'),
            'currentDate' => now()->translatedFormat('l, d F Y'),
            'activeShift' => [
                'name' => 'Shift Reguler',
                'startTime' => '08:00',
                'endTime' => '17:00',
                'office' => 'Kantor Pusat',
            ],
        ]);
    }

    /**
     * Handle attendance check-in with snapshot verification.
     */
    public function checkIn(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'photo' => ['required', 'image', 'max:5120'], // Max 5MB
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $path = $request->file('photo')->store('presensi/snapshots/'.now()->format('Y-m-d'), 'public');

        return response()->json([
            'success' => true,
            'message' => 'Absen masuk berhasil dicatat!',
            'type' => 'in',
            'timestamp' => now()->format('H:i:s'),
            'date' => now()->format('Y-m-d'),
            'photo_url' => asset('storage/'.$path),
        ]);
    }

    /**
     * Handle attendance check-out with snapshot verification.
     */
    public function checkOut(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'photo' => ['required', 'image', 'max:5120'], // Max 5MB
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $path = $request->file('photo')->store('presensi/snapshots/'.now()->format('Y-m-d'), 'public');

        return response()->json([
            'success' => true,
            'message' => 'Absen pulang berhasil dicatat!',
            'type' => 'out',
            'timestamp' => now()->format('H:i:s'),
            'date' => now()->format('Y-m-d'),
            'photo_url' => asset('storage/'.$path),
        ]);
    }
}
