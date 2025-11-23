<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RBACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rules')->insert([
            'name' => 'Мой профиль',
            'path' => '/profile'
        ]);
        foreach (DB::table('rules')->get() as $rule) {
            foreach (DB::table('users')->get() as $user) {
                DB::table('permissions')->insert([
                    'user_id' => $user->id,
                    'rule_id' => $rule->id,
                ]);
            }
        }
    }
}
