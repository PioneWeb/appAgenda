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
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('Principio_Attivo')->nullable();
            $table->string('Descrizione_Gruppo')->nullable();
            $table->string('Denominazione_e_Confezione')->nullable();
            $table->string('Prezzo_al_pubblico')->nullable();
            $table->string('Prezzo_Exfactory')->nullable();
            $table->string('Prezzo_massimo_di_cessione')->nullable();
            $table->string('Titolare_AIC')->nullable();
            $table->string('Codice_AIC')->nullable();
            $table->string('Codice_Gruppo_Equivalenza')->nullable();
            $table->string('Metri_cubi_ossigeno')->nullable();
            $table->string('lista_di_trasparenza_Aifa')->nullable();
            $table->string('Solo_in_lista_di_Regione')->nullable();
            $table->string('tipo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drugs');
    }
};
