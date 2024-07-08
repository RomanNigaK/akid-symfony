<?php

namespace App\Entity;

use App\Repository\TemplateRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid as RamseyUuid;


#[ORM\Entity(repositoryClass: TemplateRepository::class)]
class Template
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 50)]
    private string $abbreviation;

    #[ORM\Column(length: 50)]
    private string $tag;

    #[ORM\Column(length: 50)]
    private string $type;

    #[ORM\Column(length: 50)]
    private string $note;

    #[ORM\Column]
    private DateTime $createAt;

    #[ORM\Column]
    private DateTime $updateAt;


    public function __construct(string $name, string $abbreviation, string $tag, string $note, string $type)
    {
        $this->id = RamseyUuid::uuid4()->toString();
        $this->name = $name;
        $this->abbreviation = $abbreviation;
        $this->tag = $tag;
        $this->note = $note;
        $this->type = $type;
        $this->createAt = new DateTime();
        $this->updateAt = new DateTime();
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

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): static
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function setTag(string $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
    public function getNote(): string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->type = $note;

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
