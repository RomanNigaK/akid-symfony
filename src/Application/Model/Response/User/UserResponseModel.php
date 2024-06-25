<?php

namespace App\Application\Model\Response\User;

use App\Entity\User;
use DateTime;

class UserResponseModel
{

    public string $id;
    public DateTime $dateCreated;
    public string $name;
    public string $email;


    public function __construct()
    {
    }

    public static function create(User $user): self
    {

        $response = new self($user);
        $response->name = $user->getName();
        $response->email = $user->getEmail();
        $response->id = $user->getId();

        return $response;
    }
}
