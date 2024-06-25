<?php

namespace App\Entity;

use App\Application\Model\Request\Material\CreateMaterialRequestModel;
use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid as RamseyUuid;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
class Material
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private float $amount;

    #[ORM\Column(length: 20)]
    private string $unit;

    #[ORM\Column]
    private bool $equipment;

    #[ORM\ManyToOne(inversedBy: 'materials')]
    private ?Kit $kit = null;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: MaterialFiles::class)]
    private Collection $materialFiles;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: WorkMaterials::class)]
    private Collection $workMaterials;

    public function __construct(CreateMaterialRequestModel $data)
    {
        $this->id = RamseyUuid::uuid4()->toString();
        $this->name = $data->getName();
        $this->amount = $data->getAmount();
        $this->unit = $data->getUnit();
        $this->equipment = $data->getEquipment();
        $this->materialFiles = new ArrayCollection();
        $this->workMaterials = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }
    public function getEquipment(): bool
    {
        return $this->equipment;
    }

    public function setEquipment(bool $equipment): static
    {
        $this->equipment = $equipment;

        return $this;
    }
    public function getKit(): ?Kit
    {
        return $this->kit;
    }

    public function setKit(?Kit $kit): static
    {
        $this->kit = $kit;

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
            $materialFile->setMaterial($this);
        }

        return $this;
    }

    public function removeMaterialFile(MaterialFiles $materialFile): static
    {
        if ($this->materialFiles->removeElement($materialFile)) {
            // set the owning side to null (unless already changed)
            if ($materialFile->getMaterial() === $this) {
                $materialFile->setMaterial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WorkMaterials>
     */
    public function getWorkMaterials(): Collection
    {
        return $this->workMaterials;
    }

    public function addWorkMaterial(WorkMaterials $workMaterial): static
    {
        if (!$this->workMaterials->contains($workMaterial)) {
            $this->workMaterials->add($workMaterial);
            $workMaterial->setMaterial($this);
        }

        return $this;
    }

    public function removeWorkMaterial(WorkMaterials $workMaterial): static
    {
        if ($this->workMaterials->removeElement($workMaterial)) {
            // set the owning side to null (unless already changed)
            if ($workMaterial->getMaterial() === $this) {
                $workMaterial->setMaterial(null);
            }
        }

        return $this;
    }
}
