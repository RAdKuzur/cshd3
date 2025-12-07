<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\PeopleRepository;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;
    private PeopleRepository $peopleRepository;
    public function __construct(
        UserRepository $userRepository,
        PeopleRepository $peopleRepository

    )
    {
        $this->userRepository = $userRepository;
        $this->peopleRepository = $peopleRepository;
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
    public function getUserInfoAll(){
        $users = $this->userRepository->getAll();
        $data = [];
        foreach ($users as $user){
            $data[] = [
                'id' => $user->id,
                'firstname' => $user->people->firstname,
                'surname' => $user->people->surname,
                'patronymic' => $user->people->patronymic,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->people->phone_number,
                'birthdate' => $user->people->birthdate,
                'auditorium_id' => $user->people->auditorium_id,
                'bio' => $user->people->getBio(),
//                'avatar' => $user->people->icon_link,
//                'skills' => $user->people->getSkills(),
//                'workExperience' => $user->people->getWorkExperience(),
//                'education' => $user->people->getEducation(),
            ];
        }
        return $data;
    }
    public function getUserInfo($id)
    {
        $user = $this->userRepository->getById($id);

        $data = $user ? [
            'id' => $user->id,
            'firstname' => $user->people->firstname,
            'surname' => $user->people->surname,
            'patronymic' => $user->people->patronymic,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->people->phone_number,
            'birthdate' => $user->people->birthdate,
            'auditorium_id' => $user->people->auditorium_id,
            'bio' => $user->people->getBio(),
//            'avatar' => $user->people->icon_link,
//            'skills' => $user->people->getSkills(),
//            'workExperience' => $user->people->getWorkExperience(),
//            'education' => $user->people->getEducation(),
        ] : null;
        return $data;
    }
    public function create($data)
    {
        //refactoring
        $this->userRepository->create($data);
        $user = $this->userRepository->getByUsername($data['username']);
        $data['user_id'] = $user->id;
        $this->peopleRepository->create($data);
    }
    public function update($id, $data){
        //refactoring
        $this->userRepository->update($id, $data);
        $user = $this->userRepository->getById($id);
        $this->peopleRepository->updateByUserId($user->id, $data);
    }
    public function delete($id){
        //refactoring
        $user = $this->userRepository->getById($id);
        $this->peopleRepository->deleteByUserId($user->id);
        return $this->userRepository->delete($id);
    }
}
