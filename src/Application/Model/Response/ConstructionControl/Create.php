<?php

namespace App\Application\Model\Response\ConstructionControl;

use App\Entity\ConstructionControl;

class CreateConstructionControlResponseModel
{
    public string $id;
    public string $fio;
    public string $postCompany;
    public ?string $nrc;
    public ?string $dataOrder;

    public function __construct()
    {
    }

    public static function create(ConstructionControl $constructioncontrol): self
    {

        $response = new self($constructioncontrol);
        $response->id = $constructioncontrol->getId();
        $response->fio = $constructioncontrol->getFio();
        $response->postCompany = $constructioncontrol->getPostCompany();
        if ($constructioncontrol->getNrc())
            $response->nrc = $constructioncontrol->getNrc();
        if ($constructioncontrol->getDataOrder())
            $response->dataOrder = $constructioncontrol->getDataOrder();


        return $response;
    }
}
