<?php

namespace Database\Seeders;

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
        foreach(DB::table('organizations')->get() as $organization) {
            foreach (DB::table('users')->get() as $user) {
                DB::table('people')->insert([
                    'firstname' => 'John',
                    'surname' => 'Doe',
                    'patronymic' => 'Doevich',
                    'phone_number' => '+77777777777',
                    'organization_id' => $organization->id,
                    'user_id' => $user->id,
                    'icon_link' => '/person.jpg',
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
        }
    }
}
