# Design Specification: UI Frontend Presensi Webcam (Opsi A)

- **Tanggal**: 2026-10-25
- **Status**: Menunggu Persetujuan
- **Topik**: Modul Frontend & Kamera Presensi Karyawan
- **Basis Desain**: [`DESIGN.md`](file:///home/wahyupuji/Desktop/front-dev/absen-laravel/DESIGN.md) & [`database.md`](file:///home/wahyupuji/Desktop/front-dev/absen-laravel/database.md)

---

## 1. Intent & The Why

Aplikasi "Presensi" digunakan harian oleh karyawan untuk melakukan absensi masuk dan pulang menggunakan bukti foto webcam. Karena pengguna sering terburu-buru sebelum jam shift dimulai atau berada di layar HP di bawah sinar matahari terang, antarmuka harus bebas distraksi, memiliki kontras tinggi, tombol aksi yang besar (touch target ≥ 44px), dan penanganan kamera yang tangguh.

---

## 2. Goals, Non-Goals, and Anti-Goals

### Goals
- Mengimplementasikan token visual `DESIGN.md` ke dalam Tailwind CSS v4 (`resources/css/app.css`).
- Membuat layout dasar aplikasi (Navbar 60px, shell responsif, warna latar kertas hangat `#F6F4F1`).
- Membangun antarmuka presensi mandiri (Opsi A - Focused Kiosk Card):
  - Jam digital real-time (WIB) dengan font tabular numbers (`tnum`).
  - Kartu informasi shift kerja karyawan dan nama kantor.
  - Video stream kamera live 4:3 (640x480) via HTML5 WebRTC `navigator.mediaDevices.getUserMedia` dengan panduan oval wajah.
  - Tombol aksi sentuh 44px: "Absen Masuk" (`button-primary`) dan "Absen Pulang" (`button-secondary`).
  - Mekanisme capture snapshot instan, pratinjau foto (240x180) dengan opsi "Ulangi" atau "Kirim".
  - Penanganan status error izin kamera yang jelas (tidak diam saat kamera ditolak).
  - Indikator loading dan notifikasi toast (sukses/gagal).

### Non-Goals
- Pembuatan modul manajemen master pegawai / HR backend kompleks di fase ini (akan dibuat pada modul terpisah).
- Export laporan PDF/Excel di fase ini.

### Anti-Goals
- Tidak menggunakan plugin flash atau library usang dari CDN pihak ketiga (mis. `webcamjs` CDN). Seluruh pemrosesan kamera menggunakan native JavaScript WebRTC API.
- Tidak menyimpan base64 foto langsung di database; foto dikirim sebagai multipart FormData untuk disimpan ke storage disk/driver sesuai prinsip `database.md`.

---

## 3. Constraints
- Framework: Laravel 12/13 dengan PHP 8.4.
- CSS: Tailwind CSS v4 (`@tailwindcss/vite`).
- Desain: Mematuhi token warna dan tipografi di `DESIGN.md` (WCAG 2.1 AA, rasio kontras min 4.5:1).
- Browser Compatibility: Dukungan modern browser dengan izin HTTPS/localhost `getUserMedia`.

---

## 4. Approaches Considered & Trade-offs

### Pendekatan 1: Dashboard Terintegrasi (Split Screen 2 Kolom)
- *Deskripsi*: Kamera dan tabel riwayat ditampilkan berdampingan di satu layar desktop.
- *Trade-off*: Kurang optimal di layar ponsel/tablet, membebani tampilan karyawan yang hanya butuh absen cepat.

### Pendekatan 2: Fokus Kiosk / Mobile-First Webcam Card (Opsi A - DIPILIH)
- *Deskripsi*: Tampilan kartu tunggal yang terfokus pada kamera dan aksi check-in/out, dengan kartu informasi shift yang ringkas dan navigasi bersih.
- *Alasan Dipilih*: Paling ergonomis untuk kebutuhan karyawan di lapangan maupun tablet/kiosk kantor, mengurangi kesalahan klik, dan sesuai preferensi pengguna.

---

## 5. UI Architecture & Components

1. **Tailwind CSS v4 Configuration (`resources/css/app.css`)**:
   - Menambahkan custom color palette: `--color-primary: #0E5C56`, `--color-primary-hover: #0A4743`, `--color-secondary: #3E4A49`, `--color-neutral: #F6F4F1`, dll.
   - Utility tabular number (`font-feature-settings: 'tnum' 1`).
   
2. **Master Layout (`resources/views/layouts/app.blade.php`)**:
   - Top navbar (brand "Presensi", profil karyawan, jam/tanggal).
   - Container terpusat max-w-xl / max-w-2xl untuk kiosk mode.

3. **Komponen Presensi Kamera (`resources/views/attendance/index.blade.php`)**:
   - Frame video webcam dengan overlay oval penanda posisi wajah.
   - Pratinjau snapshot setelah foto diambil.
   - Script WebRTC modular (`resources/js/webcam-attendance.js` atau inline helper di Blade).
   - Komponen Toast untuk feedback hasil presensi.

4. **Controller & Route (`routes/web.php` & `app/Http/Controllers/AttendanceController.php`)**:
   - Route `GET /` atau `GET /presensi` menampilkan antarmuka.
   - Route `POST /presensi/check-in` & `POST /presensi/check-out` untuk menerima upload snapshot bukti foto.

---

## 6. What's Left to the Builder
- Menghubungkan endpoint dengan validasi penyimpanan foto ke disk `storage/app/public/presensi/` dan pencatatan log.
- Penyesuaian geolocation/GPS radius kantor opsional jika browser mengizinkan koordinat.
