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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id')->references("id")->on("users");
            $table->integer('patient_id')->references("id")->on("users");
            $table->integer('clinic_id')->references("id")->on("clinics");
            $table->integer('tipo')->nullable();
            $table->integer('quantita')->nullable();
            $table->integer('minuti')->nullable();
            $table->integer('giorno')->nullable();
            $table->string('inizio')->nullable();
            $table->binary('attivo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
