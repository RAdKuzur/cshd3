<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public NotificationService $notificationService;
    public function __construct(
        NotificationService $notificationService
    )
    {
        $this->notificationService = $notificationService;
    }

    public function getUserNotifications($username){
        $notifications = $this->notificationService->getUserNotifications($username);
        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }
    public function readAllUserNotifications($username)
    {
        $this->notificationService->readAllUserNotifications($username);
        return response()->json([
            'success' => true,
        ]);
    }
    public function readUserNotification($notificationId)
    {
        $this->notificationService->readNotification($notificationId);
        return response()->json([
            'success' => true,
        ]);
    }
}
