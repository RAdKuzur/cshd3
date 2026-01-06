<?php

namespace App\Events;

use App\Dictionaries\NotificationTypeDictionary;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransferActConfirmChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public User $user;
    public function __construct(
        User $user
    )
    {
        $this->user = $user;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('Notification.' . $this->user->username);
    }

    public function broadcastWith(): array
    {
        return [
            'message' => NotificationTypeDictionary::get(NotificationTypeDictionary::TRANSFER_ACT_CONFIRM),
        ];
    }
}
