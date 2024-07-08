<?php

namespace App\Application\Model\Request\Representative;

use Symfony\Component\HttpFoundation\Request;

class CreateRepresentativeRequestModel
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
        $representative = new self($request);
        $representative->fio = $data["fio"];
        $representative->postCompany = $data["postCompany"];
        $representative->nrc = $data["nrc"] ?? null;
        $representative->dataOrder = $data["dataOrder"] ?? null;

        return $representative;
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
