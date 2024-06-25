<?php

namespace App\Application\Model\Response\Work;

use App\Entity\File;

class GetFileResponseModel
{

    public string $id;
    public string $name;
    public string $originalName;


    public function __construct()
    {
    }

    public static function create(File $file): self
    {

        $response = new self($file);
        $response->name = $file->getName();
        $response->originalName = $file->getOriginalName();
        $response->id = $file->getId();

        return $response;
    }
}
