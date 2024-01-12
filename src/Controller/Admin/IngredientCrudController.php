<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ingredient::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('ingredientName'),
            BooleanField::new('countable'),
            NumberField::new('avgUnitWeight'),
            NumberField::new('avgUnitVolume'),
            MoneyField::new('kgPrice')->setCurrency('EUR'),
            AssociationField::new('allergens', 'Allergens')
                ->setFormTypeOptions([
                    'multiple' => true,
                    'class' => 'App\Entity\Allergen',
                    'choice_label' => 'allergenName',
                ])
                ->setCrudController(AllergenCrudController::class),
            AssociationField::new('recipes', 'Recipes')
                ->setFormTypeOptions([
                    'multiple' => true,
                    'class' => 'App\Entity\Recipe',
                    'choice_label' => 'recipeName',
                ])
                ->setCrudController(RecipeCrudController::class),
            ArrayField::new('quantities')->hideOnIndex(),
            ArrayField::new('recipeQuantities')->hideOnIndex(),
        ];
    }
}
