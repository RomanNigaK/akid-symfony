<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid as RamseyUuid;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private string $id;

    #[ORM\Column(length: 50)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $originalName;

    #[ORM\OneToMany(mappedBy: 'file', targetEntity: MaterialFiles::class)]
    private Collection $materialFiles;

    public function __construct(string $name, string $originalName)
    {
        $this->id = RamseyUuid::uuid4()->toString();
        $this->name = $name;
        $this->originalName = $originalName;
        $this->materialFiles = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): static
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * @return Collection<int, MaterialFiles>
     */
    public function getMaterialFiles(): Collection
    {
        return $this->materialFiles;
    }

    public function addMaterialFile(MaterialFiles $materialFile): static
    {
        if (!$this->materialFiles->contains($materialFile)) {
            $this->materialFiles->add($materialFile);
            $materialFile->setFile($this);
        }

        return $this;
    }

    public function removeMaterialFile(MaterialFiles $materialFile): static
    {
        if ($this->materialFiles->removeElement($materialFile)) {
            // set the owning side to null (unless already changed)
            if ($materialFile->getFile() === $this) {
                $materialFile->setFile(null);
            }
        }

        return $this;
    }
}
