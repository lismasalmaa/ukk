<?php

namespace Database\Seeders;

use App\Models\User;


use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'lisma',
            'email' => 'admin@gmail.com',
            'password' => '12345',
            'role' => 'admin',

       ]);
        User::create([
            'name' => 'enola',
            'email' => 'employee@gmail.com',
            'password' => '12345',
            'role' => 'employee',

       ]);
    }
}
