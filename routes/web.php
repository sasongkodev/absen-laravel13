<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AttendanceController::class, 'index'])->name('home');
Route::get('/presensi', [AttendanceController::class, 'index'])->name('presensi.index');

Route::prefix('presensi')->name('presensi.')->group(function () {
    Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('checkin');
    Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('checkout');
});
