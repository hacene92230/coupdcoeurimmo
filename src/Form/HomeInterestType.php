<?php

namespace App\Form;

use App\Entity\HomeInterest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeInterestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('financing', ChoiceType::class, [
            'label' => false,
            'choices' => [
                'Oui' => true,
                'Non' => false,
            ],
            'expanded' => true,
            'multiple' => false,
        ])
        ->add('financialContribution', ChoiceType::class, [
            'label' => false,
            'choices' => [
                'Oui' => true,
                'Non' => false,
            ],
            'expanded' => true,
            'multiple' => false,
        ])

            ->add('priceContribution', NumberType::class, [
                'label' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomeInterest::class,
        ]);
    }
}
