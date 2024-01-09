<?php

namespace App\Controller;

use App\Entity\Allergen;
use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe')]
    public function index(RecipeRepository $repository, Request $request, EntityManagerInterface $manager): Response
    {
        // Recherche des recettes
        $searchString = $request->query->get('search-recipes', '');
        $recipes = $repository->search($searchString);

        // Liste des images des recettes
        $images = [];
        foreach ($recipes as $key => $recipe) {
            $images[$recipe->getRecipeId()] = base64_encode(stream_get_contents($recipe->getRecipePhoto()->getRecipePhoto()));
        }

        // Listage de tous les allergènes
        $allergens = $manager->getRepository(Allergen::class)->findAll();

        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
            'images' => $images,
            'searchString' => $searchString,
            'allergens' => $allergens,
        ]);
    }

    #[Route('/recipe/{id}', name: 'app_recipe_show')]
    public function show(Recipe $recipe): Response
    {
        return $this->render('pages/recipe/show.html.twig', [
           'recipe' => dump($recipe),
        ]);
    }
}
