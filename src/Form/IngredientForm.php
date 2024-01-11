<?php

namespace App\Form;

use App\Entity\Allergen;
use App\Entity\Ingredient;
use App\Entity\IngredientType;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ingredientName')
            ->add('countable')
            ->add('avgUnitWeight')
            ->add('avgUnitVolume')
            ->add('kgPrice')
            ->add('recipes', EntityType::class, [
                'class' => Recipe::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('allergens', EntityType::class, [
                'class' => Allergen::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('ingredientTypes', EntityType::class, [
                'class' => IngredientType::class,
'choice_label' => 'id',
'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
