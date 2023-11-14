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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->boolean("attivo")->default(true);
            $table->string("email")->nullable();
            $table->string("ragione_sociale");
            $table->string("indirizzo")->nullable();
            $table->string("localita")->nullable();
            $table->string("cap")->nullable();
            $table->string("provincia")->nullable();
            $table->string("logo")->nullable();
            $table->string("piva",20)->nullable();
            $table->string("iban",30)->nullable();
            $table->string("telefono",40)->nullable();
            $table->string("cellulare",40)->nullable();
            $table->string("codice_destinatario",7)->nullable();
            $table->string("pec")->nullable();
            $table->boolean("privato")->default(false);
            $table->boolean("pubblico")->default(false);

            $table->timestamps();
            $table->unique(["piva"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
