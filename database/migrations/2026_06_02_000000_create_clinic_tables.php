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
        // 1. Doctors table
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialization');
            $table->string('schedule');
            $table->string('phone');
            $table->timestamps();
            $table->softDeletes(); // Enable soft deletes for records
        });

        // 2. Patients table
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('nik', 16)->unique();
            $table->date('birth_date');
            $table->string('phone');
            $table->text('address');
            $table->timestamps();
            $table->softDeletes(); // Enable soft deletes for records
        });

        // 3. Visits table
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->date('visit_date');
            $table->text('complaint');
            $table->text('diagnosis');
            $table->timestamps();
            $table->softDeletes(); // Enable soft deletes for records
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('doctors');
    }
};
