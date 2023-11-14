<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            "attivo" => 1,
            "email" => "info@s-mart.biz",
            "ragione_sociale" => "Network SAS",
            "piva" => "05345670482",
            "indirizzo" => "Via Emidio Spinucci 41",
            "localita" => "Firenze",
            "cap" => "50141",
            "provincia" => "FI",
            "logo" => "",
            "iban" => "IT0123569874521023152125412",
            "telefono" => "055430352",
            "cellulare" => "3393012514",
            "codice_destinatario" => "TRS30H9",
            "pec" => "",
            "privato" => 1,
            "pubblico" => 0
        ]);

        $sa = User::firstOrCreate([
            "name" => "Amministratore",
            "password" => Hash::make("ALF1123pmp!"),
            "email" => "luca@s-mart.biz",
            "indirizzo" => "Via Vittorio Emanuele II, 279",
            "localita" => "Firenze",
            "cap" => "50134",
            "provincia" => "FI",
            "profile_photo_path" => "profile-photos/nlPYdbJdDFM1N3Z1wM9jFolLmGipJgYsY6FyS5op.png",
            "company_id" => 1,
            "user_type_id" => 1
        ]);

        if(!$sa->hasRole("amministratore")) {
            $sa->assignRole("amministratore");
        }

        $sa = User::firstOrCreate([
            "name" => "Luca Mistretta",
            "password" => Hash::make("ALF1123pmp!"),
            "email" => "lucanetworksas@gmail.com",
            "indirizzo" => "Via Vittorio Emanuele II, 279",
            "localita" => "Firenze",
            "cap" => "50134",
            "provincia" => "FI",
            "profile_photo_path" => "profile-photos/LMcM5k1WlVUBXjUIo35e3sNJ6DRDbEuc5JcsxgHQ.jpg",
            "company_id" => 1,
            "user_type_id" => 2
        ]);

        if(!$sa->hasRole("medico")) {
            $sa->assignRole("medico");
        }

        $sa = User::firstOrCreate([
            "name" => "Segretaria",
            "password" => Hash::make("ALF1123pmp!"),
            "email" => "segretaria@nwk.it",
            "indirizzo" => "Piazza Dalmazia, 5",
            "localita" => "Firenze",
            "cap" => "50134",
            "provincia" => "FI",
            "profile_photo_path" => "profile-photos/h8KXFq4QsjdWJ8sxpD7GJ7ITNVfTThKdc1cAfUyI.png",
            "company_id" => 1,
            "user_type_id" => 4
        ]);

        if(!$sa->hasRole("segretaria")) {
            $sa->assignRole("segretaria");
        }

        $sa = User::firstOrCreate([
            "name" => "Paolo Rossi Medico",
            "password" => Hash::make("ALF1123pmp!"),
            "email" => "paolo@nwk.it",
            "indirizzo" => "Via Emidio Spinucci 41",
            "localita" => "Firenze",
            "cap" => "50141",
            "provincia" => "FI",
            "profile_photo_path" => "profile-photos/0U2B5b9SddSRHTKTyy02Vv7gbRy5YWV7XpR7qu09.jpg",
            "company_id" => 1,
            "user_type_id" => 3
        ]);

        if(!$sa->hasRole("paziente")) {
            $sa->assignRole("paziente");
        }
    }
}
