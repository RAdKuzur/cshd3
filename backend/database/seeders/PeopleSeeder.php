<?php

namespace Database\Seeders;

use App\Models\Auditorium;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //people
        DB::table('people')->truncate();
        foreach (DB::table('users')->get() as $user) {
            DB::table('people')->insert([
                'firstname' => 'firstname #' . $user->id,
                'surname' => 'surname #' . $user->id,
                'patronymic' => null,
                'phone_number' => '+77777777777',
                'birthdate' => now(),
                'organization_id' => DB::table('organizations')->first()->id,
                'user_id' => DB::table('users')->where('username', $user->username)->first()->id,
                'icon_link' => '/person.jpg',
                'auditorium_id' => Auditorium::inRandomOrder()->value('id'),
                'is_active' => true,
                'about' => fake()->text
            ]);
        }

        //people_positions
        DB::table('people_positions')->truncate();
        foreach(DB::table('people')->get() as $person) {
            $randomPositionId = DB::table('positions')->inRandomOrder()->first()->id;
            $randomBranchId = DB::table('branches')->inRandomOrder()->first()->id;
            DB::table('people_positions')->insert([
                'people_id' => $person->id,
                'position_id' => $randomPositionId,
                'branch_id' => $randomBranchId,
                'start_date' => now(),
                'end_date' => null
            ]);
        }
    }
}
