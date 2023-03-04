<?php

namespace App\Entity;

use App\Repository\RentalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="rental", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tenant;

    /**
     * @ORM\OneToMany(targetEntity=Properties::class, mappedBy="rental")
     */
    private $property;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $endDate;

    public function __construct()
    {
        $this->property = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Properties>
     */
    public function getProperty(): Collection
    {
        return $this->property;
    }

    public function addProperty(Properties $property): self
    {
        if (!$this->property->contains($property)) {
            $this->property[] = $property;
            $property->setRental($this);
        }

        return $this;
    }

    public function removeProperty(Properties $property): self
    {
        if ($this->property->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getRental() === $this) {
                $property->setRental(null);
            }
        }

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}
