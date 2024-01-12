<?php

namespace App\Controller\Admin;

use App\Entity\Person;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PersonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Person::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $rolesField = ArrayField::new('roles');

        $idField = Field::new('id')->hideOnForm();

        return [
            TextField::new('lastname', 'Nom'),
            TextField::new('firstname', 'Prénom'),
            TextField::new('email', 'Email'),
            AssociationField::new('inventory', 'id inventaire')
                ->setFormTypeOptions([
                    'class' => 'App\Entity\Inventory',
                    'choice_label' => 'id',
                ])
                ->setCrudController(InventoryCrudController::class),
            $idField, $rolesField];
    }
}
