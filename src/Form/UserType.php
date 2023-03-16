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
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($this->tokenStorage->getToken() != null) {
            $userConnected = $this->tokenStorage->getToken()->getUser();
            $roles = $userConnected->getRoles();
        }

        $user = $options['data'];

        if (!empty($roles) and $roles[0] == "ROLE_ADMIN") {
            $builder
                ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'Administrateur' => 'ROLE_ADMIN',
                        'Propriétaire' => 'ROLE_OWNER',
                        'Simple utilisateur' => 'ROLE_USER',
                        'Locataire' => 'ROLE_TENANT'
                    ],
                    "expanded" => false,
                    "multiple" => false,
                ]);

            $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
                    fn ($rolesAsArray) => count($rolesAsArray) ? $rolesAsArray[0] : null,
                    fn ($rolesAsString) => [$rolesAsString]
                ));
        }

        $builder
            ->add('placeType', ChoiceType::class, [
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
                'property_path' => 'address.placeNumber',
                "attr" => [
                    "min" => 1,
                    "value" => 1,
                ]
            ])

            ->add('city', TextType::class, [
                'property_path' => 'address.city',
            ])

            ->add('zipCode', IntegerType::class, [
                'property_path' => 'address.zipCode',
            ])

            ->add("name", TextType::class, [])

            ->add('phone', TelType::class, [
                'label' => "Saisir votre numéro de téléphone"
            ])

            ->add('email', EmailType::class, []);

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
