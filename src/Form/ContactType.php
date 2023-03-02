<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add ('name', TextType::class, [
            'label'=> "Votre prénom"
        ])
        ->add('email',EmailType::class, [
            'label'=> "Votre adresse email"
        ])
        ->add('phone', TelType::class, [
            'label' => "Saisir votre numéro de téléphone"
        ])
        ->add('subject',TextType::class, [
            'label' => "Sujet de votre contact"
        ])
        ->add('content',TextareaType::class, [
            'label' => "Contenu de votre message"
        ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
