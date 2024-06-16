<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'user',
            'role',
            'permission',
            'student',
            // add more models here
        ];
        foreach (PermissionEnum::cases() as $permission) {
            foreach ($models as $model) {
                Permission::create(['name' => strtolower($permission->value) . '_' . $model]);
            }
        }
    }
}
