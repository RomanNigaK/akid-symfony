<?php

namespace App\Application\Model\Request\Representative;

use App\Entity\Representative;

class CreateRepresentativeResponseModel
{
    public string $fio;
    public string $postCompany;
    public ?string $nrc;
    public ?string $dataOrder;
    public string $id;

    public function __construct()
    {
    }

    public static function create(Representative $representative): self
    {

        $response = new self($representative);
        $response->fio = $representative->getFio();
        $response->postCompany = $representative->getPostCompany();
        if ($representative->getNrc())
            $response->nrc = $representative->getNrc();
        if ($representative->getDataOrder())
            $response->dataOrder = $representative->getDataOrder();
        $response->id = $representative->getId();


        return $response;
    }
}
