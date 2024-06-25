<?php

namespace App\Application\Model\Response\Kit;

use App\Entity\Kit;
use DateTime;


class CreateKitResponseModel
{

    public string $id;
    public string $name;
    public mixed $author;



    public function __construct()
    {
    }

    public static function create(Kit $set): self
    {

        $response = new self($set);
        $response->name = $set->getName();
        $response->id = $set->getId();
        //$response->author = ["name" => $set->getUser()->getName(), "sername" => $set->getUser()->getSername()];
        $response->author = "fff";

        return $response;
    }
}
