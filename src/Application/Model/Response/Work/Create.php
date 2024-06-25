<?php

namespace App\Application\Model\Response\Work;

use App\Entity\Work;

class CreateWorkResponseModel
{

    public string $id;
    public string $name;
    public string $amount;
    public string $unit;
    public string $count;

    public function __construct()
    {
    }

    public static function create(Work $work, ?int $count = null): self
    {

        $response = new self($work);
        $response->name = $work->getName();
        $response->id = $work->getId();
        $response->unit = $work->getUnit();
        $response->amount = $work->getAmount();
        if ($count)
            $response->count = $count;

        return $response;
    }
}
