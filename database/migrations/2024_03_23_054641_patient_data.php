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
        // Create table patient_data
        Schema::create('patient_data', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id', 10);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nik', 25)->unique();
            $table->string('phone');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('role');
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('zip');
            $table->string('country');
            $table->string('photo');
            $table->string('status');
            $table->string('last_checkup');
            $table->string('last_doctor');
            $table->text('diagnosis'); // Changed from string to text
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback table patient_data
        Schema::dropIfExists('patient_data');
    }
};
