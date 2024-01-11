<?php

namespace App\Controller;

use App\Entity\Allergen;
use App\Repository\AllergenRepository;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe', priority: 1)]
    public function index(RecipeRepository $repository, Request $request, EntityManagerInterface $manager): Response
    {
        // Listage de tous les allergènes
        $allergens = $manager->getRepository(Allergen::class)->findAll();

        return $this->render('pages/recipe/index.html.twig', [
            'allergens' => $allergens,
        ]);
    }

    #[Route('/test', name: 'app_test')]
    public function test(RecipeRepository $repository, Request $request): Response
    {
        $recipes = $repository->getRecipeFromCriterias();

        return $this->render('pages/recipe/test.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/recipe/recipes', name: 'app_recipe_all')]
    public function getAllRecipe(RecipeRepository $repository, Request $request): JsonResponse
    {
        $search = $request->get('search');
        $ingredientsId = $request->get('ingredientsId');
        $allergensId = $request->get('allergensId');
        $categoriesId = $request->get('categoriesId');
        $filters = $request->get('filters');

        $recipes = $repository->getRecipeFromCriterias($search, $ingredientsId, $allergensId, $categoriesId, $filters);

        $recipeCollection = [];

        foreach ($recipes as $recipe) {
            $recipeCollection[] = [
                'id' => $recipe[0]->getId(),
                'recipeName' => $recipe[0]->getRecipeName(),
                'recipePubDate' => $recipe[0]->getRecipePubDate(),
                'recipePhoto' => base64_encode(stream_get_contents($recipe['recipePhoto'])),
                'author' => $recipe[0]->getAuthor(),
            ];
        }

        return new JsonResponse($recipeCollection, Response::HTTP_OK);
    }

    #[Route('/recipe/categories', name: 'app_category_all')]
    public function getCategoryByName(CategoryRepository $repository, Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);
        $searchString = $jsonData['searchCategories'] ?? '';
        $categories = $repository->search($searchString);

        $categoryCollection = [];

        foreach ($categories as $category) {
            $categoryCollection[] = [
                'id' => $category->getId(),
                'categoryName' => $category->getCategoryName(),
                'categoryDescription' => $category->getCategoryDescription(),
            ];
        }

        return new JsonResponse($categoryCollection, Response::HTTP_OK);
    }
}
