<?php

namespace App\Entity;

use App\Repository\WorkMaterialsRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid as RamseyUuid;

#[ORM\Entity(repositoryClass: WorkMaterialsRepository::class)]
class WorkMaterials
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private string $id;

    #[ORM\ManyToOne(inversedBy: 'workMaterials')]
    private ?Work $work = null;

    #[ORM\ManyToOne(inversedBy: 'workMaterials')]
    private ?Material $material = null;

    public function __construct(Work $work, Material $material)
    {
        $this->id = RamseyUuid::uuid4()->toString();
        $this->work = $work;
        $this->material = $material;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getWork(): ?Work
    {
        return $this->work;
    }

    public function setWork(?Work $work): static
    {
        $this->work = $work;

        return $this;
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
}
