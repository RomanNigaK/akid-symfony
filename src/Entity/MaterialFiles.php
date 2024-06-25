<?php

namespace App\Entity;

use App\Repository\MaterialFilesRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid as RamseyUuid;

#[ORM\Entity(repositoryClass: MaterialFilesRepository::class)]
class MaterialFiles
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private string $id;

    #[ORM\ManyToOne(inversedBy: 'materialFiles')]
    private ?Material $material = null;

    #[ORM\ManyToOne(inversedBy: 'materialFiles')]
    private ?File $file = null;
    public function __construct(Material $material, File $file)
    {
        $this->id = RamseyUuid::uuid4()->toString();
        $this->material = $material;
        $this->file = $file;
    }
    public function getId(): string
    {
        return $this->id;
    }

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): static
    {
        $this->material = $material;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): static
    {
        $this->file = $file;

        return $this;
    }
}
