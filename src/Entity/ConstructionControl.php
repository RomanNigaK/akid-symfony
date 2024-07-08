<?php

namespace App\Entity;

use App\Application\Model\Request\ConstructionControl\CreateConstructionControlRequestModel;
use App\Repository\ConstructionControlRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid as RamseyUuid;

#[ORM\Entity(repositoryClass: ConstructionControlRepository::class)]
class ConstructionControl
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $postCompany;

    #[ORM\Column(length: 100)]
    private string $fio;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $dataOrder = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nrc = null;

    #[ORM\OneToOne]
    private ?Person $person = null;

    #[ORM\Column]
    private DateTime $createAt;

    #[ORM\Column]
    private DateTime $updateAt;

    public function __construct(CreateConstructionControlRequestModel $constroctionControl)
    {
        $this->id = RamseyUuid::uuid4()->toString();
        $this->fio = $constroctionControl->getFio();
        $this->postCompany = $constroctionControl->getPostCompany();
        $this->dataOrder = $constroctionControl->getDataOrder();
        $this->nrc = $constroctionControl->getNrc();
        $this->createAt = new DateTime();
        $this->updateAt = new DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPostCompany(): string
    {
        return $this->postCompany;
    }

    public function setPostCompany(string $postCompany): static
    {
        $this->postCompany = $postCompany;

        return $this;
    }

    public function getFio(): string
    {
        return $this->fio;
    }

    public function setFio(string $fio): static
    {
        $this->fio = $fio;

        return $this;
    }

    public function getDataOrder(): ?string
    {
        return $this->dataOrder;
    }

    public function setDataOrder(?string $dataOrder): static
    {
        $this->dataOrder = $dataOrder;

        return $this;
    }

    public function getNrc(): ?string
    {
        return $this->nrc;
    }

    public function setNrc(?string $nrc): static
    {
        $this->nrc = $nrc;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): static
    {
        $this->person = $person;

        return $this;
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
}
