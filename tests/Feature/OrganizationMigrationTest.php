<?php

use Illuminate\Support\Facades\Schema;

test('organization master tables and user columns exist', function () {
    expect(Schema::hasTable('roles'))->toBeTrue()
        ->and(Schema::hasTable('regions'))->toBeTrue()
        ->and(Schema::hasTable('offices'))->toBeTrue()
        ->and(Schema::hasTable('work_schedules'))->toBeTrue()
        ->and(Schema::hasColumns('users', ['employee_code', 'role_id', 'office_id', 'work_schedule_id', 'is_active']))->toBeTrue();
});
