<?php

namespace App\Form;

use App\Entity\RentalApplication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RentalApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idCardRecto', VichImageType::class, [
                'download_uri' => true,
                'image_uri' => true
            ])

            ->add('idCardVerso', VichImageType::class, [
                'download_uri' => true,
                'image_uri' => true
            ])

            ->add('taxForm', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                "label" => "Avis d'impôt sur les revenus de l'année passée"
            ])

            ->add('payStub1', VichImageType::class, [
                'download_uri' => true,
                'image_uri' => true
            ])

            ->add('payStub2', VichImageType::class, [
                'download_uri' => true,
                'image_uri' => true
            ])

            ->add('payStub3', VichImageType::class, [
                'download_uri' => true,
                'image_uri' => true
            ])

            ->add('proofResidence', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                "label" => "justificatif de domicil actuel (Si pas votre nom attestation d'hébergement)",
            ])

            ->add('guarantorPayStub1', VichImageType::class, [
                "required" => false,                'download_uri' => true,
                'image_uri' => true
            ])

            ->add('guarantorPayStub2', VichImageType::class, [
                "required" => false,                 'download_uri' => true,
                'image_uri' => true
            ])

            ->add('guarantorPayStub3', VichImageType::class, [
                "required" => false,                 'download_uri' => true,
                'image_uri' => true
            ])

            ->add(
                'guarantor',
                CheckboxType::class,
                [
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
