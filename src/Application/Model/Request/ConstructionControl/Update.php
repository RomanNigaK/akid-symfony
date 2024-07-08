<?php

namespace App\Application\Model\Request\ConstructionControl;

use App\Entity\ConstructionControl;
use Symfony\Component\HttpFoundation\Request;

class UpdateConstructioncontroleRequestModel
{
    private string $fio;
    private string $postCompany;
    private ?string $dataOrder;
    private ?string $nrc;

    public function __construct()
    {
    }

    public static function create(Request $request, ConstructionControl $constructioncontrol): ConstructionControl
    {

        $data = $request->toArray();
        $constructioncontrol->setFio($data["fio"] ?? $constructioncontrol->getFio());
        $constructioncontrol->setPostCompany($data["postCompany"] ?? $constructioncontrol->getPostCompany());
        $constructioncontrol->setDataOrder($data["dataOrder"] ?? $constructioncontrol->getDataOrder());
        $constructioncontrol->setNrc($data["nrc"] ?? $constructioncontrol->getNrc());

        return $constructioncontrol;
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
