<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create specializations table
        Schema::create('specializations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // 2. Create complaints table
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('specialization_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 3. Add specialization_id to doctors table
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreignId('specialization_id')->nullable()->after('specialization')->constrained()->onDelete('set null');
        });

        // 4. Add columns to visits table
        Schema::table('visits', function (Blueprint $table) {
            $table->foreignId('complaint_id')->nullable()->after('doctor_id')->constrained()->onDelete('set null');
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan'])->default('menunggu')->after('complaint_id');
            $table->date('booking_date')->nullable()->after('status');
            $table->time('booking_time')->nullable()->after('booking_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropForeign(['complaint_id']);
            $table->dropColumn(['complaint_id', 'status', 'booking_date', 'booking_time']);
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['specialization_id']);
            $table->dropColumn('specialization_id');
        });

        Schema::dropIfExists('complaints');
        Schema::dropIfExists('specializations');
    }
};
