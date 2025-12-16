<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //rules
        DB::table('rules')->truncate();
        $allRoutes = Route::getRoutes();
        foreach ($allRoutes as $index => $route) {
            if (trim($route->getName()) !== '' && $route->getName() !== 'storage.local') {
                DB::table('rules')->insert([
                    'path' => $route->getName(),
                    'name' => 'Правило' . $index
                ]);
            }
        }
        //permissions
        DB::table('permissions')->truncate();
        foreach (DB::table('rules')->get() as $rule) {
            foreach (DB::table('users')->get() as $users) {
                DB::table('permissions')->insert([
                   'rule_id' => $rule->id,
                   'user_id' => $users->id,
                ]);
            }
        }
    }
}
