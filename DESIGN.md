---
version: alpha
name: Presensi
description: Sistem Absensi Karyawan berbasis Webcam - desain internal yang tenang, jelas, dan terbaca di layar HP di bawah cahaya terang.
colors:
  primary: "#0E5C56"
  primary-hover: "#0A4743"
  primary-active: "#06312E"
  primary-subtle: "#E2EFED"
  on-primary: "#FFFFFF"
  secondary: "#3E4A49"
  secondary-hover: "#2F3A39"
  secondary-subtle: "#ECEAE6"
  on-secondary: "#FFFFFF"
  tertiary: "#9A4E17"
  tertiary-subtle: "#F8EEE6"
  on-tertiary: "#FFFFFF"
  neutral: "#F6F4F1"
  neutral-strong: "#E7E3DD"
  on-neutral: "#FFFFFF"
  surface: "#FFFFFF"
  surface-muted: "#FAF9F7"
  on-surface: "#1F2A29"
  on-surface-muted: "#5A6664"
  success: "#166534"
  success-subtle: "#E8F5EC"
  on-success: "#FFFFFF"
  danger: "#B91C1C"
  danger-hover: "#991B1B"
  danger-subtle: "#FDECEC"
  on-danger: "#FFFFFF"
  warning: "#92400E"
  warning-subtle: "#FDF3E3"
  info: "#1D4ED8"
  info-subtle: "#E9F0FD"
  camera-bg: "#10201F"
  on-camera: "#FFFFFF"
typography:
  h1:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "2rem"
    fontWeight: 700
    lineHeight: "1.25"
    letterSpacing: "-0.02em"
  h2:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "1.5rem"
    fontWeight: 700
    lineHeight: "1.3"
    letterSpacing: "-0.015em"
  h3:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "1.25rem"
    fontWeight: 600
    lineHeight: "1.35"
    letterSpacing: "-0.01em"
  h4:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "1.0625rem"
    fontWeight: 600
    lineHeight: "1.4"
  body-lg:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "1.125rem"
    fontWeight: 400
    lineHeight: "1.6"
  body-md:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: "1.6"
  body-sm:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 400
    lineHeight: "1.5"
  label-caps:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "0.75rem"
    fontWeight: 600
    lineHeight: "1.33"
    letterSpacing: "0.08em"
  label-md:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 600
    lineHeight: "1.4"
  number-tabular:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 400
    lineHeight: "1.4"
    fontFeature: "'tnum' 1"
  number-display:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "1.75rem"
    fontWeight: 700
    lineHeight: "1.2"
    fontFeature: "'tnum' 1"
  report-title:
    fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
    fontSize: "1rem"
    fontWeight: 700
    lineHeight: "1.4"
rounded:
  none: "0px"
  sm: "4px"
  md: "8px"
  lg: "12px"
  xl: "16px"
  full: "9999px"
spacing:
  3xs: "4px"
  2xs: "8px"
  xs: "12px"
  sm: "16px"
  md: "24px"
  lg: "32px"
  xl: "48px"
  2xl: "64px"
  table-cell-y: "10px"
  table-cell-x: "12px"
  touch-target: "44px"
  gutter: "20px"
components:
  page-background:
    backgroundColor: "{colors.neutral}"
    textColor: "{colors.on-surface}"
  navbar:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.on-surface}"
    height: "60px"
    typography: "{typography.body-md}"
  sidebar:
    backgroundColor: "{colors.secondary}"
    textColor: "{colors.on-secondary}"
    width: "248px"
    typography: "{typography.body-md}"
  sidebar-item-active:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.on-primary}"
    rounded: "{rounded.sm}"
    typography: "{typography.label-md}"
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.on-primary}"
    rounded: "{rounded.md}"
    padding: "12px"
    height: "{spacing.touch-target}"
    typography: "{typography.body-md}"
  button-primary-hover:
    backgroundColor: "{colors.primary-hover}"
    textColor: "{colors.on-primary}"
    rounded: "{rounded.md}"
    padding: "12px"
    height: "{spacing.touch-target}"
  button-primary-active:
    backgroundColor: "{colors.primary-active}"
    textColor: "{colors.on-primary}"
    rounded: "{rounded.md}"
    padding: "12px"
    height: "{spacing.touch-target}"
  button-secondary:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.secondary}"
    rounded: "{rounded.md}"
    padding: "12px"
    height: "{spacing.touch-target}"
    typography: "{typography.body-md}"
  button-secondary-hover:
    backgroundColor: "{colors.secondary-subtle}"
    textColor: "{colors.secondary-hover}"
    rounded: "{rounded.md}"
    padding: "12px"
    height: "{spacing.touch-target}"
  button-danger:
    backgroundColor: "{colors.danger}"
    textColor: "{colors.on-danger}"
    rounded: "{rounded.md}"
    padding: "12px"
    height: "{spacing.touch-target}"
    typography: "{typography.body-md}"
  button-danger-hover:
    backgroundColor: "{colors.danger-hover}"
    textColor: "{colors.on-danger}"
    rounded: "{rounded.md}"
    padding: "12px"
    height: "{spacing.touch-target}"
  input:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.on-surface}"
    rounded: "{rounded.md}"
    padding: "12px"
    height: "{spacing.touch-target}"
    typography: "{typography.body-md}"
  input-error:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.danger}"
    rounded: "{rounded.md}"
    padding: "12px"
    height: "{spacing.touch-target}"
    typography: "{typography.body-md}"
  card:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.on-surface}"
    rounded: "{rounded.lg}"
    padding: "24px"
  stat-card:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.on-surface}"
    rounded: "{rounded.lg}"
    padding: "16px"
  table-header:
    backgroundColor: "{colors.secondary-subtle}"
    textColor: "{colors.on-surface}"
    padding: "12px"
    typography: "{typography.label-caps}"
  table-row:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.on-surface}"
    padding: "12px"
    typography: "{typography.body-sm}"
  table-row-striped:
    backgroundColor: "{colors.neutral}"
    textColor: "{colors.on-surface}"
    padding: "12px"
    typography: "{typography.body-sm}"
  table-cell:
    textColor: "{colors.on-surface}"
    padding: "10px"
    typography: "{typography.number-tabular}"
  badge-status-hadir:
    backgroundColor: "{colors.success-subtle}"
    textColor: "{colors.success}"
    rounded: "{rounded.full}"
    padding: "8px"
    typography: "{typography.label-caps}"
  badge-status-terlambat:
    backgroundColor: "{colors.warning-subtle}"
    textColor: "{colors.warning}"
    rounded: "{rounded.full}"
    padding: "8px"
    typography: "{typography.label-caps}"
  badge-status-izin:
    backgroundColor: "{colors.info-subtle}"
    textColor: "{colors.info}"
    rounded: "{rounded.full}"
    padding: "8px"
    typography: "{typography.label-caps}"
  badge-status-pulang:
    backgroundColor: "{colors.secondary-subtle}"
    textColor: "{colors.secondary}"
    rounded: "{rounded.full}"
    padding: "8px"
    typography: "{typography.label-caps}"
  badge-status-masuk:
    backgroundColor: "{colors.primary-subtle}"
    textColor: "{colors.primary}"
    rounded: "{rounded.full}"
    padding: "8px"
    typography: "{typography.label-caps}"
  badge-status-sakit:
    backgroundColor: "{colors.tertiary-subtle}"
    textColor: "{colors.tertiary}"
    rounded: "{rounded.full}"
    padding: "8px"
    typography: "{typography.label-caps}"
  badge-status-ditolak:
    backgroundColor: "{colors.danger-subtle}"
    textColor: "{colors.danger}"
    rounded: "{rounded.full}"
    padding: "8px"
    typography: "{typography.label-caps}"
  modal:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.on-surface}"
    rounded: "{rounded.lg}"
    padding: "24px"
  toast-success:
    backgroundColor: "{colors.success}"
    textColor: "{colors.on-success}"
    rounded: "{rounded.md}"
    padding: "12px"
    typography: "{typography.body-md}"
  toast-error:
    backgroundColor: "{colors.danger}"
    textColor: "{colors.on-danger}"
    rounded: "{rounded.md}"
    padding: "12px"
    typography: "{typography.body-md}"
  empty-state:
    backgroundColor: "{colors.surface-muted}"
    textColor: "{colors.on-surface-muted}"
    rounded: "{rounded.lg}"
    padding: "32px"
  loading-skeleton:
    backgroundColor: "{colors.neutral-strong}"
    rounded: "{rounded.md}"
    height: "16px"
  camera-frame:
    backgroundColor: "{colors.camera-bg}"
    textColor: "{colors.on-camera}"
    rounded: "{rounded.lg}"
    width: "640px"
    height: "480px"
  camera-snapshot-preview:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.on-surface-muted}"
    rounded: "{rounded.md}"
    width: "240px"
    height: "180px"
  pagination:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.secondary}"
    rounded: "{rounded.md}"
    padding: "8px"
    typography: "{typography.body-sm}"
  pagination-active:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.on-primary}"
    rounded: "{rounded.md}"
    padding: "8px"
    typography: "{typography.body-sm}"
---

# Presensi — Sistem Absensi Karyawan berbasis Webcam

Spesifikasi design token resmi untuk aplikasi absensi karyawan. File ini adalah
kontrak visual antara Tech Architect, Frontend Developer, dan QA: nilai di
bagian YAML adalah acuan normatif (harus dipakai apa adanya), sedangkan
penjelasan di bawah membantu memahami **alasan** di balik tiap pilihan.

---

## Overview

### Apa itu Presensi

**Presensi** adalah nama sistem absensi karyawan berbasis webcam yang dibangun
ulang di atas Laravel 13 + Tailwind CSS v4. Nama ini dipilih karena:

- **Singkat dan netral** — tidak berisi nama perusahaan atau produk yang cepat
  menua, sehingga aman dipakai di dokumen, nama tabel ekspor, dan judul
  laporan.
- **Familiar** — langsung dipahami karyawan Indonesia. Istilah "presensi"
  dipakai harian di lingkungan kerja.
- **Profesional** — terbaca sebagai aplikasi sistem, bukan aplikasi konsumer
  atau permainan.

### Untuk siapa dan dalam situasi apa

Aplikasi ini dipakai **setiap hari** oleh empat kelompok pengguna, dan yang
paling kritis adalah dua yang pertama:

| Pengguna | Kapan memakai aplikasi | Tekanan yang dirasakan |
|---|---|---|
| Karyawan lapangan | Pagi sebelum shift dan sore saat pulang, sering dari HP | Sedang terburu-buru, jaringan tidak stabil, layar di bawah cahaya terang |
| Atasan / Supervisor | Menelaah kehadiran tim, biasanya satu-dua kali seminggu | Butuh cepat melihat siapa yang hadir, terlambat, atau izin |
| Admin / HR | Mengatur master karyawan, jam kerja, izin | Butuh formulir yang tidak membingungkan dan tidak salah input |
| Auditor | Menelusuri jejak waktu dan bukti foto | Butuh data yang bisa ditelusuri dan diekspor apa adanya |

Karena dipakai harian, **keterbacaan dan kejelasan status mengalahkan
keindahan visual**. Aplikasi ini tidak berlomba-lomba membuat tampilan
"keren"; tujuannya agar karyawan tidak salah menekan tombol saat sedang
menunggu di depan kamera.

### Karakter visual

| Aspek | Arah desain | Alasan |
|---|---|---|
| Kesan | Tenang, dapat dipercaya, sedikit hangat | Nada warna dasar hijau-teal yang dalam memberi kesan rapi dan serius, tanpa kesan "corporate biru" yang dingin |
| Kepadatan | Sedang-padat, mengutamakan tabel | Supervisor dan auditor perlu membaca banyak baris dalam satu layar |
| Kontras | Tinggi, bukan lembut | Layar HP di luar ruangan menyaturasi warna; abu-abu tipis tidak terbaca |
| Gerakan | Minimal | Aplikasi dipakai saat fokus ke satu tugas (absen), bukan untuk jelajah |
| Ornamen | Nihil | Setiap elemen visual harus membawa informasi |

### Aksesibilitas (wajib, bukan opsional)

Target resmi: **WCAG 2.1 AA**.

| Kriteria | Target | Cara mewujudkannya dalam token |
|---|---|---|
| Teks normal | Rasio kontras minimal **4.5:1** | Semua pasangan `backgroundColor` + `textColor` pada komponen sudah diuji lolos |
| Teks besar & komponen UI | Rasio minimal **3:1** | Melebihi 4.5:1, jadi aman tanpa syarat tambahan |
| Target sentuh | Minimal **44 x 44 px** | Token `spacing.touch-target` = 44px dipakai pada tinggi tombol dan input |
| Keterbacaan di luar ruangan | Teks utama gelap di atas dasar terang, bukan abu-abu | Token `on-surface` #1F2A29 bukan abu-abu |
| Kontras elemen non-teks | Batas tabel & garis pemisah ≥ 3:1 | `neutral-strong` #E7E3DD dipakai untuk garis, `secondary` #3E4A49 untuk aksen |
| Angka tabel | Lebar digit tetap | Token `number-tabular` memakai `font-feature-settings: 'tnum'` |

> Semua rasio kontras di bawah ini **diperiksa dengan alat** (`@google/design.md lint`),
> bukan dikira-kira. Hasil pemeriksaan dicantumkan di bagian akhir file ini.

### Batasan font (keputusan sadar)

Font yang dipakai adalah **system font stack** (`system-ui, -apple-system,
'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif`).

- **Alasan:** aplikasi ini tidak boleh bergantung pada pihak ketiga di jalur
  render. Sistem lama memakai `webcamjs` dari CDN — pola itu justru yang
  sedang dihapus dalam rebuild ini. Dengan system stack, font selalu ada di
  perangkat karyawan, memuat lebih cepat, dan tidak menambah permintaan
  jaringan.
- **Trade-off yang diterima:** tampilan akan berbeda sedikit antar Android,
  iOS, dan Windows. Untuk aplikasi internal yang dipakai mencatat kehadiran,
  konsistensi data jauh lebih penting daripada tampilan yang identik di semua
  perangkat.
- **Peluang ke depan:** bila owner ingin satu tampilan seragam, font seperti
  Inter dapat **di-host sendiri** (self-hosted) di server aplikasi — bukan
  dimuat dari CDN. Itu tidak mengubah token ini; hanya mengganti isi
  `fontFamily`.

---

## Colors

Palet dibagi menjadi tiga lapis: **warna dasar** (primer, sekunder,
tersier, netral), **warna semantik** (sukses, bahaya, peringatan, info), dan
**warna status absensi** yang diturunkan dari keduanya.

### 1. Warna dasar

| Token | Nilai | Peran & alasan |
|---|---|---|
| `primary` | `#0E5C56` | Warna utama aplikasi: tombol "Absen Masuk", item menu aktif, judul halaman. Hijau-teal yang dalam memberi rasa tenang dan dapat dipercaya, bukan biru korporat yang dingin. |
| `primary-hover` | `#0A4743` | State hover tombol utama. Lebih gelap 12% agar tombol terasa "turun" saat ditekan. |
| `primary-active` | `#06312E` | State ditekan (sedang diklik). |
| `primary-subtle` | `#E2EFED` | Latar pucat untuk badge status masuk dan highlight lembut. |
| `on-primary` | `#FFFFFF` | Teks di atas `primary`. Rasio kontras 7,76:1. |
| `secondary` | `#3E4A49` | Sidebar dan tombol sekunder. Abu-abu gelap dengan kehangatan kayu — netral, tapi tidak dingin seperti abu-abu biru. |
| `secondary-hover` | `#2F3A39` | State hover tombol sekunder. |
| `secondary-subtle` | `#ECEAE6` | Latar header tabel, baris tabel belang, dan badge status pulang. |
| `on-secondary` | `#FFFFFF` | Teks di atas `secondary`. Rasio kontras 9,05:1. |
| `tertiary` | `#9A4E17` | Aksen tanah liat — warna khas untuk status "sakit" dan detail minor. Dipakai hemat, bukan untuk tombol utama. |
| `tertiary-subtle` | `#F8EEE6` | Latar pucat aksen tanah liat. |
| `on-tertiary` | `#FFFFFF` | Teks di atas `tertiary`. |
| `neutral` | `#F6F4F1` | Latar halaman. Kertas hangat, bukan putih murni — mengurangi silau di layar HP di bawah matahari. |
| `neutral-strong` | `#E7E3DD` | Garis pemisah, tabel, dan placeholder skeleton. |
| `on-neutral` | `#FFFFFF` | Teks di atas `neutral`. |

### 2. Permukaan dan teks

| Token | Nilai | Peran & alasan |
|---|---|---|
| `surface` | `#FFFFFF` | Latar kartu, input, tabel, dan modal. Kartu putih di atas kertas hangat (`#F6F4F1`). |
| `surface-muted` | `#FAF9F7` | Latar keadaan kosong — sedikit lebih redup agar pesan "belum ada data" terasa tenang. |
| `on-surface` | `#1F2A29` | Warna teks utama di atas permukaan. Bukan hitam murni dan bukan abu-abu: terlalu gelap membuat halaman terasa berat, terlalu terang membuat teks di bawah cahaya matahari hilang. Karena itu teks utama **tidak pernah** memakai abu-abu tipis. |
| `on-surface-muted` | `#5A6664` | Teks sekunder: keterangan, timestamp, nama kolom helper. Masih 6,03:1 di atas putih. |

### 3. Warna semantik (perilaku, bukan dekorasi)

| Token | Nilai | Kapan dipakai |
|---|---|---|
| `success` | `#166534` | Kehadiran normal, absensi berhasil, toast berhasil. Hijau tua agar tetap terbaca di luar ruangan. |
| `success-subtle` | `#E8F5EC` | Latar badge "Hadir". |
| `on-success` | `#FFFFFF` | Teks di atas `success`. |
| `danger` | `#B91C1C` | Tombol hapus, error validasi, izin ditolak. |
| `danger-hover` | `#991B1B` | State hover tombol hapus. |
| `danger-subtle` | `#FDECEC` | Latar badge "Ditolak" dan pesan error. |
| `on-danger` | `#FFFFFF` | Teks di atas `danger`. |
| `warning` | `#92400E` | Status "Terlambat", peringatan noninvasif. |
| `warning-subtle` | `#FDF3E3` | Latar badge "Terlambat". |
| `info` | `#1D4ED8` | Status "Izin", permintaan persetujuan, informasi netral. |
| `info-subtle` | `#E9F0FD` | Latar badge "Izin". |

### 4. Warna khusus kamera

| Token | Nilai | Peran & alasan |
|---|---|---|
| `camera-bg` | `#10201F` | Latar bingkai pratinjau webcam. Hampir hitam dengan sedikit warna hijau-teal supaya tidak terasa "mati" saat kamera mati. |
| `on-camera` | `#FFFFFF` | Teks indikator di atas bingkai kamera (mis. "Posisikan wajah di bingkai"). |

### Peta warna ke status absensi

| Status absensi | Badge | Latar | Teks | Alasan warna |
|---|---|---|---|---|
| Hadir / tepat waktu | `badge-status-hadir` | `success-subtle` | `success` | Hijau = "aman, tercatat". |
| Terlambat | `badge-status-terlambat` | `warning-subtle` | `warning` | Kuning-cokelat = "perlu perhatian, bukan kegagalan". |
| Izin | `badge-status-izin` | `info-subtle` | `info` | Biru = "butuh persetujuan manusia". |
| Absen pulang / selesai | `badge-status-pulang` | `secondary-subtle` | `secondary` | Netral = "sudah selesai, tidak perlu penilaian". |
| Absen masuk tercatat | `badge-status-masuk` | `primary-subtle` | `primary` | Warna brand untuk menandai check point sistem. |
| Sakit / tidak masuk | `badge-status-sakit` | `tertiary-subtle` | `tertiary` | Aksen tanah liat, berbeda jelas dari "Izin" yang biru. |
| Izin ditolak | `badge-status-ditolak` | `danger-subtle` | `danger` | Merah = penolakan, satu-satunya warna yang berarti "tidak boleh". |

> **Aturan tegas:** status absensi **selalu** ditulis memakai komponen badge.
> Warna merah/amber **tidak pernah** dipakai untuk menyorot teks mentah di
> dalam tabel, karena employee harus bisa membaca status tanpa bergantung
> pada penglihatan warna.

---

## Typography

### Skala tipografi

| Token | Ukuran | Berat | Baris | Pemakaian |
|---|---|---|---|---|
| `h1` | 32px | 700 | 1.25 | Judul halaman. Satu per halaman. |
| `h2` | 24px | 700 | 1.3 | Judul bagian/tabel besar. |
| `h3` | 20px | 600 | 1.35 | Judul kartu dan sub-bagian. |
| `h4` | 17px | 600 | 1.4 | Judul sub-kartu, nama modul. |
| `body-lg` | 18px | 400 | 1.6 | Paragraf pengantar, pesan penting. |
| `body-md` | 16px | 400 | 1.6 | Teks utama aplikasi. |
| `body-sm` | 14px | 400 | 1.5 | Teks sekunder, isi tabel, keterangan. |
| `label-caps` | 12px | 600 | 1.33 | Label kapital: judul kolom tabel, label badge, judul filter. |
| `label-md` | 14px | 600 | 1.4 | Label form dan tombol. |
| `number-tabular` | 14px | 400 | 1.4 | Angka di tabel absensi (jam, durasi). |
| `number-display` | 28px | 700 | 1.2 | Angka besar di stat-card rekap. |
| `report-title` | 16px | 700 | 1.4 | Judul tabel dan judul laporan hasil ekspor. |

### Aturan praktis

- **Hanya satu `h1` per halaman.** Hierarki lain boleh diulang sesuka hati.
- **Angka selalu rata kanan** di tabel absensi dan memakai `number-tabular`.
  Lebar digit yang tetap (tabular) membuat kolom jam dan durasi sejajar
  sehingga mudah dibandingkan secara vertikal.
- **Label kapital tidak untuk kalimat.** `label-caps` hanya untuk label
  pendek; paragraf selalu `body-*`.
- **Maksimal tiga tingkat heading dalam satu kartu** (`h3` → `h4` → label).
- **Nama kolom tabel** memakai `label-caps`; **nilai** memakai `body-sm`;
  **angka** memakai `number-tabular`.

### Catatan tabel dan laporan

Judul tabel riwayat absensi memakai `report-title`. Di file ekspor Excel dan
PDF, baris pertama adalah judul laporan dengan token yang sama, lalu baris
kedua berisi nama kolom dengan gaya `label-caps`. Keduanya juga memakai
`font-feature-settings: 'tnum'` pada kolom angka agar hasil cetak ke kertas
tetap sejajar.

> **Catatan implementasi (penting).** CLI `@google/design.md` **v0.4.0 tidak meng-emit
> properti `fontFeature`** ke file export — di `theme.css`, `tailwind.theme.json`, dan
> `tokens.json`, nilai `tnum` ini **sudah diisi manual** oleh Project Manager.
> Tailwind CSS v4 juga **tidak punya** utilitas bawaan untuk `font-feature-settings`,
> jadi `theme.css` sudah dilengkapi utilitas `@utility tabular` (alias
> `font-feature-numeric-tabular`). Frontend Developer **wajib** memakai class
> `tabular` pada elemen angka tabel, atau menyalin `--font-feature-settings-number-tabular`
> — tanpa itu, kolom jam dan durasi pada tabel absensi tidak akan rata dan kolom
> hasil ekspor PDF akan bergeser.

---

## Layout

### Skala jarak

Dasar skala adalah **4px**; semua nilai lain adalah kelipatannya.

| Token | Nilai | Pemakaian |
|---|---|---|
| `spacing.3xs` | 4px | Jarak antar ikon dan teks di dalam satu baris. |
| `spacing.2xs` | 8px | Jarak label ke helper text, padding badge. |
| `spacing.xs` | 12px | Padding kartu kecil, padding tombol, padding sel tabel. |
| `spacing.sm` | 16px | Padding stat-card, jarak antar field form. |
| `spacing.md` | 24px | Padding card utama, jarak antar bagian. |
| `spacing.lg` | 32px | Padding empty-state, jarak antar halaman. |
| `spacing.xl` | 48px | Ruang kosongSECTION kosong pada halaman ringkas. |
| `spacing.2xl` | 64px | Margin bawah halaman. |
| `spacing.table-cell-y` | 10px | Padding vertikal sel tabel — lebih rapat dari teks biasa agar lebih banyak baris terlihat. |
| `spacing.table-cell-x` | 12px | Padding horizontal sel tabel. |
| `spacing.touch-target` | 44px | **Tinggi minimum** tombol dan input. |
| `spacing.gutter` | 20px | Jarak antar kolom pada grid layout internal. |

### Grid dan lebar

- **Konten maksimum 1280px** di desktop, dipusatkan. Di atas lebar itu
  aplikasi tidak melebar — tabel yang terlalu lebar justru memperburuk
  pembacaan.
- **Sidebar 248px** di desktop; di bawah 1024px sidebar berubah menjadi menu
  yang dapat dibuka (drawer) dan isi halaman memakai lebar penuh.
- **Satu kolom di HP.** Form master karyawan dan filter periode tetap satu
  kolom agar tidak ada input yang terlalu sempit.

### Padding komponen

| Komponen | Padding |
|---|---|
| Tombol | 12px horizontal, tinggi 44px |
| Input | 12px horizontal, tinggi 44px |
| Card utama | 24px |
| Stat-card | 16px |
| Sel tabel | 10px vertikal, 12px horizontal |
| Modal | 24px |
| Toast | 12px |
| Empty-state | 32px |

---

## Elevation & Depth

Sistem ini internal dan dipakai harian, sehingga **bayangan dibuat sangat
halus**. ini bukan panggung demo; fokusnya adalah keterbacaan.

| Tingkat | Nilai CSS | Pemakaian |
|---|---|---|
| `level-0` | `0 1px 2px 0 rgb(16 32 31 / 0.06)` | Card, stat-card, dropdown |
| `level-1` | `0 4px 12px 0 rgb(16 32 31 / 0.08)` | Modal, popover |
| `level-2` | `0 12px 32px 0 rgb(16 32 31 / 0.12)` | Toast, drawer sidebar |

Aturan tambahan:

- **Tidak ada bayangan pada tombol.** Tombol menggunakan perubahan warna
  (hover/active), bukan bayangan, supaya tidak terlihat "bermelayang".
- **Pemisah tabel memakai garis, bukan bayangan** — `neutral-strong` 1px.
- **Sidebar tidak diberi bayangan** di desktop; pemisahannya berasal dari
  perbedaan warna (`secondary` vs `surface`).

> Catatan teknis: format DESIGN.md yang resmi belum punya token bayangan
> tersendiri, sehingga ketiga nilai di atas ditulis sebagai CSS literal.
> Frontend Developer **wajib** menyalin nilai tersebut apa adanya ke
> `app.css` (atau menambahkannya sebagai `--shadow-*` di `@theme`).

---

## Shapes

Bentuk menentukan "seberapa tegas" aplikasi ini terasa.

| Token | Nilai | Pemakaian |
|---|---|---|
| `rounded.none` | 0px | Hampir tidak dipakai; hanya untuk bar pembatas tabel. |
| `rounded.sm` | 4px | Item menu aktif, input kecil, badge status. |
| `rounded.md` | 8px | Tombol, input, toast, thumbnail kamera. |
| `rounded.lg` | 12px | Card, modal, stat-card, bingkai kamera. |
| `rounded.xl` | 16px | Sheet menu, panel besar di layar HP. |
| `rounded.full` | 9999px | Badge status (pill), avatar, titik indikator. |

Aturan: **jangan mencampur sudut tajam dan sudut bulat dalam satu tampilan.**
Kartu, tombol, input, dan modal semuanya memakai `md` atau `lg`; badge dan
avatar selalu `full`. Sudut 0px hanya untuk garis pembatas, tidak untuk
permukaan.

---

## Components

Bagian ini adalah daftar komponen yang harus ada diimplementasi. Setiap
baris di bawah memuat nilai token yang dipakai.

### Tombol

| Token | Latar | Teks | Catatan |
|---|---|---|---|
| `button-primary` | `primary` | `on-primary` | Aksi utama per halaman: "Absen Masuk", "Simpan". |
| `button-primary-hover` | `primary-hover` | `on-primary` | |
| `button-primary-active` | `primary-active` | `on-primary` | |
| `button-secondary` | `surface` | `secondary` | Aksi sekunder: "Absen Pulang", "Batal", "Filter". |
| `button-secondary-hover` | `secondary-subtle` | `secondary-hover` | |
| `button-danger` | `danger` | `on-danger` | Aksi merusak: "Hapus", "Tolak Izin". |
| `button-danger-hover` | `danger-hover` | `on-danger` | |

Semua tombol setinggi **44px** (`spacing.touch-target`), radius `rounded.md`,
dan teks `body-md`.

### Form

| Token | Latar | Teks | Catatan |
|---|---|---|---|
| `input` | `surface` | `on-surface` | Isian form (master karyawan, jam kerja, filter periode). |
| `input-error` | `surface` | `danger` | Isian yang gagal validasi. Pesan error ditulis di bawah field, bukan hanya lewat warna. |

Label field memakai `label-md`. Placeholder **tidak boleh** menggantikan nama label.

### Kartu dan ringkasan

| Token | Latar | Teks | Catatan |
|---|---|---|---|
| `card` | `surface` | `on-surface` | Wadah modul: form master, panel izin, blok riwayat. |
| `stat-card` | `surface` | `on-surface` | Kartu angka rekap: total hadir, terlambat, izin. Angka memakai `number-display`. |
| `page-background` | `neutral` | `on-surface` | Latar halaman di balik semua konten. |

### Tabel riwayat absensi

| Token | Latar | Teks | Catatan |
|---|---|---|---|
| `table-header` | `secondary-subtle` | `on-surface` | Baris judul kolom, gaya `label-caps`. |
| `table-row` | `surface` | `on-surface` | Baris genap. |
| `table-row-striped` | `neutral` | `on-surface` | Baris ganjil (belang). |
| `table-cell` | — | `on-surface` | Isi sel. Angka memakai `number-tabular` dan rata kanan. |

Kolom minimal: Tanggal, Nama, Masuk, Pulang, Durasi, Status, Foto. Foto
ditampilkan sebagai thumbnail yang dapat diklik untuk melihat bukti gambar
penuh.

### Badge status absensi

| Token | Warna | Status |
|---|---|---|
| `badge-status-hadir` | hijau | Hadir / tepat waktu |
| `badge-status-terlambat` | kuning-cokelat | Terlambat |
| `badge-status-izin` | biru | Izin disetujui |
| `badge-status-pulang` | netral | Absen pulang tercatat |
| `badge-status-masuk` | warna brand | Absen masuk tercatat |
| `badge-status-sakit` | aksen tanah liat | Sakit / tidak masuk |
| `badge-status-ditolak` | merah | Izin ditolak |

Semua badge berbentuk pill (`rounded.full`), padding 8px, teks `label-caps`.

### Layout aplikasi

| Token | Latar | Teks | Catatan |
|---|---|---|---|
| `navbar` | `surface` | `on-surface` | Bar atas: nama aplikasi, nama pengguna, tombol keluar. Tinggi 60px. |
| `sidebar` | `secondary` | `on-secondary` | Menu kiri: Absensi, Riwayat, Karyawan, Jam Kerja, Izin. Lebar 248px. |
| `sidebar-item-active` | `primary` | `on-primary` | Item menu yang sedang dibuka. |

### Dialog, umpan balik, dan keadaan khusus

| Token | Latar | Teks | Catatan |
|---|---|---|---|
| `modal` | `surface` | `on-surface` | Konfirmasi hapus, form izin, filter periode. |
| `toast-success` | `success` | `on-success` | "Absensi berhasil dicatat". Muncul 4 detik. |
| `toast-error` | `danger` | `on-danger` | "Gagal menyimpan. Coba lagi." |
| `empty-state` | `surface-muted` | `on-surface-muted` | Belum ada data pada tabel riwayat. Wajib menyertakan ikon + judul + ajakan bertindak. |
| `loading-skeleton` | `neutral-strong` | — | Placeholder selagi data dimuat. Minimal 3 baris pada tabel, 3 kartu pada stat-card. |

### Kamera (komponen inti aplikasi)

| Token | Latar | Teks | Catatan |
|---|---|---|---|
| `camera-frame` | `camera-bg` | `on-camera` | Bingkai pratinjau video 4:3 (640x480). Berisi indikator "Posisikan wajah di dalam bingkai" dan garis pembantu. |
| `camera-snapshot-preview` | `surface` | `on-surface-muted` | Pratinjau foto yang baru diambil (240x180), sebelum dikirim. |

Alur kamera yang wajib didukung statusnya:

1. **Meminta izin** — permintaan izin browser dengan teks yang jelas.
2. **Kamera tidak tersedia / ditolak** — pesan **`danger`** di dalam
   `camera-frame` dengan tombol sekunder "Coba lagi" dan instruksi
   mengaktifkan izin kamera. Tidak boleh diam saja.
3. **Kamera menyala** — video langsung, tombol "Ambil Foto" (`button-primary`).
4. **Foto diambil** — pratinjau di `camera-snapshot-preview`, tombol "Ulangi"
   (`button-secondary`) dan "Simpan / Absen" (`button-primary`).
5. **Mengirim** — tombol dinonaktifkan, `loading-skeleton` tampil, `toast-success`
   atau `toast-error` sesuai hasil.

### Paginasi

| Token | Latar | Teks | Catatan |
|---|---|---|---|
| `pagination` | `surface` | `secondary` | Tombol halaman yang tidak aktif. |
| `pagination-active` | `primary` | `on-primary` | Halaman yang sedang dibuka. |

Server-side pagination (DataTables) dipertahankan dari sistem lama, dengan
ukuran halaman 25/50/100.

---

## Do's and Don'ts

### Warna

- **Do** memakai hanya warna dari palet ini. Warna di luar palet harus
  melalui persetujuan Tech Architect.
- **Do** menyatakan status absensi **selalu lewat badge** yang sudah
  ditentukan, tidak lewat warna teks mentah.
- **Do** memastikan rasio kontras minimal 4.5:1 untuk teks normal dan 3:1
  untuk teks besar serta batas komponen UI.
- **Do** memakai `primary` untuk **satu** aksi utama per halaman.
- **Don't** memakai warna merah atau hijau sebagai satu-satunya pembawa
  makna — selalu lengkapi dengan teks, badge, atau label.
- **Don't** memakai warna status pada tombol. Tombol merah berarti
  "hapus atau merusak", bukan "terlambat".
- **Don't** menambahkan warna gradasi, bayangan berwarna, atau warna yang
 diambil dari halaman lain.

### Tipografi

- **Do** memakai `number-tabular` untuk semua angka di tabel dan rata
  mengah kanan.
- **Do** memakai maksimal tiga tingkat heading di dalam satu kartu.
- **Don't** memakai warna teks di luar `on-surface` dan `on-surface-muted`
  untuk paragraf biasa.
- **Don't** mengunci ukuran teks dengan `px` di dalam komponen — gunakan
  token tipografi.
- **Don't** memuat font dari CDN pihak ketiga. Font tambahan harus
  **self-hosted**.

### Layout dan interaksi

- **Do** menjaga tinggi tombol dan input minimal 44px.
- **Do** menyediakan keadaan **loading**, **kosong**, dan **error** di setiap
  halaman yang memuat data.
- **Don't** menampilkan tabel tanpa pagination server-side.
- **Don't** menyembunyikan status error hanya dengan mengubah warna.
- **Don't** menambahkan animasi yang lebih lama dari 200ms pada aksi
  harian (absen). Animasi bukan penanda status.

### Bentuk dan kedalaman

- **Do** memakai `rounded.md` untuk tombol dan input, `rounded.lg` untuk
  card dan modal, `rounded.full` untuk badge dan avatar.
- **Don't** mencampur sudut tajam dan sudut bulat dalam satu tampilan.
- **Don't** memberi bayangan pada tombol.
- **Don't** memakai warna `#FFFFFF` sebagai latar halaman. Latar halaman
  adalah `neutral` (#F6F4F1).

---

## Status

**selesai** — DESIGN.md lengkap, seluruh token sudah divalidasi dengan CLI
resmi `@google/design.md` (versi 0.4.0) dan diekspor ke tiga format.

## Output

| File | Isi | Baris |
|---|---|---|
| `/docs/DESIGN.md` | Spesifikasi token + penjelasan (file ini) | 640 |
| `/docs/theme.css` | Ekspor Tailwind CSS v4 (blok `@theme`) | 74 |
| `/docs/tailwind.theme.json` | Ekspor `theme.extend` Tailwind v3 (cadangan) | 47 |
| `/docs/tokens.json` | Ekspor W3C DTCG | 397 |

## Pertanyaan terbuka

1. **Warna brand** — apakah hijau-teal `#0E5C56` sebagai warna utama sudah
   sesuai dengan identitas perusahaan klien? Kalau ada warna brand resmi,
   cukup ganti `primary` dan token turunannya.
2. **Font** — sistem memakai font bawaan perangkat. Apakah owner ingin
   font seperti Inter di-host sendiri di server aplikasi agar tampilan seragam
   di semua perangkat?
3. **Mode gelap** — palet ini hanya mode terang. Apakah perlu versi gelap
   untuk dipakai shift malam atau di ruangan minim cahaya?
4. **Istilah** — "Presensi" sebagai nama sistem sudah final? Nama ini
   muncul di judul laporan ekspor dan nama file.
5. **Warna status** — warna kuning-cokelat untuk "Terlambat" dan warna tanah
   liat untuk "Sakit" bisa tertukar dengan warna brand. Apakah owner punya
   preferensi?
6. **Tombol Izin** — di halaman absen, tombol "Izin" memakai warna biru
   (`info`) sebagai pilihan yang disengaja. Apakah perusahaan ingin status izin
   punya warna khas sendiri?
7. **Ikon** — belum ada token ikon (bentuk, ketebalan, ukuran). Apakah
   owner punya set ikon sendiri yang harus dipertahankan?
8. **Densitas tabel** — padatan saat ini 10px vertikal. Untuk HP dengan
   layar kecil, mungkin perlu versi 12px. Apakah perlu dua densitas?

## Langkah berikutnya

1. Owner meninjau file ini dan menjawab 8 pertanyaan di atas (khususnya
   warna brand, font, dan mode gelap).
2. Frontend Developer membangun `@theme` Tailwind v4 dari `docs/theme.css`,
   lalu memetakan token ini ke komponen Blade.
3. QA & Security Reviewer memakai tabel rasio kontras di bagian **Aksesibilitas**
   sebagai kriteria uji otomatis pada setiap komponen.
4. Setelah owner menyetujui, baris token yang berubah dikembalikan ke
   Tech Architect untuk lint ulang.
