<?php

namespace App\Services;

use App\Dictionaries\NotificationTypeDictionary;
use App\DTO\NotificationDTO;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Not;

class NotificationService
{
    private NotificationRepository $notificationRepository;
    private UserRepository $userRepository;
    public function __construct(
        NotificationRepository $notificationRepository,
        UserRepository $userRepository
    )
    {
        $this->notificationRepository = $notificationRepository;
        $this->userRepository = $userRepository;
    }
    public function createNotification($userId, $type){
        $this->notificationRepository->create([
            'user_id' => $userId,
            'type' => $type,
            'message' => NotificationTypeDictionary::get($type),
            'is_read' => Notification::UNREAD
        ]);
    }
    public function getUserNotifications($username){
        $data = [];
        $user = $this->userRepository->getByUsername($username);
        $notifications = $this->notificationRepository->getByUserId($user->id);
        foreach($notifications as $notification){
            $data[] = new NotificationDTO(
                id: $notification->id,
                user_id: $notification->user_id,
                type: $notification->type,
                message: $notification->message,
                is_read: $notification->is_read
            );
        }
        return $data;
    }
    public function readAllUserNotifications($username){
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getByUsername($username);
            $notifications = $this->notificationRepository->getByUserId($user->id);
            foreach($notifications as $notification){
                $this->notificationRepository->read($notification->id);
            }
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
        }
    }
    public function readNotification($notificationId){
        DB::beginTransaction();
        try {
            $notification = $this->notificationRepository->get($notificationId);
            $this->notificationRepository->read($notification->id);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->notificationRepository->delete($id);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
        }

    }

    public function deleteAllUserNotifications($username)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getByUsername($username);
            $notifications = $this->notificationRepository->getByUserId($user->id);
            foreach ($notifications as $notification) {
                $this->notificationRepository->delete($notification->id);
            }
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
        }
    }
}
