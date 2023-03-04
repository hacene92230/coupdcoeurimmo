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
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="rental", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tenant;

    /**
     * @ORM\OneToOne(targetEntity=Properties::class, inversedBy="rental", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

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
}
