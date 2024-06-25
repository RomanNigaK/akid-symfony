<?php

namespace App\Application\Model\Request\Material;

use App\Entity\Material;
use Symfony\Component\HttpFoundation\Request;

class UpdateMaterialRequestModel
{
    private string $name;
    private string $amount;
    private string $unit;
    private bool $equipment;

    public function __construct()
    {
    }

    public static function create(Request $request, Material $material): Material
    {

        $data = $request->toArray();
        $material->setName($data["name"] ?? $material->getName());
        $material->setAmount($data["amount"] ?? $material->getAmount());
        $material->setUnit($data["unit"] ?? $material->getUnit());
        $material->setEquipment($data["equipment"] ?? $material->getEquipment());

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
