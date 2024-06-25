<?php

declare(strict_types=1);

namespace App\Application\Model\Request\File;

use Symfony\Component\HttpFoundation\File\File;


class UploadDocumentModel
{
    private File $document;
    private string $category;

    private string $buildingObjectId;

    public function __construct(string $category)
    {
        $this->category = $category;
    }

    public function getDocument(): File
    {
        return $this->document;
    }

    public function setDocument(File $document): void
    {
        $this->document = $document;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getBuildingObjectId(): string
    {
        return $this->buildingObjectId;
    }

    public function setBuildingObjectId(string $buildingObjectId): void
    {
        $this->buildingObjectId = $buildingObjectId;
    }
}
