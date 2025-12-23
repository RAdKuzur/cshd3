<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            OrganizationSeeder::class,
            DepartmentSeeder::class,
            BranchSeeder::class,
            AuditoriumSeeder::class,
            PositionSeeder::class,
            PeopleSeeder::class,
            AuditoriumResponsibilitySeeder::class,
            //ThingSeeder::class,
            //TransferActSeeder::class
        ]);
    }
}
