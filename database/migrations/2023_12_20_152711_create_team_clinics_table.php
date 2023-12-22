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
        if (!Schema::hasTable('team_clinics')) {
            Schema::create('team_clinics', function (Blueprint $table) {
                $table->id();
                $table->foreignId('team_id')->nullable()->references("id")->on("team");
                $table->foreignId('clinic_id')->nullable()->references("id")->on("clinics");
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_clinics');
    }
};
