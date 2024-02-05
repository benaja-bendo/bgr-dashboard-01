<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermissionTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RolesEnum::cases() as $role) {
            switch ($role->value) {
                case RolesEnum::student->value:
                    // add permissions to student
                    break;
                case RolesEnum::teacher->value:
                    // add permissions to teacher
                    break;
                case RolesEnum::admin_school->value:
                    $role = Role::findByName($role->value);
                    $role->givePermissionTo('read_student');
                    $role->givePermissionTo('create_student');
                    $role->givePermissionTo('update_student');
                    $role->givePermissionTo('delete_student');
                    break;
            }
        }
    }
}
