<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('recipePhoto', 'idPhoto')
                ->setFormTypeOptions([
                    'class' => 'App\Entity\RecipePhoto',
                    'choice_label' => 'id',
                ])
                ->setCrudController(RecipePhotoCrudController::class),
            TextField::new('recipeName'),
            TextEditorField::new('recipeDescription'),
            DateField::new('recipePubDate'),
            BooleanField::new('verified'),
        ];
    }
}
