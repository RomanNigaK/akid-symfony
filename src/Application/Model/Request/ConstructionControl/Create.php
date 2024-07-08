<?php

namespace App\Application\Model\Request\ConstructionControl;

use Symfony\Component\HttpFoundation\Request;

class CreateConstructionControlRequestModel
{
    private string $fio;
    private string $postCompany;
    private ?string $nrc;
    private ?string $dataOrder;


    public function __construct()
    {
    }


    public static function create(Request $request): self
    {
        $data = $request->toArray();
        $constructionControl = new self($request);
        $constructionControl->fio = $data["fio"];
        $constructionControl->postCompany = $data["postCompany"];
        $constructionControl->nrc = $data["nrc"] ?? null;
        $constructionControl->dataOrder = $data["dataOrder"] ?? null;

        return $constructionControl;
    }

    public function getFio()
    {
        return $this->fio;
    }

    public function getPostCompany()
    {
        return $this->postCompany;
    }

    public function getNrc()
    {
        return $this->nrc;
    }

    public function getDataOrder()
    {
        return $this->dataOrder;
    }
}
