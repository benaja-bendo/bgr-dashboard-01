<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creation du tenant
        $tenant = \App\Models\Tenant::create(['id' => 'EPSI']);

        // Creation de l'ecole
        $tenant->school()->create([
            'name' => 'EPSI',
        ]);

        // Creation des roles, permissions et utilisateurs de base
        $tenant->run(function () {
            $this->call([
                RoleSeeder::class,
                PermissionTenantSeeder::class,
                RoleHasPermissionTenantSeeder::class,
                UserTenantSeeder::class,
            ]);
        });
    }
}
