<?php

namespace App\Entity;

use App\Application\Model\Request\Kit\CreateKitRequestModel;
use App\Repository\KitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid as RamseyUuid;

#[ORM\Entity(repositoryClass: KitRepository::class)]
class Kit
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'kits')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'kit', targetEntity: Work::class)]
    private Collection $works;

    #[ORM\OneToMany(mappedBy: 'kit', targetEntity: Material::class)]
    private Collection $materials;

    #[ORM\OneToMany(mappedBy: 'kit', targetEntity: Person::class)]
    private Collection $persons;

    public function __construct(
        CreateKitRequestModel $data
    ) {
        $this->id = RamseyUuid::uuid4()->toString();
        $this->name = $data->getName();
        $this->works = new ArrayCollection();
        $this->materials = new ArrayCollection();
        $this->persons = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Work>
     */
    public function getWorks(): Collection
    {
        return $this->works;
    }

    public function addWork(Work $work): static
    {
        if (!$this->works->contains($work)) {
            $this->works->add($work);
            $work->setKit($this);
        }

        return $this;
    }

    public function removeWork(Work $work): static
    {
        if ($this->works->removeElement($work)) {
            // set the owning side to null (unless already changed)
            if ($work->getKit() === $this) {
                $work->setKit(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, Material>
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(Material $material): static
    {
        if (!$this->materials->contains($material)) {
            $this->materials->add($material);
            $material->setKit($this);
        }

        return $this;
    }

    public function removeMaterial(Material $material): static
    {
        if ($this->materials->removeElement($material)) {
            // set the owning side to null (unless already changed)
            if ($material->getKit() === $this) {
                $material->setKit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Developer>
     */
    public function getPersons(): Collection
    {
        return $this->persons;
    }

    public function addDeveloper(Person $person): static
    {
        if (!$this->persons->contains($person)) {
            $this->persons->add($person);
            $person->setKit($this);
        }

        return $this;
    }

    public function removeDeveloper(Person $person): static
    {
        if ($this->persons->removeElement($person)) {
            // set the owning side to null (unless already changed)
            if ($person->getKit() === $this) {
                $person->setKit(null);
            }
        }

        return $this;
    }
}
