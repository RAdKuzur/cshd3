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
        //positions
        DB::table('positions')->insert([
           'name' => 'Разработчик'
        ]);
        //people
        DB::table('people')->insert([
            'firstname' => 'Кирилл',
            'surname' => 'Шумак',
            'patronymic' => null,
            'phone_number' => '+77777777777',
            'birthdate' => now(),
            'organization_id' => DB::table('organizations')->first()->id,
            'user_id' => DB::table('users')->where('username', 'kshumak')->first()->id,
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

        DB::table('people')->insert([
            'firstname' => 'Тимур',
            'surname' => 'Ягафаров',
            'patronymic' => null,
            'phone_number' => '+77777777777',
            'birthdate' => now(),
            'organization_id' => DB::table('organizations')->first()->id,
            'user_id' => DB::table('users')->where('username', 'tyagafarov')->first()->id,
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

        DB::table('people')->insert([
            'firstname' => 'Радмир',
            'surname' => 'Кузургалиев',
            'patronymic' => null,
            'phone_number' => '+77777777777',
            'birthdate' => now(),
            'organization_id' => DB::table('organizations')->first()->id,
            'user_id' => DB::table('users')->where('username', 'rkuzurgaliev')->first()->id,
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

        DB::table('people')->insert([
            'firstname' => 'Руфат',
            'surname' => 'Идилов',
            'patronymic' => null,
            'phone_number' => '+77777777777',
            'birthdate' => now(),
            'organization_id' => DB::table('organizations')->first()->id,
            'user_id' => DB::table('users')->where('username', 'ridilov')->first()->id,
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
//        foreach(DB::table('organizations')->get() as $organization) {
//            foreach (DB::table('users')->get() as $index => $user) {
//                DB::table('people')->insert([
//                    'firstname' => 'John' . $index,
//                    'surname' => 'Doe' . $index,
//                    'patronymic' => 'Doevich' . $index,
//                    'phone_number' => '+77777777777',
//                    'birthdate' => now(),
//                    'organization_id' => $organization->id,
//                    'user_id' => $user->id,
//                    'icon_link' => '/person.jpg',
//                    'auditorium_id' => Auditorium::inRandomOrder()->value('id'),
//                    'is_active' => true,
//                    'about' => json_encode([
//                        'bio' => 'ABOUT ME TEXT',
//                        'workExperience' => [
//                            [
//                                'position' => 'Senior Frontend Developer',
//                                'company' => 'Tech Solutions Inc.',
//                                'period' => '2022 - настоящее время',
//                                'description' => 'Разработка и поддержка крупного SaaS-продукта. Руководство командой из 3 разработчиков. Внедрение микросервисной архитектуры.',
//                                'technologies' => [
//                                    'Коммуникабельность', 'TypeScript', 'GraphQL', 'Jest', 'Docker'
//                                ]
//                            ]
//                        ],
//                        'education' => [
//                            [
//                                'institution' => 'Санкт-Петербургский Политехнический Университет',
//                                'degree' => 'Бакалавр информатики',
//                                'period' => '2011 - 2015',
//                                'description' => 'Основы программирования, алгоритмы и структуры данных.'
//                            ]
//                        ],
//                        'skills' => [
//                            'Общение', 'Мудрость'
//                         ]
//                    ])
//                ]);
//            }
//        }
        //people_positions
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
