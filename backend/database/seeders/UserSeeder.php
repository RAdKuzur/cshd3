<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        for ($i = 1; $i <= 100; $i++) {
            DB::table('users')->insert([
                'username' => 'user' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password')
            ]);
        }
    }
}
