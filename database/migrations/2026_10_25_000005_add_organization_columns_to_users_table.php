<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_code', 50)->nullable()->unique()->after('id');
            $table->foreignId('role_id')->nullable()->after('password')->constrained('roles')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('office_id')->nullable()->after('role_id')->constrained('offices')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('supervisor_id')->nullable()->after('office_id')->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('work_schedule_id')->nullable()->after('supervisor_id')->constrained('work_schedules')->onUpdate('cascade')->onDelete('set null');
            $table->string('phone', 30)->nullable()->after('email');
            $table->string('avatar_path', 255)->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('remember_token');
            $table->softDeletes()->after('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['office_id']);
            $table->dropForeign(['supervisor_id']);
            $table->dropForeign(['work_schedule_id']);
            $table->dropColumn([
                'employee_code',
                'role_id',
                'office_id',
                'supervisor_id',
                'work_schedule_id',
                'phone',
                'avatar_path',
                'is_active',
                'deleted_at',
            ]);
        });
    }
};
