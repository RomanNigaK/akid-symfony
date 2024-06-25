<?php

namespace App\Application\Model\Request\Kit;

use Symfony\Component\HttpFoundation\Request;

class CreateKitRequestModel
{
    private string $name;

    public function __construct()
    {
    }

    public static function create(Request $request): self
    {

        $data = $request->toArray();
        $set = new self($request);
        $set->name = $data["name"];

        return $set;
    }

    public function getName()
    {
        return $this->name;
    }
}
