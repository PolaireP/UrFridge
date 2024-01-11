<?php

namespace App\Controller\Admin;

use App\Entity\Equipment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EquipmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Equipment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('equipmentPhoto', 'idPhoto')
                ->setFormTypeOptions([
                    'class' => 'App\Entity\EquipmentPhoto',
                    'choice_label' => 'id',
                ])
                ->setCrudController(EquipmentPhotoCrudController::class),
            TextField::new('equipmentName'),
            TextField::new('equipmentLink'),
        ];
    }
}
