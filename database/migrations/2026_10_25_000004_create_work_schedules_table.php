<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->nullable()->constrained('offices')->onUpdate('cascade')->onDelete('set null');
            $table->string('code', 30)->unique();
            $table->string('name', 100);
            $table->time('check_in_time');
            $table->time('check_out_time');
            $table->unsignedSmallInteger('grace_minutes')->default(15);
            $table->string('work_days', 30)->default('1,2,3,4,5');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_schedules');
    }
};
