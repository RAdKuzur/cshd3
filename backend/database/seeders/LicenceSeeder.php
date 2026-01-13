<?php

namespace Database\Seeders;

use App\Dictionaries\LicenceDictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class LicenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('licences')->truncate();
        DB::table('licences')->insert([
            'code' => Crypt::encrypt('licence_code'),
            'expires_at' => now()->addDays(30),
            'is_revoked' => LicenceDictionary::ACTIVE
        ]);
    }
}
