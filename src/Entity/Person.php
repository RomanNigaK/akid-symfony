<?php

namespace App\Entity;

use App\Application\Model\Request\Person\CreatePersonRequestModel;
use App\Enum\EnumTypePerson;
use App\Repository\PersonRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid as RamseyUuid;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private string $id;

    #[ORM\ManyToOne(inversedBy: 'developers')]
    private ?Kit $kit = null;

    #[ORM\Column(length: 12)]
    private ?int $inn = null;

    #[ORM\Column(length: 255)]
    private string $data;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 1, enumType: EnumTypePerson::class)]
    private EnumTypePerson $type;

    #[ORM\Column]
    private DateTime $createAt;

    #[ORM\Column]
    private DateTime $updateAt;

    #[ORM\OneToOne(targetEntity: Representative::class, cascade: ['persist', 'remove'])]
    private ?Representative $representative = null;

    #[ORM\OneToOne(targetEntity: ConstructionControl::class, cascade: ['persist', 'remove'])]
    private ?ConstructionControl $constructionControl = null;

    public function __construct(CreatePersonRequestModel $person)
    {
        $this->id = RamseyUuid::uuid4()->toString();
        $this->name = $person->getName();
        $this->data = $person->getData();
        $this->inn = $person->getInn();
        $this->createAt = new DateTime();
        $this->updateAt = new DateTime();
    }

    public function getId(): string
    {
        return $this->id;
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

    public function getInn(): int
    {
        return $this->inn;
    }

    public function setInn(?int $inn): static
    {
        $this->inn = $inn;

        return $this;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): static
    {
        $this->data = $data;

        return $this;
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

    public function setType(EnumTypePerson $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): EnumTypePerson
    {
        return $this->type;
    }
    public function getCreateAt(): DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(DateTime $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): DateTime
    {
        return $this->updateAt;
    }

    public function setUpdateAt(DateTime $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getRepresentative(): ?Representative
    {
        return $this->representative;
    }

    public function setRepresentative(?Representative $representative): static
    {
        $this->representative = $representative;

        return $this;
    }
    public function getConstructionControl(): ?ConstructionControl
    {
        return $this->constructionControl;
    }

    public function setConstructionControl(?ConstructionControl $constructionControl): static
    {
        $this->constructionControl = $constructionControl;

        return $this;
    }
}
