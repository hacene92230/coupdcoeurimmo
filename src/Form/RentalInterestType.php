<?php

namespace App\Form;

use App\Entity\RentalInterest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalInterestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('financing', CheckboxType::class,[
                'label'=> 'i have a bank aport?'
            ]) 
            ->add('financialContribution',CheckboxType::class,[
                'label'=> ' i have a personal aport?'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RentalInterest::class,
        ]);
    }
}
