<?php

namespace App\Application\Model\Request\Work;

use App\Entity\Work;
use Symfony\Component\HttpFoundation\Request;

class UpdateWorkMaterialsRequestModel
{
    private string $name;
    private string $amount;
    private string $unit;

    public function __construct()
    {
    }

    public static function create(Request $request, Work $work): Work
    {

        $data = $request->toArray();
        $work->setName($data["name"] ?? $work->getName());
        $work->setAmount($data["amount"] ?? $work->getAmount());
        $work->setUnit($data["unit"] ?? $work->getUnit());

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
