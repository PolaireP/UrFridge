<?php

namespace App\Controller\Admin;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PersonCrudController extends AbstractCrudController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $request = $this->getContext()->getRequest();

        $plainPassword = $request->request->get('Person')['password'];

        if ($plainPassword !== null && $plainPassword !== '') {
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $plainPassword);
            $entityInstance->setPassword($hashedPassword);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    public static function getEntityFqcn(): string
    {
        return Person::class;
    }

    public function configureFields(string $pageName): iterable
    {


        $rolesField = ArrayField::new('roles');

        $passwordField = TextField::new('password', PasswordType::class)
            ->onlyOnForms()
            ->setRequired(false)
            ->setEmptyData('');

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
                ->setCrudController(RecipePhotoCrudController::class),
            $idField, $rolesField, $passwordField];
    }
}
