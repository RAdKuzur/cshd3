<?php

namespace Database\Seeders;

use App\Dictionaries\RoleDictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'username' => 'yagafarov',
            'email' => 'yagafarov@example.com',
            'password' => Hash::make('password'),
            'role' => RoleDictionary::ADMIN
        ]);

        DB::table('users')->insert([
            'username' => 'idilov',
            'email' => 'idilov@example.com',
            'password' => Hash::make('password'),
            'role' => RoleDictionary::ADMIN
        ]);

        DB::table('users')->insert([
            'username' => 'shumak',
            'email' => 'shumak@example.com',
            'password' => Hash::make('password'),
            'role' => RoleDictionary::ADMIN
        ]);

        DB::table('users')->insert([
            'username' => 'kuzurgaliev',
            'email' => 'drive16052003@gmail.com',
            'password' => Hash::make('password'),
            'role' => RoleDictionary::ADMIN
        ]);
    }
}
