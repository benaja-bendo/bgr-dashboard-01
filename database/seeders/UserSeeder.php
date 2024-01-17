<?php

namespace Database\Seeders;

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
            'name' => 'Root User',
            'email' => 'root@gmail.com',
        ]);
        $root->assignRole(\App\Constants\RoleConstants::ROOT);
    }
}
