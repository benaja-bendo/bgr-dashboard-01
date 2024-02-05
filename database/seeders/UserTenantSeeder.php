<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RolesEnum::cases() as $role) {
            if ($role->has(RolesEnum::student->value)) {
                $user = User::factory(100)->create()
                    ->each(function ($user) {
                        $user->assignRole(RolesEnum::student->value);
                        $user->student()->create();
                    });

                return;
            }
            $user = User::factory()->create([
                'last_name' => $role->label(),
                'email' => strtolower($role->label()) . '@example.com',
            ]);
            $user->assignRole($role->value);
        }
    }
}
