<?php

namespace App\Controller\Admin;

use App\Entity\IngredientPhoto;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class IngredientPhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return IngredientPhoto::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
        ];
    }
}
