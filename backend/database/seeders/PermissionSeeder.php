<?php

namespace Database\Seeders;

use App\Dictionaries\RoleDictionary;
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
        $allRoutes = RoleDictionary::ADMIN_RULES;
        foreach ($allRoutes as $index => $route) {
            DB::table('rules')->insert([
                'path' => $route,
                'name' => 'Правило' . $index
            ]);
        }
        //permissions
        DB::table('permissions')->truncate();
        foreach (RoleDictionary::rules(RoleDictionary::ADMIN) as $path) {
            $rule = DB::table('rules')->where('path', $path)->first();
            DB::table('permissions')->insert([
                'rule_id' => $rule->id,
                'role' => RoleDictionary::ADMIN,
            ]);
        }

        foreach (RoleDictionary::rules(RoleDictionary::DIRECTOR) as $path) {
            $rule = DB::table('rules')->where('path', $path)->first();
            DB::table('permissions')->insert([
                'rule_id' => $rule->id,
                'role' => RoleDictionary::DIRECTOR,
            ]);
        }

        foreach (RoleDictionary::rules(RoleDictionary::WORKER) as $path) {
            $rule = DB::table('rules')->where('path', $path)->first();
            DB::table('permissions')->insert([
                'rule_id' => $rule->id,
                'role' => RoleDictionary::WORKER,
            ]);
        }


        foreach (RoleDictionary::rules(RoleDictionary::STAFF_MANAGER) as $path) {
            $rule = DB::table('rules')->where('path', $path)->first();
            DB::table('permissions')->insert([
                'rule_id' => $rule->id,
                'role' => RoleDictionary::STAFF_MANAGER,
            ]);
        }

        foreach (RoleDictionary::rules(RoleDictionary::ACCOUNTANT) as $path) {
            $rule = DB::table('rules')->where('path', $path)->first();
            DB::table('permissions')->insert([
                'rule_id' => $rule->id,
                'role' => RoleDictionary::ACCOUNTANT,
            ]);
        }
    }
}
