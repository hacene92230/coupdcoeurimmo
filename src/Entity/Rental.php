<?php

namespace App\Entity;

use App\Repository\RentalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentalRepository::class)
 */
class Rental
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="rental", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tenant;

    /**
     * @ORM\OneToOne(targetEntity=Properties::class, inversedBy="rental", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnd;

    /**
     * @ORM\OneToOne(targetEntity=Rent::class, mappedBy="rental", cascade={"persist", "remove"})
     */
    private $rent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenant(): ?User
    {
        return $this->tenant;
    }

    public function setTenant(User $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getProperty(): ?Properties
    {
        return $this->property;
    }

    public function setProperty(Properties $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTime $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTime $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getRent(): ?Rent
    {
        return $this->rent;
    }

    public function setRent(Rent $rent): self
    {
        // set the owning side of the relation if necessary
        if ($rent->getRental() !== $this) {
            $rent->setRental($this);
        }

        $this->rent = $rent;

        return $this;
    }
}
