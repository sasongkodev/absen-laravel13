<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('presensi index page can be rendered', function () {
    $response = $this->get('/presensi');
    $response->assertStatus(200);
    $response->assertSee('Presensi');
});

test('check in requires photo capture', function () {
    $response = $this->postJson('/presensi/check-in', []);
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['photo']);
});

test('check in successfully accepts photo upload', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('webcam.jpg');
    $response = $this->postJson('/presensi/check-in', [
        'photo' => $file,
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
        'message' => 'Absen masuk berhasil dicatat!',
    ]);
});

test('check out successfully accepts photo upload', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('webcam_out.jpg');
    $response = $this->postJson('/presensi/check-out', [
        'photo' => $file,
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
        'message' => 'Absen pulang berhasil dicatat!',
    ]);
});
