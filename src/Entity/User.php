<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity=Properties::class, mappedBy="user", orphanRemoval=true)
     */
    private $properties;

    /**
     * @ORM\OneToOne(targetEntity=Rental::class, mappedBy="tenant", cascade={"persist", "remove"})
     */
    private $rental;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=HomeInterest::class, mappedBy="user", orphanRemoval=true)
     */
    private $rentalInterests;

    /**
     * @ORM\OneToMany(targetEntity=RentalApplication::class, mappedBy="user")
     */
    private $rentalApplications;

    /**
     * @ORM\OneToMany(targetEntity=Favori::class, mappedBy="user", orphanRemoval=true)
     */
    private $favoris;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->address = new Address();
        $this->rentalInterests = new ArrayCollection();
        $this->rentalApplications = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Properties>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Properties $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setUser($this);
        }

        return $this;
    }

    public function removeProperty(Properties $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getUser() === $this) {
                $property->setUser(null);
            }
        }

        return $this;
    }


    public function getRental(): ?Rental
    {
        return $this->rental;
    }

    public function setRental(Rental $rental): self
    {
        // set the owning side of the relation if necessary
        if ($rental->getTenant() !== $this) {
            $rental->setTenant($this);
        }

        $this->rental = $rental;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, HomeInterest>
     */
    public function getHomeInterests(): Collection
    {
        return $this->rentalInterests;
    }

    public function addHomeInterest(HomeInterest $rentalInterest): self
    {
        if (!$this->rentalInterests->contains($rentalInterest)) {
            $this->rentalInterests[] = $rentalInterest;
            $rentalInterest->setUser($this);
        }

        return $this;
    }

    public function removeHomeInterest(HomeInterest $rentalInterest): self
    {
        if ($this->rentalInterests->removeElement($rentalInterest)) {
            // set the owning side to null (unless already changed)
            if ($rentalInterest->getUser() === $this) {
                $rentalInterest->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favori>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favori $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris[] = $favori;
            $favori->setUser($this);
        }

        return $this;
    }

    public function removeFavori(Favori $favori): self
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getUser() === $this) {
                $favori->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RentalApplication>
     */
    public function getRentalApplications(): Collection
    {
        return $this->rentalApplications;
    }

    public function addRentalApplication(RentalApplication $rentalApplication): self
    {
        if (!$this->rentalApplications->contains($rentalApplication)) {
            $this->rentalApplications[] = $rentalApplication;
            $rentalApplication->setUser($this);
        }

        return $this;
    }

    public function removeRentalApplication(RentalApplication $rentalApplication): self
    {
        if ($this->rentalApplications->removeElement($rentalApplication)) {
            // set the owning side to null (unless already changed)
            if ($rentalApplication->getUser() === $this) {
                $rentalApplication->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HomeInterest>
     */
    public function getRentalInterests(): Collection
    {
        return $this->rentalInterests;
    }

    public function addRentalInterest(HomeInterest $rentalInterest): static
    {
        if (!$this->rentalInterests->contains($rentalInterest)) {
            $this->rentalInterests->add($rentalInterest);
            $rentalInterest->setUser($this);
        }

        return $this;
    }

    public function removeRentalInterest(HomeInterest $rentalInterest): static
    {
        if ($this->rentalInterests->removeElement($rentalInterest)) {
            // set the owning side to null (unless already changed)
            if ($rentalInterest->getUser() === $this) {
                $rentalInterest->setUser(null);
            }
        }

        return $this;
    }
}
