<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array
     * @var  User $user
     */
    public function getProfileInfo($username)
    {
        $user = $this->userRepository->getByUsername($username);
        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->people->getFullFio(),
                'position' => $user->people->getPosition(),
                'department' => $user->people->getBranchName(),
                'email' => $user->email,
                'phone' => $user->people->phone_number,
                'bio' => $user->people->getBio(),
                'avatar' => $user->people->icon_link,
                'skills' => $user->people->getSkills()
            ],
            'contacts' => [
                [
                    'type' => 'email',
                    'value' => $user->email,
                    'icon' => '📧'
                ],
                [
                    'type' => 'phone',
                    'value' => $user->people->phone_number,
                    'icon' => '📱'
                ]
            ],
            'workExperience' => $user->people->getWorkExperience(),
            'education' => $user->people->getEducation(),
        ];
    }
}
