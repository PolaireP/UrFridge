<?php

namespace App\Controller\Admin;

use App\Entity\Allergen;
use App\Entity\Category;
use App\Entity\Equipment;
use App\Entity\EquipmentPhoto;
use App\Entity\Ingredient;
use App\Entity\IngredientPhoto;
use App\Entity\IngredientType;
use App\Entity\Person;
use App\Entity\Recipe;
use App\Entity\RecipePhoto;
use App\Entity\Step;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class dashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sae3 01');
    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->showEntityActionsInlined();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Person', 'fas fa-list', Person::class);
        yield MenuItem::section('Ingrédients');
        yield MenuItem::linkToCrud('Ingredients', 'fas fa-list', Ingredient::class);
        yield MenuItem::linkToCrud('IngredientType', 'fas fa-list', IngredientType::class);
        yield MenuItem::linkToCrud('IngredientPhoto', 'fas fa-list', IngredientPhoto::class);
        yield MenuItem::linkToCrud('Allergen', 'fas fa-list', Allergen::class);
        yield MenuItem::section('Recettes');
        yield MenuItem::linkToCrud('Recipe', 'fas fa-list', Recipe::class);
        yield MenuItem::linkToCrud('RecipePhoto', 'fas fa-list', RecipePhoto::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Step', 'fas fa-list', Step::class);
        yield MenuItem::section('Equipements');
        yield MenuItem::linkToCrud('Equipement', 'fas fa-list', Equipment::class);
        yield MenuItem::linkToCrud('EquipementPhoto', 'fas fa-list', EquipmentPhoto::class);
    }
}
