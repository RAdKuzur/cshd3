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
                'about' => json_encode([
                    'bio' => 'ABOUT ME TEXT',
                    'workExperience' => [
                        [
                            'position' => 'Senior Frontend Developer',
                            'company' => 'Tech Solutions Inc.',
                            'period' => '2022 - настоящее время',
                            'description' => 'Разработка и поддержка крупного SaaS-продукта. Руководство командой из 3 разработчиков. Внедрение микросервисной архитектуры.',
                            'technologies' => [
                                'Коммуникабельность', 'TypeScript', 'GraphQL', 'Jest', 'Docker'
                            ]
                        ]
                    ],
                    'education' => [
                        [
                            'institution' => 'Санкт-Петербургский Политехнический Университет',
                            'degree' => 'Бакалавр информатики',
                            'period' => '2011 - 2015',
                            'description' => 'Основы программирования, алгоритмы и структуры данных.'
                        ]
                    ],
                    'skills' => [
                        'Общение', 'Мудрость'
                    ]
                ])
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
