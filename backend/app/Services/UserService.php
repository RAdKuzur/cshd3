<?php

namespace App\Services;

use App\DTO\User\ProfileDTO;
use App\DTO\User\UserDTO;
use App\Helpers\LogHelper;
use App\Models\User;
use App\Repositories\AuditoriumResponsibilityRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\PeoplePositionRepository;
use App\Repositories\PeopleRepository;
use App\Repositories\TokenRepository;
use App\Repositories\TransferActConfirmRepository;
use App\Repositories\TransferActRepository;
use App\Repositories\TransferActThingRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    private UserRepository $userRepository;
    private PeopleRepository $peopleRepository;
    private NotificationRepository $notificationRepository;
    private TokenRepository $tokenRepository;
    private PeoplePositionRepository $peoplePositionRepository;
    private AuditoriumResponsibilityRepository $auditoriumResponsibilityRepository;
    private TransferActRepository $transferActRepository;
    private TransferActThingRepository $transferActThingRepository;
    private TransferActConfirmRepository $transferActConfirmRepository;
    public function __construct(
        UserRepository $userRepository,
        PeopleRepository $peopleRepository,
        NotificationRepository $notificationRepository,
        TokenRepository $tokenRepository,
        PeoplePositionRepository $peoplePositionRepository,
        AuditoriumResponsibilityRepository $auditoriumResponsibilityRepository,
        TransferActRepository $transferActRepository,
        TransferActThingRepository $transferActThingRepository,
        TransferActConfirmRepository $transferActConfirmRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->peopleRepository = $peopleRepository;
        $this->notificationRepository = $notificationRepository;
        $this->tokenRepository = $tokenRepository;
        $this->peoplePositionRepository = $peoplePositionRepository;
        $this->auditoriumResponsibilityRepository = $auditoriumResponsibilityRepository;
        $this->transferActRepository = $transferActRepository;
        $this->transferActThingRepository = $transferActThingRepository;
        $this->transferActConfirmRepository = $transferActConfirmRepository;
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
                'about' => $user->people->about,
                'avatar' => $user->people->icon_link,
            ],
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
                    about: $user->people->about,
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
            about: $user->people->about,
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
        catch (\Exception $e){
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function updateUser($id, $data){
        DB::beginTransaction();
        try {
            $this->userRepository->updateUser($id, $data);
            $user = $this->userRepository->get($id);
            $this->peopleRepository->updateByUserId($user->id, $data);
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function delete($id){
        DB::beginTransaction();
        try {
            $user = $this->userRepository->get($id);
            foreach ($user->notifications as $notification){
                $this->notificationRepository->delete($notification->id);
            }
            foreach ($user->tokens as $token) {
                $this->tokenRepository->deleteByUserId($token->id);
            }
            foreach ($user->people->auditoriumResponsibilities as $auditoriumResponsibility) {
                $this->auditoriumResponsibilityRepository->delete($auditoriumResponsibility->id);
            }
            foreach($user->people->peoplePositions as $peoplePosition){
                foreach($peoplePosition->fromTransferActs as $fromTransferAct){
                    foreach($fromTransferAct->transferActThings as $transferActThing){
                        $this->transferActThingRepository->delete($transferActThing->id);
                    }
                    foreach($fromTransferAct->transferActConfirms as $transferActConfirm){
                        $this->transferActConfirmRepository->delete($transferActConfirm->id);
                    }
                    $this->transferActRepository->delete($fromTransferAct->id);
                }
                foreach($peoplePosition->toTransferActs as $toTransferAct){
                    foreach($toTransferAct->transferActThings as $transferActThing){
                        $this->transferActThingRepository->delete($transferActThing->id);
                    }
                    foreach($toTransferAct->transferActConfirms as $transferActConfirm){
                        $this->transferActConfirmRepository->delete($transferActConfirm->id);
                    }
                    $this->transferActRepository->delete($toTransferAct->id);
                }
                $this->peoplePositionRepository->delete($peoplePosition->id);
            }
            $this->peopleRepository->delete($user->people->id);
            $this->userRepository->delete($id);
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            LogHelper::error($e->getMessage(), $e->getTraceAsString());
        }
    }
}
