<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

//        DB::table('ticket_types')->insert([
//            ["nome" =>"Bug","priority" => 100,"company_id" => 1],
//            ["nome" =>"Implementazione","priority" => 30,"company_id" => 1],
//            ["nome" =>"Modifica","priority" => 60,"company_id" => 1],
//        ]);//Tipi ticket

//        DB::table('services')->insert([
//            ["name" =>"Informatica","priority" => 100,"company_id" => 1],
//            ["name" =>"Studi legali","priority" => 90,"company_id" => 1],
//            ["name" =>"Installatori","priority" => 50,"company_id" => 1],
//            ["name" =>"Vigilanza","priority" => 30,"company_id" => 1],
//        ]);//Settore

        DB::table('user_types')->insert([
            ["descrizione" =>"amministratore"],
            ["descrizione" =>"medico"],
            ["descrizione" =>"paziente"],
            ["descrizione" =>"segretaria"],
        ]);//Settore
    }
}
