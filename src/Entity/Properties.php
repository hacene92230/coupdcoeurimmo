<?php

namespace App\Entity;

use App\Repository\PropertiesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropertiesRepository::class)
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
    private $sale;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rental;

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
    private $house;

    /**
     * @ORM\Column(type="boolean")
     */
    private $apartment;

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

    public function isSale(): ?bool
    {
        return $this->sale;
    }

    public function setSale(bool $sale): self
    {
        $this->sale = $sale;

        return $this;
    }

    public function isRental(): ?bool
    {
        return $this->rental;
    }

    public function setRental(bool $rental): self
    {
        $this->rental = $rental;

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

    public function isHouse(): ?bool
    {
        return $this->house;
    }

    public function setHouse(bool $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function isApartment(): ?bool
    {
        return $this->apartment;
    }

    public function setApartment(bool $apartment): self
    {
        $this->apartment = $apartment;

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
}
