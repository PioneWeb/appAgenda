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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->nullable()->references("id")->on("users");
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('indirizzo')->nullable();
            $table->string("localita")->nullable();
            $table->string("cap")->nullable();
            $table->string("provincia")->nullable();
            $table->string("telefono")->nullable();
            $table->rememberToken();
            $table->foreignId('user_type_id')->nullable()->references("id")->on("user_types");
            $table->foreignId('current_team_id')->nullable();
            $table->foreignId("company_id")->nullable()->references("id")->on("companies");
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
