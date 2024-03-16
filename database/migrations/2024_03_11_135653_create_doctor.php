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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 25)->unique();
            $table->string('sip', 50)->unique();
            $table->string('doctor_id', 10)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('role');
            $table->string('degree');
            $table->string('specialization');
            $table->string('hospital');
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('zip');
            $table->string('country');
            $table->string('polyName');
            $table->string('photo');
            $table->string('status');
            $table->string('polyclinic_id');
            $table->string('is_active');
            $table->foreign('polyclinic_id')->references('polyID')->on('polyclinics');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
