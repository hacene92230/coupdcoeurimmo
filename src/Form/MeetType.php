<?php

namespace App\Form;

use App\Entity\Meet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label'=> "date",
                'placeholder'=> "jj/mm/aaa"
            ])
            ->add('comment', TextareaType::class, [
                'label'=> "commentaire",
                'placeholder'=> 'comment'
            ])
            ->add('motif', TextType::class, [
                'label'=> 'motif',
                'placeholder'=> 'motif'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meet::class,
        ]);
    }
}
