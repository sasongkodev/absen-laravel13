# Webcam Presensi UI Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membangun antarmuka front-end presensi mandiri berbasis webcam (Opsi A: Kiosk Focus) menggunakan Laravel Blade, Tailwind CSS v4, dan native WebRTC API sesuai spesifikasi design token.

**Architecture:** Frontend menggunakan Blade template yang diperkaya Tailwind CSS v4 dengan token visual resmi (`#0E5C56`, `#F6F4F1`). Interaksi webcam memanfaatkan native browser `navigator.mediaDevices.getUserMedia` untuk streaming dan HTML5 Canvas untuk snapshot capture, dikirimkan secara asinkron via Fetch API ke `AttendanceController`.

**Tech Stack:** Laravel 12/13 (PHP 8.4), Blade, Tailwind CSS v4, Vite, Pest testing framework.

**Spec:** [`docs/superpowers/specs/2026-10-25-webcam-presensi-ui-design.md`](file:///home/wahyupuji/Desktop/front-dev/absen-laravel/docs/superpowers/specs/2026-10-25-webcam-presensi-ui-design.md)

## Global Constraints
- Token warna utama: `primary: #0E5C56`, `primary-hover: #0A4743`, `secondary: #3E4A49`, `neutral: #F6F4F1`, `surface: #FFFFFF`, `camera-bg: #10201F`.
- Target sentuh tombol dan input: minimal 44px (`touch-target`).
- Rasio aspek video kamera: 4:3 (640x480).
- Bebas library pihak ketiga dari CDN (tidak menggunakan plugin flash / `webcamjs` CDN legacy).
- Font numbers pada kolom jam dan tabel menggunakan fitur tabular `font-feature-settings: 'tnum' 1`.

## Review Focus
1. Izin kamera ditolak oleh pengguna: UI harus menampilkan status error peringatan berwarna merah/merah-muda dengan tombol coba lagi ("Aktifkan Izin Kamera"), bukan freeze atau blank.
2. Perangkat tanpa webcam/kamera: UI harus menampilkan pesan graceful bahwa kamera tidak terdeteksi.
3. Percobaan kirim sebelum foto diambil: tombol konfirmasi absen harus disabled sampai snapshot foto berhasil di-capture.
4. Respon jaringan lambat saat upload snapshot: tombol berubah ke state loading / disabled untuk mencegah multiple click / double submission.
5. Format snapshot valid: backend memvalidasi file foto yang diunggah berformat gambar (jpeg/png/webp) dengan ukuran maksimum wajar (mis. 5MB).

---

### Task 1: Konfigurasi Design Token Tailwind CSS v4

**Files:**
- Modify: `resources/css/app.css`
- Test: `tests/Feature/ThemeBuildTest.php`

**Interfaces:**
- Produces: CSS utility tokens `--color-presensi-primary`, `--color-presensi-neutral`, `--color-presensi-camera`, class `tabular`, class `touch-target`.

- [ ] **Step 1: Write the failing test**
Create test `tests/Feature/ThemeBuildTest.php` to verify that `app.css` defines the required theme tokens and that Vite build passes.
```php
<?php

test('app css contains presensi theme tokens and compiles', function () {
    $css = file_get_contents(resource_path('css/app.css'));
    expect($css)->toContain('#0E5C56')
        ->toContain('#F6F4F1')
        ->toContain('tnum');
});
```

- [ ] **Step 2: Run test to verify it fails**
Run: `vendor/bin/pest tests/Feature/ThemeBuildTest.php`
Expected: FAIL (token `#0E5C56` not yet in `app.css`).

- [ ] **Step 3: Implement Theme Tokens in `resources/css/app.css`**
Update `resources/css/app.css` with `@theme` block defining colors, font families, and tabular utility.
```css
@import 'tailwindcss';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';
@source '../views/**/*.blade.php';

@theme {
    --color-primary: #0E5C56;
    --color-primary-hover: #0A4743;
    --color-primary-active: #06312E;
    --color-primary-subtle: #E2EFED;
    --color-on-primary: #FFFFFF;

    --color-secondary: #3E4A49;
    --color-secondary-hover: #2F3A39;
    --color-secondary-subtle: #ECEAE6;
    --color-on-secondary: #FFFFFF;

    --color-neutral: #F6F4F1;
    --color-neutral-strong: #E7E3DD;

    --color-surface: #FFFFFF;
    --color-surface-muted: #FAF9F7;
    --color-on-surface: #1F2A29;
    --color-on-surface-muted: #5A6664;

    --color-success: #166534;
    --color-success-subtle: #E8F5EC;
    --color-danger: #B91C1C;
    --color-danger-subtle: #FDECEC;
    --color-warning: #92400E;
    --color-warning-subtle: #FDF3E3;
    --color-info: #1D4ED8;
    --color-info-subtle: #E9F0FD;

    --color-camera-bg: #10201F;
}

@utility tabular {
    font-feature-settings: 'tnum' 1;
}

@utility touch-target {
    min-height: 44px;
}
```

- [ ] **Step 4: Run test and build to verify it passes**
Run: `vendor/bin/pest tests/Feature/ThemeBuildTest.php && npm run build`
Expected: PASS.

---

### Task 2: Attendance Controller & Endpoint Routes

**Files:**
- Create: `app/Http/Controllers/AttendanceController.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/AttendanceControllerTest.php`

**Interfaces:**
- Produces:
  - `GET /presensi` -> View `attendance.index`
  - `POST /presensi/check-in` -> JSON `{ success: bool, message: string, timestamp: string }`
  - `POST /presensi/check-out` -> JSON `{ success: bool, message: string, timestamp: string }`

- [ ] **Step 1: Write the failing tests**
Create `tests/Feature/AttendanceControllerTest.php`:
```php
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
```

- [ ] **Step 2: Run test to verify it fails**
Run: `vendor/bin/pest tests/Feature/AttendanceControllerTest.php`
Expected: FAIL (route `/presensi` not defined).

- [ ] **Step 3: Implement `AttendanceController.php` and `routes/web.php`**
Implement methods `index()`, `checkIn()`, and `checkOut()` in `AttendanceController` with validation and storage of captured snapshot to `storage/app/public/presensi/snapshots/`.
Register routes in `routes/web.php`.

- [ ] **Step 4: Run test to verify it passes**
Run: `vendor/bin/pest tests/Feature/AttendanceControllerTest.php`
Expected: PASS.

---

### Task 3: Base Layout & Presensi Kiosk Blade View

**Files:**
- Create: `resources/views/layouts/app.blade.php`
- Create: `resources/views/attendance/index.blade.php`
- Test: `tests/Feature/AttendanceViewTest.php`

**Interfaces:**
- Consumes: Tailwind tokens from Task 1, routes from Task 2.
- Produces: HTML DOM containing `#webcam-video`, `#webcam-canvas`, `#snapshot-preview`, `#btn-capture`, `#btn-checkin`, `#btn-checkout`, `#btn-retake`, `#toast-container`.

- [ ] **Step 1: Write the failing view test**
Create `tests/Feature/AttendanceViewTest.php`:
```php
<?php

test('attendance view has camera frame and required interactive elements', function () {
    $response = $this->get('/presensi');
    $response->assertStatus(200);
    $response->assertSee('webcam-video', false);
    $response->assertSee('snapshot-preview', false);
    $response->assertSee('btn-capture', false);
    $response->assertSee('btn-checkin', false);
    $response->assertSee('btn-checkout', false);
});
```

- [ ] **Step 2: Run test to verify it fails**
Run: `vendor/bin/pest tests/Feature/AttendanceViewTest.php`
Expected: FAIL (view missing elements).

- [ ] **Step 3: Implement Layout and View**
Create `resources/views/layouts/app.blade.php` with:
- Topbar navigation 60px (`surface`, border `neutral-strong`), brand logo & title.
- Realtime digital clock (WIB) with `tabular` numbers.
- Background `bg-neutral text-on-surface`.

Create `resources/views/attendance/index.blade.php` with:
- Kiosk card container max-w-xl.
- Shift banner ("Shift Reguler: 08:00 - 17:00 • Kantor Pusat").
- Camera preview frame 4:3 (`bg-camera-bg`, `#webcam-video`, with dashed oval guide overlay and camera status indicator).
- Error alert box (hidden by default) with retry button.
- Snapshot preview box (`#snapshot-preview`, hidden until captured).
- Action buttons: "Ambil Foto" (`#btn-capture`), "Absen Masuk" (`#btn-checkin`), "Absen Pulang" (`#btn-checkout`), "Ulangi" (`#btn-retake`).
- Toast notification container for alerts.

- [ ] **Step 4: Run test to verify it passes**
Run: `vendor/bin/pest tests/Feature/AttendanceViewTest.php`
Expected: PASS.

---

### Task 4: Client-Side WebRTC Webcam & Snapshot Handler

**Files:**
- Create: `resources/js/webcam-attendance.js`
- Modify: `resources/js/app.js`
- Modify: `resources/views/attendance/index.blade.php`
- Test: Manual browser test & Pest compilation check.

**Interfaces:**
- Handles `navigator.mediaDevices.getUserMedia({ video: { width: 640, height: 480, facingMode: 'user' } })`.
- Captures current video frame onto hidden HTML5 canvas, exports as Blob (`image/jpeg`, 0.9).
- Submits FormData via `fetch()` to `/presensi/check-in` or `/presensi/check-out` with CSRF token.
- Displays toast with audio/visual feedback on success or displays error prompt.

- [ ] **Step 1: Implement `resources/js/webcam-attendance.js`**
Code structured class/module `WebcamAttendance` with lifecycle:
- `startCamera()`
- `stopCamera()`
- `capture()`
- `retake()`
- `submit(endpoint)`
- Error handler for `NotAllowedError`, `NotFoundError`, and generic media errors.

- [ ] **Step 2: Connect script in `resources/js/app.js` and Blade view**
Import `webcam-attendance.js` and initialize on page load when `#webcam-video` exists in DOM.

- [ ] **Step 3: Build assets**
Run: `npm run build`
Expected: Build succeeds with 0 errors.

- [ ] **Step 4: Run full test suite & Pint formatting**
Run: `vendor/bin/pest && vendor/bin/pint --format agent`
Expected: All tests pass, styling clean.
