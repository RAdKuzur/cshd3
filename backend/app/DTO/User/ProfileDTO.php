<?php

namespace App\DTO\User;

use App\DTO\DTO;

class ProfileDTO implements DTO
{
    public array $user;
    public array $contacts;
    public array $workExperience;
    public array $education;

    public function __construct(
        array $user,
        array $contacts,
        array $workExperience,
        array $education
    ){
        $this->user = $user;
        $this->contacts = $contacts;
        $this->workExperience = $workExperience;
        $this->education = $education;
    }
    public static function fromArray(array $array)
    {
        // TODO: Implement fromArray() method.
        return new self(
            $array['user'],
            $array['contacts'],
            $array['workExperience'],
            $array['education']
        );
    }
    public function toArray() : array {
        return [
            'user' => $this->user,
            'contacts' => $this->contacts,
            'workExperience' => $this->workExperience,
            'education' => $this->education
        ];
    }
}
