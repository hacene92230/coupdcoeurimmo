<?php

namespace App\Entity;

use App\Repository\PropertiesRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PropertiesRepository::class)
 * @Vich\Uploadable
 */
class Properties
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $roomNumber;

    /**
     * @ORM\Column(type="boolean")
     */
    private $transactionType;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $garden;

    /**
     * @ORM\Column(type="boolean")
     */
    private $housingType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
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
     */
    private $harea;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="properties", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @ORM\Column(type="datetime")
     */
    private $yearBuilt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heating;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageName;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="imageName") 
     */
    private $imageFile;

    public function __construct()
    {
        $this->address = new Address();
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

    public function isTransactionType(): ?bool
    {
        return $this->transactionType;
    }

    public function setTransactionType(bool $transactionType): self
    {
        $this->transactionType = $transactionType;

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

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageFile(): ?string
    {
        return $this->imageFile;
    }

    public function setImageFile(string $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }
}
