<?php

namespace App\Form;

use App\Entity\Properties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("sale", CheckboxType::class, [
                "label" => "C'est une vente",
                "required" => false
            ])

            ->add("rental", CheckboxType::class, [
                "label" => "c'est une location",
                "required" => false
            ])

            ->add("house", CheckboxType::class, [
                "label" => "Maison",
                "required" => false
            ])

->add("apartment", CheckboxType::class, [
    "label" => "appartement",
    "required" => false,
])

            ->add('roomNumber', IntegerType::class, [
                "label" => "Nombre de pièce de ce bien",
                "attr" => [
                    "min" => 1,
                    "max" => 30,
                ]
            ])

            ->add('rent', IntegerType::class, [
                "label" => "Loyer du bien, si c'est une vente laissez vide",
                "required" => false,
                "attr" => [
                    "min" => 0,
                    "max" => 10000
                ]
            ])

            ->add('price', IntegerType::class, [
                "label" => "Saisir le prix de vente de ce bien, si c'est une location laissez vide",
                "required" => false,
                "attr" => [
                    "min" => 0
                ]
            ])

            ->add('garden', CheckboxType::class, [
                "label" => "Ce bien dispose d'un jardin"
            ])

            ->add('title', TextType::class, [
                "label" => "Titre de l'annonce"
            ])

            ->add('content', TextareaType::class, [
                "label" => "Saisir le contenu de l'annonce"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Properties::class,
        ]);
    }
}
