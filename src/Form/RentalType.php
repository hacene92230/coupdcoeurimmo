<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Rental;
use App\Entity\Properties;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RentalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateStart', DateType::class, [
                'label' => 'Date de début de location',
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') - 100),
                'format' => 'dd/MM/yyyy',
                'data' => new \DateTime(),
                'attr' => [
                    'min' => (new \DateTime())->format('dd/MM/yyyy'),
                ],
            ])

            ->add('dateEnd', DateType::class, [
                'label' => 'Date de fin de location',
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') + 7),
                'format' => 'dd/MM/yyyy',
            ])

            ->add('tenant', EntityType::class, [
                'class' => User::class,
                'label' => "Qui souhaite louer?",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->leftJoin('u.rental', 'r')
                        ->where('u.roles LIKE :roles')
                        ->andWhere('r.id IS NULL')
                        ->setParameter('roles', '%"ROLE_USER"%');
                },
                'choice_label' => 'name',
                'placeholder' => 'Choisissez un utilisateur',
            ])

            ->add('property', EntityType::class, [
                'class' => Properties::class,
                "label" => "Quel propriété souhaitez-vous louer?",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->leftJoin('p.rental', 'r')
                        ->where('r.id IS NULL')
                        ->orderBy('p.title', 'ASC');
                },
                'choice_label' => 'title',
                'placeholder' => 'Choisissez une propriété',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
