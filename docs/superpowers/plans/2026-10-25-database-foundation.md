# Presensi Database Foundation & Eloquent Models Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Mengimplementasikan 10 tabel inti sistem presensi, Model Eloquent dengan relasi lengkap & UUID, serta master seeder sesuai spesifikasi database.md.

**Architecture:** Menggunakan skema relasional MySQL 8 dengan tabel master ber-ID integer auto-increment dan tabel transaksi ber-UUIDv7. Relasi antar-entitas dimodelkan di Eloquent dengan foreign key constraint di database, soft deletes pada entitas utama, dan unique constraint harian untuk mencegah absensi ganda.

**Tech Stack:** Laravel 12/13, MySQL 8, Eloquent ORM, Pest testing framework.

**Spec:** [`docs/superpowers/specs/2026-10-25-database-foundation-design.md`](file:///home/wahyupuji/Desktop/front-dev/absen-laravel/docs/superpowers/specs/2026-10-25-database-foundation-design.md)

## Global Constraints
- Penamaan tabel dan kolom konsisten `snake_case` plural (`work_schedules`, `attendance_logs`, `leave_requests`).
- Tabel transaksi (`attendances`, `attendance_logs`, `attendance_photos`, `leave_requests`) menggunakan UUID primary key (`HasUuids`).
- Constraint unik tegas pada `attendances`: `UNIQUE (user_id, attendance_date)`.
- Metadata foto disimpan di `attendance_photos`, bukan isi binary fotonya.
- Foreign key constraints menggunakan cascade update dan restrict delete pada relasi krusial.

## Review Focus
1. Percobaan insert absensi ganda pada tanggal yang sama untuk user yang sama harus ditolak oleh RDBMS (`QueryException` duplicate entry).
2. Soft deleted user atau office tidak boleh menghilangkan riwayat kehadiran masa lalu (Foreign key delete restrict / null on delete).
3. Field json permissions di `roles` dan old/new values di `audit_logs` harus otomatis di-cast sebagai array.
4. Nilai default untuk radius kantor (50 meter), toleransi jam (15 menit), dan hari kerja ('1,2,3,4,5') harus terpasang di skema.
5. Seeder berjalan idempotent dan tidak menduplikasi role saat dijalankan ulang.

---

### Task 1: Migrasi Master Organisasi (`roles`, `regions`, `offices`, `work_schedules`, alter `users`)

**Files:**
- Create: `database/migrations/2026_10_25_000001_create_roles_table.php`
- Create: `database/migrations/2026_10_25_000002_create_regions_table.php`
- Create: `database/migrations/2026_10_25_000003_create_offices_table.php`
- Create: `database/migrations/2026_10_25_000004_create_work_schedules_table.php`
- Create: `database/migrations/2026_10_25_000005_add_organization_columns_to_users_table.php`
- Test: `tests/Feature/OrganizationMigrationTest.php`

**Interfaces:**
- Produces: Database tables `roles`, `regions`, `offices`, `work_schedules`, and augmented columns in `users`.

- [ ] **Step 1: Write the failing test**
Create `tests/Feature/OrganizationMigrationTest.php` asserting tables exist and have expected columns.
```php
<?php

use Illuminate\Support\Facades\Schema;

test('organization master tables and user columns exist', function () {
    expect(Schema::hasTable('roles'))->toBeTrue()
        ->and(Schema::hasTable('regions'))->toBeTrue()
        ->and(Schema::hasTable('offices'))->toBeTrue()
        ->and(Schema::hasTable('work_schedules'))->toBeTrue()
        ->and(Schema::hasColumns('users', ['employee_code', 'role_id', 'office_id', 'work_schedule_id', 'is_active']))->toBeTrue();
});
```

- [ ] **Step 2: Run test to verify it fails**
Run: `vendor/bin/pest tests/Feature/OrganizationMigrationTest.php`
Expected: FAIL (table roles does not exist).

- [ ] **Step 3: Implement migrations for master organization**
Write the 5 migration files matching `database.md` specifications with indexes, foreign keys, and soft deletes. Run `php artisan migrate`.

- [ ] **Step 4: Run test to verify it passes**
Run: `vendor/bin/pest tests/Feature/OrganizationMigrationTest.php`
Expected: PASS.

---

### Task 2: Migrasi Transaksi Presensi, Foto, Izin, & Audit (`attendances`, `attendance_logs`, `attendance_photos`, `leave_requests`, `audit_logs`)

**Files:**
- Create: `database/migrations/2026_10_25_000006_create_attendances_table.php`
- Create: `database/migrations/2026_10_25_000007_create_attendance_logs_table.php`
- Create: `database/migrations/2026_10_25_000008_create_attendance_photos_table.php`
- Create: `database/migrations/2026_10_25_000009_create_leave_requests_table.php`
- Create: `database/migrations/2026_10_25_000010_create_audit_logs_table.php`
- Test: `tests/Feature/AttendanceMigrationTest.php`

**Interfaces:**
- Produces: UUID-based tables for `attendances`, `attendance_logs`, `attendance_photos`, `leave_requests`, plus `audit_logs`.

- [ ] **Step 1: Write the failing test**
Create `tests/Feature/AttendanceMigrationTest.php`:
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

test('attendance transactional tables exist with expected constraints', function () {
    expect(Schema::hasTable('attendances'))->toBeTrue()
        ->and(Schema::hasTable('attendance_logs'))->toBeTrue()
        ->and(Schema::hasTable('attendance_photos'))->toBeTrue()
        ->and(Schema::hasTable('leave_requests'))->toBeTrue()
        ->and(Schema::hasTable('audit_logs'))->toBeTrue();
});

test('attendances table prevents duplicate check in on same date', function () {
    // Attempt duplicate insert should trigger unique constraint violation
    $user = DB::table('users')->insertGetId([
        'name' => 'Budi',
        'email' => 'budi@example.com',
        'password' => bcrypt('secret'),
        'created_at' => now(),
    ]);

    $uuid1 = (string) Str::uuid();
    $uuid2 = (string) Str::uuid();

    DB::table('attendances')->insert([
        'id' => $uuid1,
        'user_id' => $user,
        'attendance_date' => '2026-10-25',
        'status' => 'hadir',
        'created_at' => now(),
    ]);

    expect(fn() => DB::table('attendances')->insert([
        'id' => $uuid2,
        'user_id' => $user,
        'attendance_date' => '2026-10-25',
        'status' => 'hadir',
        'created_at' => now(),
    ]))->toThrow(QueryException::class);
});
```

- [ ] **Step 2: Run test to verify it fails**
Run: `vendor/bin/pest tests/Feature/AttendanceMigrationTest.php`
Expected: FAIL (table attendances does not exist).

- [ ] **Step 3: Implement migrations for attendance, photos, leave, and audit**
Write the 5 migration files matching `database.md` specifications with UUID primary keys and indexes. Run `php artisan migrate`.

- [ ] **Step 4: Run test to verify it passes**
Run: `vendor/bin/pest tests/Feature/AttendanceMigrationTest.php`
Expected: PASS.

---

### Task 3: Model Eloquent dengan Relasi, UUID, & Casts

**Files:**
- Create: `app/Models/Role.php`
- Create: `app/Models/Region.php`
- Create: `app/Models/Office.php`
- Create: `app/Models/WorkSchedule.php`
- Modify: `app/Models/User.php`
- Create: `app/Models/Attendance.php`
- Create: `app/Models/AttendanceLog.php`
- Create: `app/Models/AttendancePhoto.php`
- Create: `app/Models/LeaveRequest.php`
- Create: `app/Models/AuditLog.php`
- Test: `tests/Feature/AttendanceModelRelationsTest.php`

**Interfaces:**
- Produces: 10 Eloquent models with bidirectional relations (`user->attendances()`, `attendance->logs()`, `attendance->photos()`, etc.).

- [ ] **Step 1: Write the failing relations test**
Create `tests/Feature/AttendanceModelRelationsTest.php` testing model instantiation and relations.
```php
<?php

use App\Models\Role;
use App\Models\Region;
use App\Models\Office;
use App\Models\WorkSchedule;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\AttendancePhoto;
use App\Models\LeaveRequest;

test('models can be created with uuid and bidirectional relations', function () {
    $role = Role::create(['name' => 'employee', 'label' => 'Karyawan']);
    $region = Region::create(['code' => 'DKI', 'name' => 'DKI Jakarta']);
    $office = Office::create([
        'region_id' => $region->id,
        'code' => 'HQ',
        'name' => 'Kantor Pusat',
    ]);
    $schedule = WorkSchedule::create([
        'office_id' => $office->id,
        'name' => 'Reguler',
        'code' => 'REG',
        'check_in_time' => '08:00',
        'check_out_time' => '17:00',
    ]);

    $user = User::create([
        'name' => 'Siti',
        'email' => 'siti@example.com',
        'password' => bcrypt('secret'),
        'role_id' => $role->id,
        'office_id' => $office->id,
        'work_schedule_id' => $schedule->id,
    ]);

    $attendance = Attendance::create([
        'user_id' => $user->id,
        'attendance_date' => '2026-10-26',
        'status' => 'hadir',
    ]);

    expect($attendance->id)->not->toBeNull()
        ->and($attendance->user->id)->toBe($user->id)
        ->and($user->attendances->first()->id)->toBe($attendance->id);
});
```

- [ ] **Step 2: Run test to verify it fails**
Run: `vendor/bin/pest tests/Feature/AttendanceModelRelationsTest.php`
Expected: FAIL (Class Role not found).

- [ ] **Step 3: Implement the 10 Eloquent Models**
Write the models with `fillable`, `casts`, `SoftDeletes`, `HasUuids`, and relationships.

- [ ] **Step 4: Run test to verify it passes**
Run: `vendor/bin/pest tests/Feature/AttendanceModelRelationsTest.php`
Expected: PASS.

---

### Task 4: Master Seeders & Fresh Seed Verification

**Files:**
- Create: `database/seeders/RoleSeeder.php`
- Create: `database/seeders/OfficeScheduleSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`
- Test: `tests/Feature/DatabaseSeederTest.php`

**Interfaces:**
- Produces: Executable `php artisan db:seed` seeding roles, head office, default schedule, and admin account.

- [ ] **Step 1: Write the failing seeder test**
Create `tests/Feature/DatabaseSeederTest.php`:
```php
<?php

use App\Models\Role;
use App\Models\Office;
use App\Models\User;

test('database seeder populates roles offices and admin user', function () {
    $this->artisan('db:seed');

    expect(Role::count())->toBeGreaterThanOrEqual(3)
        ->and(Office::where('code', 'HQ')->exists())->toBeTrue()
        ->and(User::where('email', 'admin@presensi.local')->exists())->toBeTrue();
});
```

- [ ] **Step 2: Run test to verify it fails**
Run: `vendor/bin/pest tests/Feature/DatabaseSeederTest.php`
Expected: FAIL.

- [ ] **Step 3: Implement Seeders**
Write `RoleSeeder.php`, `OfficeScheduleSeeder.php`, and update `DatabaseSeeder.php` to seed roles (`admin`, `supervisor`, `employee`), default office, default schedule, and default admin user.

- [ ] **Step 4: Run test to verify it passes**
Run: `vendor/bin/pest tests/Feature/DatabaseSeederTest.php`
Expected: PASS.

- [ ] **Step 5: Run full test suite & format code**
Run: `vendor/bin/pest && vendor/bin/pint --format agent`
Expected: All tests pass (20+ assertions).
