<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RentalApplicationRepository;
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
     * @UploadableField(mapping="id_card_recto", fileNameProperty="idCardRectoName", size="idCardRectoSize")
     */
    private ?File $idCardRecto = null;

    /**
     * @UploadableField(mapping="id_card_verso", fileNameProperty="idCardVersoName", size="idCardVersoSize")
     */
    private ?File $idCardVerso = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @UploadableField(mapping="tax_form", fileNameProperty="taxFormName", size="taxFormSize")
     */
    private ?File $taxForm = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @UploadableField(mapping="pay_stub_1", fileNameProperty="payStub1Name", size="payStub1Size")
     */
    private ?File $payStub1 = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @UploadableField(mapping="pay_stub_2", fileNameProperty="payStub2Name", size="payStub2Size")
     */
    private ?File $payStub2 = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @UploadableField(mapping="pay_stub_3", fileNameProperty="payStub3Name", size="payStub3Size")
     */
    private ?File $payStub3 = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @UploadableField(mapping="proof_residence", fileNameProperty="proofResidenceName", size="proofResidenceSize")
     */
    private ?File $proofResidence = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @UploadableField(mapping="guarantor_pay_stub_1", fileNameProperty="guarantorPayStub1Name", size="guarantorPayStub1Size")
     */
    private ?File $guarantorPayStub1 = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @UploadableField(mapping="guarantor_pay_stub_2", fileNameProperty="guarantorPayStub2Name", size="guarantorPayStub2Size")
     */
    private ?File $guarantorPayStub2 = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @UploadableField(mapping="guarantor_pay_stub_3", fileNameProperty="guarantorPayStub3Name", size="guarantorPayStub3Size")
     */
    private ?File $guarantorPayStub3 = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?Bool $guarantor = null;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $idCardRectoName = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $idCardVersoName = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $taxFormName = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $payStub1Name = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $payStub2Name = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $payStub3Name = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $proofResidenceName = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $guarantorPayStub1Name = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $guarantorPayStub2Name = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $guarantorPayStub3Name = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?int $idCardRectoSize = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?int $idCardVersoSize = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?int $taxFormSize = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?int $payStub1Size = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?int $payStub2Size = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?int $payStub3Size = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?int $proofResidenceSize = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?int $guarantorPayStub1Size = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?int $guarantorPayStub2Size = null;

    /**
     * @ORM\Column(nullable=true)
     */
    private ?int $guarantorPayStub3Size = null;

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
        if (null !== $idCardRecto) {
            // Il est nécessaire qu'au moins un champ change si vous utilisez Doctrine,
            // sinon les écouteurs d'événements ne seront pas appelés et le fichier sera perdu
            $this->updatedAt = new \DateTimeImmutable();
        }

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getIdCardRectoName(): ?string
    {
        return $this->idCardRectoName;
    }

    public function setIdCardRectoName(?string $idCardRectoName): self
    {
        $this->idCardRectoName = $idCardRectoName;

        return $this;
    }

    public function getIdCardVersoName(): ?string
    {
        return $this->idCardVersoName;
    }

    public function setIdCardVersoName(?string $idCardVersoName): self
    {
        $this->idCardVersoName = $idCardVersoName;

        return $this;
    }

    public function getTaxFormName(): ?string
    {
        return $this->taxFormName;
    }

    public function setTaxFormName(?string $taxFormName): self
    {
        $this->taxFormName = $taxFormName;

        return $this;
    }

    public function getPayStub1Name(): ?string
    {
        return $this->payStub1Name;
    }

    public function setPayStub1Name(?string $payStub1Name): self
    {
        $this->payStub1Name = $payStub1Name;

        return $this;
    }

    public function getPayStub2Name(): ?string
    {
        return $this->payStub2Name;
    }

    public function setPayStub2Name(?string $payStub2Name): self
    {
        $this->payStub2Name = $payStub2Name;

        return $this;
    }

    public function getPayStub3Name(): ?string
    {
        return $this->payStub3Name;
    }

    public function setPayStub3Name(?string $payStub3Name): self
    {
        $this->payStub3Name = $payStub3Name;

        return $this;
    }

    public function getProofResidenceName(): ?string
    {
        return $this->proofResidenceName;
    }

    public function setProofResidenceName(?string $proofResidenceName): self
    {
        $this->proofResidenceName = $proofResidenceName;

        return $this;
    }

    public function getGuarantorPayStub1Name(): ?string
    {
        return $this->guarantorPayStub1Name;
    }

    public function setGuarantorPayStub1Name(?string $guarantorPayStub1Name): self
    {
        $this->guarantorPayStub1Name = $guarantorPayStub1Name;

        return $this;
    }

    public function getGuarantorPayStub2Name(): ?string
    {
        return $this->guarantorPayStub2Name;
    }

    public function setGuarantorPayStub2Name(?string $guarantorPayStub2Name): self
    {
        $this->guarantorPayStub2Name = $guarantorPayStub2Name;

        return $this;
    }

    public function getGuarantorPayStub3Name(): ?string
    {
        return $this->guarantorPayStub3Name;
    }

    public function setGuarantorPayStub3Name(?string $guarantorPayStub3Name): self
    {
        $this->guarantorPayStub3Name = $guarantorPayStub3Name;

        return $this;
    }

    public function getIdCardRectoSize(): ?int
    {
        return $this->idCardRectoSize;
    }

    public function setIdCardRectoSize(?int $idCardRectoSize): self
    {
        $this->idCardRectoSize = $idCardRectoSize;

        return $this;
    }

    public function getIdCardVersoSize(): ?int
    {
        return $this->idCardVersoSize;
    }

    public function setIdCardVersoSize(?int $idCardVersoSize): self
    {
        $this->idCardVersoSize = $idCardVersoSize;

        return $this;
    }

    public function getTaxFormSize(): ?int
    {
        return $this->taxFormSize;
    }

    public function setTaxFormSize(?int $taxFormSize): self
    {
        $this->taxFormSize = $taxFormSize;

        return $this;
    }

    public function getPayStub1Size(): ?int
    {
        return $this->payStub1Size;
    }

    public function setPayStub1Size(?int $payStub1Size): self
    {
        $this->payStub1Size = $payStub1Size;

        return $this;
    }

    public function getPayStub2Size(): ?int
    {
        return $this->payStub2Size;
    }

    public function setPayStub2Size(?int $payStub2Size): self
    {
        $this->payStub2Size = $payStub2Size;

        return $this;
    }

    public function getPayStub3Size(): ?int
    {
        return $this->payStub3Size;
    }

    public function setPayStub3Size(?int $payStub3Size): self
    {
        $this->payStub3Size = $payStub3Size;

        return $this;
    }

    public function getProofResidenceSize(): ?int
    {
        return $this->proofResidenceSize;
    }

    public function setProofResidenceSize(?int $proofResidenceSize): self
    {
        $this->proofResidenceSize = $proofResidenceSize;

        return $this;
    }

    public function getGuarantorPayStub1Size(): ?int
    {
        return $this->guarantorPayStub1Size;
    }

    public function setGuarantorPayStub1Size(?int $guarantorPayStub1Size): self
    {
        $this->guarantorPayStub1Size = $guarantorPayStub1Size;

        return $this;
    }

    public function getGuarantorPayStub2Size(): ?int
    {
        return $this->guarantorPayStub2Size;
    }

    public function setGuarantorPayStub2Size(?int $guarantorPayStub2Size): self
    {
        $this->guarantorPayStub2Size = $guarantorPayStub2Size;

        return $this;
    }

    public function getGuarantorPayStub3Size(): ?int
    {
        return $this->guarantorPayStub3Size;
    }

    public function setGuarantorPayStub3Size(?int $guarantorPayStub3Size): self
    {
        $this->guarantorPayStub3Size = $guarantorPayStub3Size;

        return $this;
    }
}
