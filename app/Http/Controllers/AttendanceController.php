<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        return $this->processAttendance($request, 'in', 'Absen masuk berhasil dicatat!');
    }

    /**
     * Handle attendance check-out with snapshot verification.
     */
    public function checkOut(Request $request): JsonResponse
    {
        return $this->processAttendance($request, 'out', 'Absen pulang berhasil dicatat!');
    }

    /**
     * Shared logic to validate and store attendance photo snapshot.
     */
    protected function processAttendance(Request $request, string $type, string $successMessage): JsonResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'], // Max 5MB
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $path = $request->file('photo')->store('presensi/snapshots/'.now()->format('Y-m-d'), 'public');
        $photoUrl = Storage::disk('public')->url($path);

        return response()->json([
            'success' => true,
            'message' => $successMessage,
            'type' => $type,
            'timestamp' => now()->format('H:i:s'),
            'date' => now()->format('Y-m-d'),
            'photo_url' => $photoUrl,
        ]);
    }
}
