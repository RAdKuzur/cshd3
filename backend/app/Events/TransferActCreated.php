<?php

namespace App\Events;

use App\Dictionaries\NotificationTypeDictionary;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransferActCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public User $user;
    public int $id;
    public function __construct(
        User $user,
        int $id
    )
    {
        $this->user = $user;
        $this->id = $id;
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
            'message' => NotificationTypeDictionary::get(NotificationTypeDictionary::TRANSFER_ACT_CREATE),
        ];
    }
    public function broadcastAs(): string
    {
        return 'Notification';
    }
}
