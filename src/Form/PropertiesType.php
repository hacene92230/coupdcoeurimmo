<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Properties;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('garden', CheckboxType::class, [
                "label" => "Ce bien dispose d'un jardin"
            ])->add('transactionType', ChoiceType::class, [
                'choices' => [
                    'Vente' => '0',
                    'Location' => '1'
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'label' => 'Type de transaction'
            ])

            ->add('housingType', ChoiceType::class, [
                'choices' => [
                    'Appartement' => '0',
                    'Maison' => '1'
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'label' => 'Type du logement'
            ])

            ->add('roomNumber', IntegerType::class, [
                "label" => "Nombre de pièce de ce bien",
                "attr" => [
                    "min" => 1,
                    "max" => 30,
                    "value" => 0
                ]
            ])

            ->add('rent', IntegerType::class, [
                "label" => "Loyer du bien, si c'est une vente laissez comme cela",
                "required" => false,
                "attr" => [
                    "min" => 0,
                    "max" => 10000,
                    "value" => 0
                ]
            ])

            ->add('price', IntegerType::class, [
                "label" => "Saisir le prix de vente de ce bien, si c'est une location laissez comme tel",
                "required" => false,
                "attr" => [
                    "min" => 0,
                    "value" => 0
                ]
            ])

            ->add('user', EntityType::class, [
                "label" => "Propriétaire",
                'class' => 'App\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :roles')
                        ->setParameter('roles', '%ROLE_OWNER%')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => 'Choisir un propriétaire',
                'required' => true,
                "expanded" => false,
            ])

            ->add("harea", IntegerType::class, [
                "label" => "Superficie de ce bien",
                "attr" => [
                    "min" => 10,
                    "max" => 500,
                    "value" => 10
                ]
            ])

            ->add("address", TextType::class, [
                "label" => "Adresse du bien"
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
