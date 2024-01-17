<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
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
            'email' => 'root@gmail.com',
        ]);
        $root->assignRole(RolesEnum::root->value);
         root->address()->create();
         $root->phoneNumber()->create();
    }
}
