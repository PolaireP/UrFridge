<?php

namespace App\Controller\Admin;

use App\Entity\Allergen;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AllergenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Allergen::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('allergenName'),
            TextField::new('allergenDescription'),
        ];
    }

}
