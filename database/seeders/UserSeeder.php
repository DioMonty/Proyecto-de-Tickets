<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'username' => 'adminUser',
                'email' => 'admin@hotmail.com',
                'role' => 'admin',
                'status' => 'active',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Consultor User',
                'username' => 'consultorUser',
                'email' => 'consultor@hotmail.com',
                'role' => 'consultor',
                'status' => 'active',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'User',
                'username' => 'user04',
                'email' => 'user@hotmail.com',
                'role' => 'user',
                'status' => 'active',
                'password' => bcrypt('12345678'),
            ],
        ]);
    }
}
