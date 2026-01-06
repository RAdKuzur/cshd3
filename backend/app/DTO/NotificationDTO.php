<?php

namespace App\DTO;

use App\Models\Notification;

class NotificationDTO implements DTO
{
    public ?int $id;
    public ?int $user_id;
    public ?int $type;
    public ?string $message;
    public ?int $is_read;
    public function __construct(
        ?int $id = null,
        ?int $user_id = null,
        ?int $type = null,
        ?string $message = null,
        ?int $is_read = null
    ){
        $this->id = $id;
        $this->user_id = $user_id;
        $this->type = $type;
        $this->message = $message;
        $this->is_read = $is_read;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['id'] ?? null,
            $array['user_id'] ?? null,
            $array['type'] ?? null,
            $array['message'] ?? null,
            $array['is_read'] ?? null
        );
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'message' => $this->message,
            'is_read' => $this->is_read,
        ];
    }
}
