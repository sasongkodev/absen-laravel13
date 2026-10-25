<?php

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

test('attendance transactional tables exist with expected constraints', function () {
    expect(Schema::hasTable('attendances'))->toBeTrue()
        ->and(Schema::hasTable('attendance_logs'))->toBeTrue()
        ->and(Schema::hasTable('attendance_photos'))->toBeTrue()
        ->and(Schema::hasTable('leave_requests'))->toBeTrue()
        ->and(Schema::hasTable('audit_logs'))->toBeTrue();
});

test('attendances table prevents duplicate check in on same date', function () {
    $userId = DB::table('users')->insertGetId([
        'name' => 'Budi',
        'email' => 'budi@example.com',
        'password' => bcrypt('secret'),
        'created_at' => now(),
    ]);

    $uuid1 = (string) Str::uuid();
    $uuid2 = (string) Str::uuid();

    DB::table('attendances')->insert([
        'id' => $uuid1,
        'user_id' => $userId,
        'attendance_date' => '2026-10-25',
        'status' => 'hadir',
        'created_at' => now(),
    ]);

    expect(fn () => DB::table('attendances')->insert([
        'id' => $uuid2,
        'user_id' => $userId,
        'attendance_date' => '2026-10-25',
        'status' => 'hadir',
        'created_at' => now(),
    ]))->toThrow(QueryException::class);
});
