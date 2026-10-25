# Design Specification: Fondasi Database & Model Eloquent Presensi

- **Tanggal**: 2026-10-25
- **Status**: Menunggu Persetujuan
- **Topik**: Migrasi 10 Tabel Inti, Model Eloquent, dan Master Seeder
- **Basis Desain**: [`database.md`](file:///home/wahyupuji/Desktop/front-dev/absen-laravel/database.md)

---

## 1. Intent & The Why
Mengimplementasikan struktur basis data yang kokoh untuk sistem Presensi sesuai arsitektur `database.md`. Sistem lama menyimpan foto sebagai base64 di tabel dan validasi absen ganda di level PHP. Fondasi baru ini memastikan penyimpanan foto hanya berupa metadata (`attendance_photos`), integritas kehadiran harian dilindungi oleh database constraint `UNIQUE(user_id, attendance_date)`, dan pengajuan izin dipisahkan ke tabel `leave_requests`.

---

## 2. Goals, Non-Goals, and Anti-Goals

### Goals
- Membuat migrasi Laravel terurut dengan foreign key constraints dan indexes:
  1. `roles`
  2. `regions`
  3. `offices`
  4. `work_schedules`
  5. Alter `users` (tambah `employee_code`, `role_id`, `office_id`, `supervisor_id`, `work_schedule_id`, `phone`, `is_active`, `deleted_at`)
  6. `attendances` (UUIDv7 / HasUuids, unique constraint harian)
  7. `attendance_logs` (UUIDv7, jejak check-in/out, koordinat)
  8. `attendance_photos` (UUIDv7, metadata file path, disk, hash, size)
  9. `leave_requests` (UUIDv7, status, alur review)
  10. `audit_logs` (Append-only audit trail)
- Membuat Model Eloquent untuk seluruh 10 entitas dengan relasi dua arah (`hasMany`, `belongsTo`), type casting (`casts`), `SoftDeletes`, dan trait `HasUuids`.
- Membuat Seeder master (`RoleSeeder`, `OfficeScheduleSeeder`, `AdminUserSeeder`) untuk data siap pakai saat instalasi baru.

### Non-Goals
- Migrasi data langsung dari database sistem warisan (legacy dump).
- Pembuatan antarmuka CRUD admin untuk master kantor (akan dikerjakan pada modul Admin berikutnya).

### Anti-Goals
- Tidak ada penyimpanan binary/base64 foto di kolom database; foto wajib disimpan di disk storage.
- Tidak mengizinkan duplikasi kehadiran karyawan di tanggal yang sama (dijamin di level RDBMS).

---

## 3. Architecture & Entities

### Skema & Tipe Kunci
- **Auto-increment BIGINT UNSIGNED**: Tabel master yang pertumbuhannya lambat (`roles`, `regions`, `offices`, `work_schedules`, `users`, `audit_logs`).
- **UUIDv7 (`HasUuids`)**: Tabel transaksional bervolume tinggi (`attendances`, `attendance_logs`, `attendance_photos`, `leave_requests`).

### Daftar Relasi Utama
- `Role` hasMany `User` | `User` belongsTo `Role`
- `Region` hasMany `Office` | `Office` belongsTo `Region`
- `Office` hasMany `WorkSchedule`, `Office` hasMany `User`
- `User` hasMany `Attendance`, `User` hasMany `LeaveRequest`
- `Attendance` hasMany `AttendanceLog`, `Attendance` hasMany `AttendancePhoto`
- `AttendanceLog` hasOne `AttendancePhoto`

---

## 4. Verification Plan
- Seluruh migrasi dieksekusi dengan `php artisan migrate:fresh --seed` tanpa error FK atau syntax.
- Feature/Unit test Pest untuk memverifikasi:
  1. Relasi model Eloquent (User ke Role, Office, WorkSchedule).
  2. Penolakan database saat mencoba create 2 baris `attendances` dengan `user_id` dan `attendance_date` yang sama (Unique constraint test).
  3. Relasi `Attendance` ke `logs` dan `photos`.
  4. UUID auto-generation pada model transaksional.
