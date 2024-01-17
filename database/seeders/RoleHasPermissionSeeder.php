<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RolesEnum::cases() as $role) {
            if ($role->value === RolesEnum::admin_system->value) {
                $role = Role::findByName($role->value);
                $role->givePermissionTo('create_tenant');
                $role->givePermissionTo('update_tenant');
                $role->givePermissionTo('read_tenant');
                $role->givePermissionTo('delete_tenant');
            }
        }
    }
}
