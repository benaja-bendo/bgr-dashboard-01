<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Address;
use App\Models\NumberPhone;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RolesEnum::cases() as $role) {
            // Creation des etudiants
            if ($role->has(RolesEnum::student->value)) {
                User::factory(20)->create()
                    ->each(function (User $user){
                        $user->assignRole(RolesEnum::student->value);
                        $user->studentInfos()->create([
                            'matriculate' => 'EPSI' . fake()->unique()->numberBetween(1000, 9999),
                        ]);
                        NumberPhone::factory(rand(0, 3))->create([
                            'user_id' => $user->id,
                        ]);

                        Address::factory(rand(0, 3))->create([
                            'user_id' => $user->id,
                        ]);
                    });

                return;
            }

            // Creation des autres roles
            $user = User::factory()->create([
                'last_name' => $role->label(),
                'email' => strtolower($role->label()) . '@example.com',
            ]);
            $user->assignRole($role->value);
            NumberPhone::factory(rand(0, 3))->create([
                'user_id' => $user->id,
            ]);

            Address::factory(rand(0, 3))->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
