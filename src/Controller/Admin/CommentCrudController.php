<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('commentary', 'id commentaire')
                ->setFormTypeOptions([
                    'class' => 'App\Entity\Commentary',
                    'choice_label' => 'id',
                ])
                ->setCrudController(CommentaryCrudController::class),
            AssociationField::new('writer', 'id Auteur')
                ->setFormTypeOptions([
                    'class' => 'App\Entity\Person',
                    'choice_label' => 'id',
                ])
                ->setCrudController(PersonCrudController::class),
            AssociationField::new('recipe', 'id Recette')
                ->setFormTypeOptions([
                    'class' => 'App\Entity\Recipe',
                    'choice_label' => 'id',
                ])
                ->setCrudController(RecipeCrudController::class),
        ];
    }

}
