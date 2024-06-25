<?php

namespace App\Application\Model\Request\User;

use Symfony\Component\HttpFoundation\Request;

class UserRequestModel
{
    private string $name;
    private string $sername;
    private int $phone;
    private string $email;
    private string $password;

    public function __construct()
    {
    }

    public static function create(Request $request): self
    {

        $data = $request->toArray();
        $user = new self($request);
        $user->name = $data["name"];
        $user->sername = $data["sername"];
        $user->email = $data["email"];
        $user->phone = 0;
        $user->password = $data["password"];

        return $user;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getSername()
    {
        return $this->sername;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getPhone(): int
    {
        return $this->phone;
    }
}
