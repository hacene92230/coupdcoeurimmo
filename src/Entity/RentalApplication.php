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
     * @Vich\UploadableField(mapping="id_card_recto", fileNameProperty="idCardRecto")
     */
    private ?File $idCardRecto = null;

    /**
     * @Vich\UploadableField(mapping="id_card_verso", fileNameProperty="idCardVerso")
     */
    private ?File $idCardVerso = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="tax_form", fileNameProperty="taxForm")
     */
    private ?File $taxForm = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="pay_stub_1", fileNameProperty="payStub1")
     */
    private ?File $payStub1 = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="pay_stub_2", fileNameProperty="payStub2")
     */
    private ?File $payStub2 = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="pay_stub_3", fileNameProperty="payStub3")
     */
    private ?File $payStub3 = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="proof_residence", fileNameProperty="proofResidence")
     */
    private ?File $proofResidence = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="guarantor_pay_stub_1", fileNameProperty="guarantorPayStub1")
     */
    private ?File $guarantorPayStub1 = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="guarantor_pay_stub_2", fileNameProperty="guarantorPayStub2")
     */
    private ?File $guarantorPayStub2 = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Vich\UploadableField(mapping="guarantor_pay_stub_3", fileNameProperty="guarantorPayStub3")
     */
    private ?File $guarantorPayStub3 = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?String $guarantor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCardRecto(): ?File
    {
        return $this->idCardRecto;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $idCardRecto
     */
    public function setIdCardRecto(?File $idCardRecto): self
    {
        $this->idCardRecto = $idCardRecto;

        return $this;
    }

    public function getIdCardVerso(): ?File
    {
        return $this->idCardVerso;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $idCardVerso
     */
    public function setIdCardVerso(?File $idCardVerso = null): self
    {
        $this->idCardVerso = $idCardVerso;

        return $this;
    }

    public function getTaxForm(): ?File
    {
        return $this->taxForm;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $taxForm
     */
    public function setTaxForm(?File $taxForm = null): self
    {
        $this->taxForm = $taxForm;

        return $this;
    }

    public function getPayStub1(): ?File
    {
        return $this->payStub1;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $payStub1
     */
    public function setPayStub1(?File $payStub1 = null): self
    {
        $this->payStub1 = $payStub1;

        return $this;
    }

    public function getPayStub2(): ?File
    {
        return $this->payStub2;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $payStub2
     */
    public function setPayStub2(?File $payStub2 = null): self
    {
        $this->payStub2 = $payStub2;

        return $this;
    }

    public function getPayStub3(): ?File
    {
        return $this->payStub3;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $payStub3
     */
    public function setPayStub3(?File $payStub3 = null): self
    {
        $this->payStub3 = $payStub3;

        return $this;
    }

    public function getProofResidence(): ?File
    {
        return $this->proofResidence;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $proofResidence
     */
    public function setProofResidence(?File $proofResidence = null): self
    {
        $this->proofResidence = $proofResidence;

        return $this;
    }

    public function getGuarantorPayStub1(): ?File
    {
        return $this->guarantorPayStub1;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $guarantorPayStub1
     */
    public function setGuarantorPayStub1(?File $guarantorPayStub1 = null): self
    {
        $this->guarantorPayStub1 = $guarantorPayStub1;

        return $this;
    }

    public function getGuarantorPayStub2(): ?File
    {
        return $this->guarantorPayStub2;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $guarantorPayStub2
     */
    public function setGuarantorPayStub2(?File $guarantorPayStub2 = null): self
    {
        $this->guarantorPayStub2 = $guarantorPayStub2;

        return $this;
    }

    public function getGuarantorPayStub3(): ?File
    {
        return $this->guarantorPayStub3;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $guarantorPayStub3
     */
    public function setGuarantorPayStub3(?File $guarantorPayStub3 = null): self
    {
        $this->guarantorPayStub3 = $guarantorPayStub3;

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
