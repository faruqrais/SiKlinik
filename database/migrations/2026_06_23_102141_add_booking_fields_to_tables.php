<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to add booking-related pricing and tracking columns to
 * 'doctors' and 'visits' tables.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add consultation_fee to doctors table
        Schema::table('doctors', function (Blueprint $table) {
            $table->decimal('consultation_fee', 10, 2)->default(0)->after('phone');
        });

        // Add booking details and status columns to visits table
        Schema::table('visits', function (Blueprint $table) {
            $table->string('booking_code')->nullable()->unique()->after('booking_time');
            $table->decimal('consultation_fee', 10, 2)->nullable()->after('booking_code');
            $table->decimal('admin_fee', 10, 2)->default(5000)->after('consultation_fee');
            $table->decimal('total_fee', 10, 2)->nullable()->after('admin_fee');
            $table->enum('payment_status', ['belum_bayar', 'sudah_bayar'])->default('belum_bayar')->after('total_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the booking columns from visits table
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn(['booking_code', 'consultation_fee', 'admin_fee', 'total_fee', 'payment_status']);
        });

        // Drop the consultation fee column from doctors table
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('consultation_fee');
        });
    }
};
