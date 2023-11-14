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
                    "tickets.create",
                    "tickets.list",
                    "tickets.edit",
                    "services.create",
                    "services.list",
                    "services.edit",
                    "tipiTickets.create",
                    "tipiTickets.list",
                    "tipiTickets.edit",
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
                    "tickets.create",
                    "tickets.list",
                    "tickets.edit",
                    "services.create",
                    "services.list",
                    "services.edit",
                    "tipiTickets.create",
                    "tipiTickets.list",
                    "tipiTickets.edit",
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
                    "tickets.create",
                    "tickets.list",
                    "tickets.edit",
                    "services.create",
                    "services.list",
                    "services.edit",
                    "tipiTickets.create",
                    "tipiTickets.list",
                    "tipiTickets.edit",
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
                    "tickets.create",
                    "tickets.list",
                    "tickets.edit",
                    "services.create",
                    "services.list",
                    "services.edit",
                    "tipiTickets.create",
                    "tipiTickets.list",
                    "tipiTickets.edit",
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
