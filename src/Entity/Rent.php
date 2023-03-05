<?php

namespace App\Entity;

use App\Repository\RentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentRepository::class)
 */
class Rent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Rental::class, inversedBy="rent", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $rental;

    /**
     * @ORM\Column(type="datetime")
     */
    private $paymentDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paid;

    /**
     * @ORM\Column(type="integer")
     */
    private $amountPaid;

    /**
     * @ORM\Column(type="integer")
     */
    private $amountRemaining;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $paymentMethod;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRental(): ?Rental
    {
        return $this->rental;
    }

    public function setRental(Rental $rental): self
    {
        $this->rental = $rental;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function isPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getAmountPaid(): ?int
    {
        return $this->amountPaid;
    }

    public function setAmountPaid(int $amountPaid): self
    {
        $this->amountPaid = $amountPaid;

        return $this;
    }

    public function getAmountRemaining(): ?int
    {
        return $this->amountRemaining;
    }

    public function setAmountRemaining(int $amountRemaining): self
    {
        $this->amountRemaining = $amountRemaining;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}
