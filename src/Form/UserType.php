<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['data'];
        $builder
            ->add('placeType', ChoiceType::class, [
                'label' => 'Sélectionner le type de place',
                'property_path' => 'address.placeType',
                'choices' => [
                    'Boulevard' => 'Boulevard',
                    'Rue' => 'Rue',
                    'Avenue' => 'Avenue',
                    'Place' => 'Place',
                ],
                'placeholder' => 'Sélectionner un type de place',
            ])

            ->add("placeNumber", IntegerType::class, [
                "label" => "Numéro de rue, avenue ou autre",
                'property_path' => 'address.placeNumber',
                "attr" => [
                    "min" => 1,
                    "value" => 1,
                ]
            ])

            ->add('city', TextType::class, [
                'label' => 'Ville',
                'property_path' => 'address.city',
            ])

            ->add('zipCode', IntegerType::class, [
                'label' => 'Code postal',
                'property_path' => 'address.zipCode',
            ])

            ->add("name", TextType::class, [
                "label" => "Saisir votre prénom"
            ])

            ->add('phone', TelType::class, [
                'label' => "Saisir votre numéro de téléphone"
            ])

            ->add('email', EmailType::class, [
                "label" => "saisir  votre adresse mail"
            ]);



        if (!$user->getId()) {
            $builder->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
            ]);;
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
