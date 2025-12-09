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
        //user
        DB::table('users')->insert([
            'username' => 'kshumak',
            'email' => 'kshumak@example.com',
            'password' => Hash::make('password')
        ]);
        DB::table('users')->insert([
            'username' => 'ridilov',
            'email' => 'ridilov@example.com',
            'password' => Hash::make('password')
        ]);
        DB::table('users')->insert([
            'username' => 'tyagafarov',
            'email' => 'tyagafarov@example.com',
            'password' => Hash::make('password')
        ]);
        DB::table('users')->insert([
            'username' => 'rkuzurgaliev',
            'email' => 'rkuzurgaliev@example.com',
            'password' => Hash::make('password')
        ]);
    }
}
