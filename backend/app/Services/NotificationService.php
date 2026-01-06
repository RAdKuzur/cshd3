<?php

namespace App\Services;

use App\Dictionaries\NotificationTypeDictionary;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Mockery\Matcher\Not;

class NotificationService
{
    private NotificationRepository $notificationRepository;
    public function __construct(
        NotificationRepository $notificationRepository
    )
    {
        $this->notificationRepository = $notificationRepository;
    }
    public function createNotification($userId, $type){
        $this->notificationRepository->create([
            'user_id' => $userId,
            'type' => $type,
            'message' => NotificationTypeDictionary::get($type),
            'is_read' => Notification::UNREAD
        ]);
    }
}
