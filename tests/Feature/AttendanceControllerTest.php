<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('root route can be rendered', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('Presensi');
});

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

test('check in rejects non-image files', function () {
    $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
    $response = $this->postJson('/presensi/check-in', [
        'photo' => $file,
    ]);
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['photo']);
});

test('check in rejects files exceeding maximum size', function () {
    $file = UploadedFile::fake()->image('huge.jpg')->size(6000); // 6MB
    $response = $this->postJson('/presensi/check-in', [
        'photo' => $file,
    ]);
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['photo']);
});

test('check in rejects non-numeric latitude or longitude', function () {
    $file = UploadedFile::fake()->image('webcam.jpg');
    $response = $this->postJson('/presensi/check-in', [
        'photo' => $file,
        'latitude' => 'not-a-number',
    ]);
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['latitude']);
});

test('check in successfully accepts photo upload', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('webcam.jpg');
    $response = $this->postJson('/presensi/check-in', [
        'photo' => $file,
        'latitude' => -6.2088,
        'longitude' => 106.8456,
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
