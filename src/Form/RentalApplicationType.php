<?php

namespace App\Form;

use App\Entity\RentalApplication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RentalApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idCardRecto', FileType::class, [
                "mapped" => false
            ])

            ->add('idCardVerso', FileType::class, [
                "mapped" => false,
            ])

            ->add('taxForm', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                "label" => "Avis d'impôt sur les revenus de l'année passée"
            ])

            ->add('payStub1', FileType::class, [
                "mapped" => false,
            ])

            ->add('payStub2', FileType::class, [
                "mapped" => false,
            ])

            ->add('payStub3', FileType::class, [
                "mapped" => false,
            ])

            ->add('proofResidence', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                "label" => "justificatif de domicil actuel (Si pas votre nom attestation d'hébergement)",
            ])

            ->add('guarantorPayStub1', FileType::class, [
                "mapped" => false
            ])

            ->add('guarantorPayStub2', FileType::class, [
                "mapped" => false
            ])

            ->add('guarantorPayStub3', FileType::class, [
                "mapped" => false
            ])

            ->add(
                'guarantor',
                CheckboxType::class,
                [
                    "label" => "J'ai un garant",
                    "required" => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RentalApplication::class,
        ]);
    }
}
