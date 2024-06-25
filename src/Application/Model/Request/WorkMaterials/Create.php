<?php

namespace App\Application\Model\Request\WorkMaterials;

use Symfony\Component\HttpFoundation\Request;

class CreateWorkMaterialsRequestModel
{
    private array $ids;

    public function __construct()
    {
    }

    public static function create(Request $request): self
    {

        $data = $request->toArray();
        $workMaterialsItems = new self($request);
        $workMaterialsItems->ids = $data["items"];


        return $workMaterialsItems;
    }

    public function getIds()
    {
        return $this->ids;
    }
}
