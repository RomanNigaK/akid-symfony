<?php

namespace App\Entity;

use App\Application\Model\Request\Work\CreateWorkRequestModel;
use App\Repository\WorkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid as RamseyUuid;

#[ORM\Entity(repositoryClass: WorkRepository::class)]
class Work
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

    #[ORM\ManyToOne(inversedBy: 'works')]
    private ?Kit $kit = null;

    #[ORM\OneToMany(mappedBy: 'work', targetEntity: WorkMaterials::class)]
    private Collection $workMaterials;

    public function __construct(CreateWorkRequestModel $data)
    {
        $this->id = RamseyUuid::uuid4()->toString();
        $this->name = $data->getName();
        $this->amount = $data->getAmount();
        $this->unit = $data->getUnit();
        $this->workMaterials = new ArrayCollection();
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

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

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
            $workMaterial->setWork($this);
        }

        return $this;
    }

    public function removeWorkMaterial(WorkMaterials $workMaterial): static
    {
        if ($this->workMaterials->removeElement($workMaterial)) {
            // set the owning side to null (unless already changed)
            if ($workMaterial->getWork() === $this) {
                $workMaterial->setWork(null);
            }
        }

        return $this;
    }
}
