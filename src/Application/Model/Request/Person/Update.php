<?php

namespace App\Application\Model\Request\Person;

use App\Entity\Person;
use Symfony\Component\HttpFoundation\Request;

class UpdatePersonRequestModel
{
    private string $name;
    private int $inn;
    private string $data;

    public function __construct()
    {
    }

    public static function create(Request $request, Person $person): Person
    {

        $data = $request->toArray();
        $person->setName($data["name"] ?? $person->getName());
        $person->setInn($data["inn"] ?? $person->getInn());
        $person->setData($data["data"] ?? $person->getData());

        return $person;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getInn()
    {
        return $this->inn;
    }
}
