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
            if ($role->value === RolesEnum::student->value) {
                // add permissions to student
            } elseif ($role->value === RolesEnum::teacher->value) {
                // add permissions to teacher
            } elseif ($role->value === RolesEnum::admin_school->value) {
                // TODO test relation
//                $role = Role::findByName($role->value);
//                $role->givePermissionTo('read_student');
//                $role->givePermissionTo('create_student');
//                $role->givePermissionTo('update_student');
//                $role->givePermissionTo('delete_student');
            }
        }
    }
}
