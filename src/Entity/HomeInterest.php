<?php

namespace App\Entity;

use App\Repository\HomeInterestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomeInterestRepository::class)
 */
class HomeInterest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="homeInterests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Properties::class, inversedBy="homeInterests")
     */
    private $properties;

    /**
     * @ORM\Column(type="boolean")
     */
    private $financing;

    /**
     * @ORM\Column(type="boolean")
     */
    private $financialContribution;

        /**
     * @ORM\Column(type="integer")
     */
    private $priceContribution;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        }

        return $this;
    }

    public function removeProperty(Properties $property): self
    {
        $this->properties->removeElement($property);

        return $this;
    }

    public function isFinancing(): ?bool
    {
        return $this->financing;
    }

    public function setFinancing(bool $financing): self
    {
        $this->financing = $financing;

        return $this;
    }

    public function isFinancialContribution(): ?bool
    {
        return $this->financialContribution;
    }

    public function setFinancialContribution(bool $financialContribution): self
    {
        $this->financialContribution = $financialContribution;

        return $this;
    }

    
    /**
     * Get the value of priceContribution
     */ 
    public function getPriceContribution()
    {
        return $this->priceContribution;
    }

    /**
     * Set the value of priceContribution
     *
     * @return  self
     */ 
    public function setPriceContribution($priceContribution)
    {
        $this->priceContribution = $priceContribution;

        return $this;
    }

}
