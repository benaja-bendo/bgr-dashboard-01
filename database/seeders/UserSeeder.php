<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Address;
use App\Models\NumberPhone;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $root = \App\Models\User::factory()->create([
            'last_name' => 'Root User',
            'email' => 'root@example.com',
        ]);
        $root->assignRole(RolesEnum::root->value);

        NumberPhone::factory()->create([
            'user_id' => $root->id,
        ]);

        Address::factory()->create([
            'user_id' => $root->id,
        ]);

    }
}
