<?php

namespace App\Entity;

use App\Repository\RentalApplicationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * @ORM\Entity(repositoryClass=RentalApplicationRepository::class)
 * @Vich\Uploadable
 */
class RentalApplication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="id_card", fileNameProperty="idCard")
     */
    private $idCard;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="tax_form", fileNameProperty="taxForm")
     */
    private $taxForm;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="pay_stub", fileNameProperty="payStub")
     */
    private $payStub;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="proof_residence", fileNameProperty="proofResidence")
     */
    private $proofResidence;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="guarantor_pay_stub", fileNameProperty="guarantorPayStub")
     */
    private $guarantorPayStub;

    /**
     * @ORM\Column(type="boolean")
     */
    private $guarantor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCard(): ?string
    {
        return $this->idCard;
    }

    public function setIdCard(string $idCard): self
    {
        $this->idCard = $idCard;

        return $this;
    }

    public function getTaxForm(): ?string
    {
        return $this->taxForm;
    }

    public function setTaxForm(string $taxForm): self
    {
        $this->taxForm = $taxForm;

        return $this;
    }

    public function getPayStub(): ?string
    {
        return $this->payStub;
    }

    public function setPayStub(string $payStub): self
    {
        $this->payStub = $payStub;

        return $this;
    }

    public function getProofResidence(): ?string
    {
        return $this->proofResidence;
    }

    public function setProofResidence(string $proofResidence): self
    {
        $this->proofResidence = $proofResidence;

        return $this;
    }

    public function getGuarantorPayStub(): ?string
    {
        return $this->guarantorPayStub;
    }

    public function setGuarantorPayStub(string $guarantorPayStub): self
    {
        $this->guarantorPayStub = $guarantorPayStub;

        return $this;
    }

    public function isGuarantor(): ?bool
    {
        return $this->guarantor;
    }

    public function setGuarantor(bool $guarantor): self
    {
        $this->guarantor = $guarantor;

        return $this;
    }
}
