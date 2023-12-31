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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->references("id")->on("users");
            $table->foreignId('patient_id')->nullable()->references("id")->on("users");
            $table->foreignId('clinic_id')->references("id")->on("clinics");
            $table->string('denominazione')->nullable();

            $table->string("title")->nullable();
            $table->dateTime("start")->nullable();
            $table->dateTime("end")->nullable();

//            $table->date('data')->nullable();
//            $table->time('ora')->nullable();

            $table->integer('stato')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
