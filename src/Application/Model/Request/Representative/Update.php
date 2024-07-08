<?php

namespace App\Application\Model\Request\Representative;

use App\Entity\Representative;
use Symfony\Component\HttpFoundation\Request;

class UpdateRepresentativeRequestModel
{
    private string $fio;
    private string $postCompany;
    private ?string $dataOrder;
    private ?string $nrc;

    public function __construct()
    {
    }

    public static function create(Request $request, Representative $representative): Representative
    {

        $data = $request->toArray();
        $representative->setFio($data["fio"] ?? $representative->getFio());
        $representative->setPostCompany($data["postCompany"] ?? $representative->getPostCompany());
        $representative->setDataOrder($data["dataOrder"] ?? $representative->getDataOrder());
        $representative->setNrc($data["nrc"] ?? $representative->getNrc());

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
    public function getDataOrder()
    {
        return $this->dataOrder;
    }
    public function getNrc()
    {
        return $this->nrc;
    }
}
