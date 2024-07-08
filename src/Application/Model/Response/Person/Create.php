<?php

namespace App\Application\Model\Response\Person;

use App\Application\Model\Request\Representative\CreateRepresentativeResponseModel;
use App\Application\Model\Response\ConstructionControl\CreateConstructionControlResponseModel as ConstructionControlCreateConstructionControlResponseModel;
use App\Entity\Person;

class CreatePersonResponseModel
{
    public string $id;
    public string $name;
    public string $data;
    public string $inn;
    public mixed $representative;
    public mixed $constructionControl;

    public function __construct()
    {
    }

    public static function create(Person $person): self
    {

        $response = new self($person);
        $response->name = $person->getName();
        $response->id = $person->getId();
        $response->data = $person->getData();
        $response->inn = $person->getInn();
        $representative = $person->getRepresentative();
        $constructionControl = $person->getConstructionControl();

        if ($representative !== null) {
            $response->representative = CreateRepresentativeResponseModel::create($representative);
        }
        if ($constructionControl !== null)
            $response->constructionControl = ConstructionControlCreateConstructionControlResponseModel::create($constructionControl);

        return $response;
    }
}
