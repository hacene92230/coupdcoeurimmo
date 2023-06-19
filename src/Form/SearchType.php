<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('keyword', TextType::class, [
                'label' => 'Mot clé',
                'required' => false,
            ])
            ->add('rent', TextType::class, [
                'label' => 'Loyer',
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner votre catégorie',
                'required' => false,
                'empty_data' => null,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de bien',
                'choices' => [
                    'Appartement' => 0,
                    'Maison' => 1,
                    'Terrain' => 3,
                ],
                'placeholder' => 'Sélectionnez un type de bien',
                'required' => false,
                'empty_data' => null,
            ])
            ->add('localisation', TextType::class, [
                'label' => 'Localisation',
                'required' => false,
            ])
            ->add('priceMin', IntegerType::class, [
                'label' => 'Prix minimum',
                'required' => false,
            ])
            ->add('priceMax', IntegerType::class, [
                'label' => 'Prix maximum',
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
?>
