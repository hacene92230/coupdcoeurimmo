<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD
            ->add('word', SearchType::class, [
                'label' => false,
                'attr'=> [
                    'class'=> 'form-control',
                    'placeholder'=>'Entrez un ou plusieurs mots-clés'
                ]
            ])
            ->add('search', SubmitType::class)
=======
            ->add('search', SearchType::class, [
                'label'=>false,
                'attr'=> [
                    'placeholder'=>'Entrer un ou plusieurs mot-clés'
                ]
            ])
            ->add('submit', SubmitType::class)
>>>>>>> c3cdb47ee315779f23fbb4c59a90b5fbeba3aa01
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
<<<<<<< HEAD
            'data_class' => null

=======
            // Configure your form options here
>>>>>>> c3cdb47ee315779f23fbb4c59a90b5fbeba3aa01
        ]);
    }
}
