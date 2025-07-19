<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inputVille', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('selectTypeBien', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison',
                ],
                'placeholder' => 'Choisissez...',
                'required' => false,
            ])
            ->add('selectTransaction', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Vente' => 'Vente',
                    'Location' => 'Location',
                ],
                'placeholder' => 'Choisissez...',
                'required' => false,
            ])
            ->add('inputPrixMin', IntegerType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('inputPrixMax', IntegerType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('roomNumber', IntegerType::class, [
                'label' => 'Nombre de pièces',
                'required' => false,
            ])
            ->add('harea', IntegerType::class, [
                'label' => 'Surface minimum (en m²)',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
