<?php

namespace App\DTO;
class TokenDTO implements DTO
{
    public ?int $id;
    public ?string $refresh_token;
    public ?int $user_id;
    public $expires_at;
    public ?string $device_id;
    public ?bool $is_revoked;
    public ?string $user_agent;
    public ?string $ip_address;
    public ?string $username;
    public function __construct(
        ?int $id = null,
        ?string $refresh_token = null,
        ?int $user_id = null,
        $expires_at = null,
        ?string $device_id = null,
        ?bool $is_revoked = null,
        ?string $user_agent = null,
        ?string $ip_address = null,
        ?string $username = null
    )
    {
        $this->id = $id;
        $this->refresh_token = $refresh_token;
        $this->user_id = $user_id;
        $this->expires_at = $expires_at;
        $this->device_id = $device_id;
        $this->is_revoked = $is_revoked;
        $this->user_agent = $user_agent;
        $this->ip_address = $ip_address;
        $this->username = $username;
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['refresh_token'],
            $array['user_id'],
            $array['expires_at'],
            $array['device_id'],
            $array['is_revoked'],
            $array['user_agent'],
            $array['ip_address'],
            $array['username']
        );
    }

    public function toArray() : array {
        return [
            'refresh_token' => $this->refresh_token,
            'user_id' => $this->user_id,
            'expires_at' => $this->expires_at,
            'device_id' => $this->device_id,
            'is_revoked' => $this->is_revoked,
            'user_agent' => $this->user_agent,
            'ip_address' => $this->ip_address,
            'username' => $this->username
        ];
    }
}
