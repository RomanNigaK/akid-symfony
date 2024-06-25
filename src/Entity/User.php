<?php

namespace App\Entity;

use App\Application\Model\Request\User\UserRequestModel;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Ramsey\Uuid\Uuid as RamseyUuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private string $id;

    #[ORM\Column(length: 180, unique: true)]
    private string $email;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private string $password;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255, nullable: true)]
    private string $sername;

    #[ORM\Column(nullable: true)]
    private int $phone;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Kit::class)]
    private Collection $kits;

    public function __construct(UserRequestModel $data)
    {
        $this->id = RamseyUuid::uuid4()->toString();
        $this->name = $data->getName();
        $this->sername = $data->getSername();
        $this->email = $data->getEmail();
        $this->phone = $data->getPhone();
        $this->password = $data->getPassword();
        $this->kits = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getSername(): string
    {
        return $this->sername;
    }

    public function setSername(string $sername): static
    {
        $this->sername = $sername;

        return $this;
    }

    public function getPhone(): int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Kit>
     */
    public function getKits(): Collection
    {
        return $this->kits;
    }

    public function addKit(Kit $kit): static
    {
        if (!$this->kits->contains($kit)) {
            $this->kits->add($kit);
            $kit->setUser($this);
        }

        return $this;
    }

    public function removeKit(Kit $kit): static
    {
        if ($this->kits->removeElement($kit)) {
            // set the owning side to null (unless already changed)
            if ($kit->getUser() === $this) {
                $kit->setUser(null);
            }
        }

        return $this;
    }
}
