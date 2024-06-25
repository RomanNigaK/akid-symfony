<?php

namespace App\Application\Model\Request\Material;

use Symfony\Component\HttpFoundation\Request;

class CreateMaterialRequestModel
{
    private string $name;
    private float $amount;
    private string $unit;
    private bool $equipment;

    public function __construct()
    {
    }

    public static function create(Request $request): self
    {

        $data = $request->toArray();
        $material = new self($request);
        $material->name = $data["name"];
        $material->amount = $data["amount"];
        $material->unit = $data["unit"];
        $material->equipment = $data["equipment"] ?? 0;

        return $material;
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
    public function getEquipment()
    {
        return $this->equipment;
    }
}
