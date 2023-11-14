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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string("ticket")->nullable();
            $table->date("data")->nullable();
            $table->time("ora")->nullable();
            $table->integer("stato")->default(1);
            $table->foreignId("customer_id")->nullable()->references("id")->on("users");
            $table->foreignId("service_id")->nullable()->references("id")->on("services");
            $table->foreignId("ticket_type_id")->nullable()->references("id")->on("ticket_types");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
