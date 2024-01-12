<?php

namespace App\Controller;

use App\Entity\Allergen;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Comment;
use App\Entity\Commentary;
use App\Entity\Recipe;
use App\Form\CommentaryType;
use App\Repository\IngredientPhotoRepository;
use App\Repository\RecipeQuantityRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    #[Route('/recipe/recipes', name: 'app_recipe_all')]
    public function getAllRecipe(RecipeRepository $repository, Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);
        $search = $jsonData['search'] ?? '';
        $ingredientsId = $jsonData['ingredientsId'] ?? null;
        $allergensId = $jsonData['allergensId'] ?? null;
        $categoriesId = $jsonData['categoriesId'] ?? null;
        $filters = $jsonData['filters'] ?? null;

        $recipes = $repository->getRecipeFromCriterias($search, $ingredientsId, $allergensId, $categoriesId, $filters);

        $recipeCollection = [];

        foreach ($recipes as $recipe) {
            $recipeCollection[] = [
                'id' => $recipe[0]->getId(),
                'recipeName' => $recipe[0]->getRecipeName(),
                'recipePubDate' => $recipe[0]->getRecipePubDate(),
                'recipePhoto' => base64_encode(stream_get_contents($recipe['recipePhoto'])),
                'author' => $recipe[0]->getAuthor(),
                'stepNumbers' => $recipe['stepNumbers'],
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

    #[Route('/recipe/{id}', name: 'app_recipe_show')]
    public function show(Recipe $recipe, RecipeRepository $recipeRepository, IngredientPhotoRepository $ingredientPhotoRepository, RecipeQuantityRepository $recipeQuantityRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $numberOfStep = $recipeRepository->countStepsForRecipe($recipe->getRecipeId());
        $allergens = $recipeRepository->getAllergensForRecipe($recipe->getRecipeId());

        // Image de la recette
        $imageRecipe = base64_encode(stream_get_contents($recipe->getRecipePhoto()->getRecipePhoto()));

        // Liste des images des équipements
        $imagesEquipments = [];
        foreach ($recipe->getEquipments() as $key => $equipment) {
            $imagesEquipments[$equipment->getId()] = base64_encode(stream_get_contents($equipment->getEquipmentPhoto()->getEquipmentPhoto()));
        }

        $quantities = $recipeQuantityRepository->getIngredientQuantitiesForRecipe($recipe->getId());

        // Partie commentaire

        $commentary = new Commentary();
        $form = $this->createForm(CommentaryType::class, $commentary);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentary = $form->getData();
            $manager->persist($commentary);

            $comment = new Comment();
            $comment->setCommentary($commentary);
            $comment->setRecipe($recipe);

            $user = $this->getUser();
            if (!$user) {
                $this->addFlash('error', 'Vous devez être connecté pour poster un commentaire.');

                return $this->redirectToRoute('app_login');
            }
            $comment->setWriter($user);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('app_recipe_show', ['id' => $recipe->getId()]);
        }

        return $this->render('pages/recipe/show.html.twig', [
           'recipe' => $recipe,
            'numberOfStep' => $numberOfStep,
            'allergens' => $allergens,
            'imageRecipe' => $imageRecipe,
            'imagesEquipments' => $imagesEquipments,
            'quantities' => $quantities,
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/updateFavorite/{id}', name: 'app_recipe_favorite')]
    public function updateFavorite(Recipe $recipe, EntityManagerInterface $manager): RedirectResponse
    {
        $user = $this->getUser();
        $listeFavoris = $user->getFavorites();

        $exist = false;
        foreach ($listeFavoris as $favoris) {
            if ($favoris->getId() == $recipe->getId()) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $user->addFavorite($recipe);
        } else {
            $user->removeFavorite($recipe);
        }
        $manager->flush();

        return $this->redirectToRoute('app_recipe_show', ['id' => $recipe->getId()]);
    }
}
