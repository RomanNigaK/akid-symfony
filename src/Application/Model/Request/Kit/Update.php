<?php

namespace App\Application\Model\Request\Kit;

use App\Entity\Kit;
use Symfony\Component\HttpFoundation\Request;

class UpdateKitRequestModel
{
    private string $name;

    public function __construct()
    {
    }

    public static function create(Request $request, Kit $kit): Kit
    {

        $data = $request->toArray();

        $kit->setName($data["name"] ?? $kit->getName());

        return $kit;
    }

    public function getName()
    {
        return $this->name;
    }
}
