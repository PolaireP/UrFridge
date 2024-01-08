<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe')]
    public function index(RecipeRepository $repository, Request $request): Response
    {
        $searchString = $request->query->get('search-recipes', '');
        $recipes = $repository->search($searchString);

        $images = [];
        foreach ($recipes as $key => $recipe) {
            $images[$recipe->getRecipeId()] = base64_encode(stream_get_contents($recipe->getRecipePhoto()->getRecipePhoto()));
        }

        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
            'images' => $images,
            'searchString' => $searchString,
        ]);
    }
}
