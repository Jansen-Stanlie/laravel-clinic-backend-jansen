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
        //create table doctor_schedule
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_id', 10);
            $table->string('polyclinic_id', 10);
            $table->string('doctor_name');
            $table->date('date_schedule');
            $table->string('day');
            $table->time('start');
            $table->string('specialization');
            $table->time('end');
            $table->enum('status', ['available', 'booked'])->default('available'); // Define as enum with default value 'available'
            $table->timestamps();
            $table->foreign('doctor_id')->references('doctor_id')->on('doctors');
            $table->foreign('polyclinic_id')->references('polyID')->on('polyclinics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //rollback table doctor_schedule
        Schema::dropIfExists('schedules');
    }
};
