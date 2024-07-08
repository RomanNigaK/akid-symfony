<?php

namespace App\Application\Model\Request\Person;

use Symfony\Component\HttpFoundation\Request;

class CreatePersonRequestModel
{
    private string $name;
    private int $inn;
    private string $data;

    public function __construct()
    {
    }

    public static function create(Request $request): self
    {

        $data = $request->toArray();
        $developer = new self($request);
        $developer->name = $data["name"];
        $developer->data = $data["data"];


        if (in_array("inn", $data)) {
            $developer->inn = $data["inn"];
        } else {
            $developer->inn = 0;
        }


        return $developer;
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
