<?php

namespace App\Services;

use App\DTO\User\ProfileDTO;
use App\DTO\User\UserDTO;
use App\Models\User;
use App\Repositories\PeopleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

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

    public function getProfileInfo($username) : ProfileDTO
    {
        $user = $this->userRepository->getByUsername($username);
        return new ProfileDTO(
            user: [
                'id' => $user->id,
                'name' => $user->people->getFullFio(),
                'position' => $user->people->getPosition()->name,
                'department' => $user->people->getBranch()->name,
                'email' => $user->email,
                'phone' => $user->people->phone_number,
                'bio' => $user->people->getBio(),
                'avatar' => $user->people->icon_link,
                'skills' => $user->people->getSkills()
            ],
            contacts: [
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
            workExperience: $user->people->getWorkExperience(),
            education: $user->people->getEducation(),
        );
    }
    public function getUserInfoAll() : array
    {
        $users = $this->userRepository->getAll();
        $data = [];
        foreach ($users as $user){
            if($user){
                $data[] = new UserDTO(
                    id: $user->id,
                    firstname: $user->people->firstname,
                    surname: $user->people->surname,
                    patronymic: $user->people->patronymic,
                    username: $user->username,
                    email: $user->email,
                    phone: $user->people->phone_number,
                    birthdate: $user->people->birthdate,
                    auditorium_id: $user->people->auditorium_id,
                    bio: $user->people->getBio(),
                    role: $user->role
                );
            }
        }
        return $data;
    }
    public function getUserInfo($id)
    {
        $user = $this->userRepository->get($id);
        $data = $user ? new UserDTO(
            id: $user->id,
            firstname: $user->people->firstname,
            surname: $user->people->surname,
            patronymic: $user->people->patronymic,
            username: $user->username,
            email: $user->email,
            phone: $user->people->phone_number,
            birthdate: $user->people->birthdate,
            auditorium_id: $user->people->auditorium_id,
            bio: $user->people->getBio(),
            role: $user->role
        ) : null;
        return $data;
    }
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $data['user_id'] = $this->userRepository->create($data);
            $this->peopleRepository->create($data);
            DB::commit();
        }
        catch (\Exception $exception){
            DB::rollBack();
        }
    }
    public function update($id, $data){
        DB::beginTransaction();
        try {
            $this->userRepository->update($id, $data);
            $user = $this->userRepository->get($id);
            $this->peopleRepository->updateByUserId($user->id, $data);
            DB::commit();
        }
        catch (\Exception $exception){
            DB::rollBack();
        }
    }
    public function delete($id){
        DB::beginTransaction();
        try {
            $user = $this->userRepository->get($id);
            $this->peopleRepository->deleteByUserId($user->id);
            $this->userRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $exception){
            DB::rollBack();
        }
    }
}
