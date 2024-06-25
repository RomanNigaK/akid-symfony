<?php

namespace App\Application\Model\Request\Work;

use Symfony\Component\HttpFoundation\Request;

class CreateWorkRequestModel
{
    private string $name;
    private float $amount;
    private string $unit;

    public function __construct()
    {
    }

    public static function create(Request $request): self
    {

        $data = $request->toArray();
        $work = new self($request);
        $work->name = $data["name"];
        $work->amount = $data["amount"];
        $work->unit = $data["unit"];


        return $work;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function getUnit()
    {
        return $this->unit;
    }
}
