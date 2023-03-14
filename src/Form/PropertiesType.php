<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ImageType;
use App\Entity\Properties;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('category', ChoiceType::class, [
                'choices' => $options['categories'],
                'choice_label' => 'name',
                'required' => true,
            ])

            ->add('garden', CheckboxType::class, [
                "label" => "Ce bien dispose d'un jardin"
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
                ]
            ])

            ->add('rent', IntegerType::class, [
                "label" => "Loyer du bien, si c'est une vente laissez comme cela",
                "required" => false,
                "attr" => [
                    "min" => 0,
                    "max" => 10000,
                    "id" => "form_rent"
                ]
            ])

            ->add('price', IntegerType::class, [
                "label" => "Saisir le prix de vente de ce bien, si c'est une location laissez comme tel",
                "required" => false,
                "attr" => [
                    "min" => 0,

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
                ]
            ])

            ->add('placeType', ChoiceType::class, [
                'label' => 'Sélectionner le type de place',
                'property_path' => 'address.placeType',
                'choices' => [
                    'Boulevard' => 'Boulevard',
                    'Rue' => 'Rue',
                    'Avenue' => 'Avenue',
                    'Place' => 'Place',
                ],
                'placeholder' => 'Sélectionner un type de lieu',
            ])

            ->add("placeNumber", IntegerType::class, [
                "label" => "Numéro de rue, avenue ou autre",
                'property_path' => 'address.placeNumber',
                "attr" => [
                    "min" => 1,
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

            ->add("yearBuilt", DateType::class, [
                "label" => "Date de construction du dit logement"
            ])

            ->add('heating', ChoiceType::class, [
                "label" => "Type du chauffage",
                'choices' => [
                    'Electrique' => 'electrique',
                    'Pompe à chaleur' => 'pompe a chaleur',
                    'A bois' => 'a bois',
                    'Au gaz' => 'au gaz',
                ],
                'placeholder' => 'Choisir un type de chauffage',
            ])

            ->add('title', TextType::class, [
                "label" => "Titre de l'annonce"
            ])

            ->add('content', TextareaType::class, [
                "label" => "Saisir le contenu de l'annonce"
            ])

            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                "label" => "Importez les images représentant ce bien",
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Properties::class
        ]);
    }
}
