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
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->references("id")->on("users");
            $table->string('nome')->nullable();
            $table->string('indirizzo')->nullable();
            $table->string('localita')->nullable();
            $table->string('cap')->nullable();
            $table->string('provincia')->nullable();
            $table->string('telefono')->nullable();
            $table->boolean('attivo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
