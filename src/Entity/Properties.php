<?php

namespace App\Entity;

use App\Repository\PropertiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PropertiesRepository::class)
 */
class Properties
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"property_list"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"property_list"})
     */
    private $roomNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"property_list"})
     */
    private $rent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"property_list"})
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"property_list"})
     */
    private $garden;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"property_list"})
     */
    private $housingType;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"property_list"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=10000)
     * @Groups({"property_list"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"property_list"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Rental::class, mappedBy="property", cascade={"persist", "remove"})
     */
    private $rental;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"property_list"})
     */
    private $harea;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="properties", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"property_list"})
     */
    private $address;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"property_list"})
     */
    private $yearBuilt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"property_list"})
     */
    private $heating;

    /** 
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="properties", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"property_list"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"property_list"})
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=HomeInterest::class, mappedBy="properties")
     */
    private $rentalInterests;

    /**
     * @ORM\OneToMany(targetEntity=RentalApplication::class, mappedBy="property")
     */
    private $rentalApplications;

    /**
     * @ORM\OneToMany(targetEntity=Favori::class, mappedBy="property", orphanRemoval=true)
     */
    private $favoris;

    public function __construct()
    {
        $this->address = new Address();
        $this->images = new ArrayCollection();
        $this->rentalInterests = new ArrayCollection();
        $this->rentalApplications = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomNumber(): ?int
    {
        return $this->roomNumber;
    }

    public function setRoomNumber(int $roomNumber): self
    {
        $this->roomNumber = $roomNumber;

        return $this;
    }


    public function getRent(): ?int
    {
        return $this->rent;
    }

    public function setRent(?int $rent): self
    {
        $this->rent = $rent;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function isGarden(): ?bool
    {
        return $this->garden;
    }

    public function setGarden(bool $garden): self
    {
        $this->garden = $garden;

        return $this;
    }

    public function isHousingType(): ?bool
    {
        return $this->housingType;
    }

    public function setHousingType(bool $housingType): self
    {
        $this->housingType = $housingType;

        return $this;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRental(): ?Rental
    {
        return $this->rental;
    }

    public function setRental(Rental $rental): self
    {
        // set the owning side of the relation if necessary
        if ($rental->getProperty() !== $this) {
            $rental->setProperty($this);
        }

        $this->rental = $rental;

        return $this;
    }

    public function getHarea(): ?int
    {
        return $this->harea;
    }

    public function setHarea(int $harea): self
    {
        $this->harea = $harea;

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

    public function getYearBuilt(): ?\DateTimeInterface
    {
        return $this->yearBuilt;
    }

    public function setYearBuilt(\DateTimeInterface $yearBuilt): self
    {
        $this->yearBuilt = $yearBuilt;

        return $this;
    }

    public function getHeating(): ?string
    {
        return $this->heating;
    }

    public function setHeating(string $heating): self
    {
        $this->heating = $heating;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProperties($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProperties() === $this) {
                $image->setProperties(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $rentalInterest->addProperty($this);
        }

        return $this;
    }

    public function removeHomeInterest(HomeInterest $rentalInterest): self
    {
        if ($this->rentalInterests->removeElement($rentalInterest)) {
            $rentalInterest->removeProperty($this);
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
            $favori->setProperty($this);
        }

        return $this;
    }

    public function removeFavori(Favori $favori): self
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getProperty() === $this) {
                $favori->setProperty(null);
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
            $rentalApplication->setProperty($this);
        }

        return $this;
    }

    public function removeRentalApplication(RentalApplication $rentalApplication): self
    {
        if ($this->rentalApplications->removeElement($rentalApplication)) {
            // set the owning side to null (unless already changed)
            if ($rentalApplication->getProperty() === $this) {
                $rentalApplication->setProperty(null);
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
            $rentalInterest->addProperty($this);
        }

        return $this;
    }

    public function removeRentalInterest(HomeInterest $rentalInterest): static
    {
        if ($this->rentalInterests->removeElement($rentalInterest)) {
            $rentalInterest->removeProperty($this);
        }

        return $this;
    }
}
