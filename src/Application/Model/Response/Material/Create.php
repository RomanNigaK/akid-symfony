<?php

namespace App\Application\Model\Response\Material;

use App\Entity\Material;

class CreateMaterialResponseModel
{

    public string $id;
    public string $name;
    public string $amount;
    public string $unit;
    public ?array $files;

    public function __construct()
    {
    }

    public static function create(Material $material, ?array $files = null): self
    {

        $response = new self($material);
        $response->name = $material->getName();
        $response->id = $material->getId();
        $response->unit = $material->getUnit();
        $response->amount = $material->getAmount();
        if ($files)
            $response->files = $files;

        return $response;
    }
}
