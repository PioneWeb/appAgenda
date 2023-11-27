<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                "name" => "amministratore",
                "permissions" => [
                    "user.create",
                    "user.edit",
                    "user.list",
                    "company.create",
                    "company.list",
                    "company.edit",
                    "customers.create",
                    "customers.list",
                    "customers.edit",
                    "clinics.create",
                    "clinics.list",
                    "clinics.edit",
                    "prescriptions.create",
                    "prescriptions.list",
                    "prescriptions.edit",
                    "schedules.create",
                    "schedules.list",
                    "schedules.edit",
                    "events.create",
                    "events.list",
                    "events.edit",
                ]
            ],
            [
                "name" => "medico",
                "permissions" => [
                    "user.create",
                    "user.edit",
                    "user.list",
                    "company.create",
                    "company.list",
                    "company.edit",
                    "customers.create",
                    "customers.list",
                    "customers.edit",
                    "clinics.create",
                    "clinics.list",
                    "clinics.edit",
                    "prescriptions.create",
                    "prescriptions.list",
                    "prescriptions.edit",
                    "schedules.create",
                    "schedules.list",
                    "schedules.edit",
                    "events.create",
                    "events.list",
                    "events.edit",
                ]
            ],
            [
                "name" => "segretaria",
                "permissions" => [
                    "user.create",
                    "user.edit",
                    "user.list",
                    "company.create",
                    "company.list",
                    "company.edit",
                    "customers.create",
                    "customers.list",
                    "customers.edit",
                    "clinics.create",
                    "clinics.list",
                    "clinics.edit",
                    "prescriptions.create",
                    "prescriptions.list",
                    "prescriptions.edit",
                    "schedules.create",
                    "schedules.list",
                    "schedules.edit",
                    "events.create",
                    "events.list",
                    "events.edit",
                ]
            ],
            [
                "name" => "paziente",
                "permissions" => [
                    "user.create",
                    "user.edit",
                    "user.list",
                    "company.create",
                    "company.list",
                    "company.edit",
                    "customers.create",
                    "customers.list",
                    "customers.edit",
                    "clinics.create",
                    "clinics.list",
                    "clinics.edit",
                    "prescriptions.create",
                    "prescriptions.list",
                    "prescriptions.edit",
                    "schedules.create",
                    "schedules.list",
                    "schedules.edit",
                    "events.create",
                    "events.list",
                    "events.edit",
                ]
            ]
        ];

        foreach($roles as $role) {
            $rl = Role::firstOrCreate([
                "name" => $role["name"],
                "guard_name"=> "web"
            ]);
            foreach($role["permissions"] as $perm) {
                Permission::firstOrCreate(["name" => $perm]);
                $rl->givePermissionTo($perm);
            }
        }
    }
}
