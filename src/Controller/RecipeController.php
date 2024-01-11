<?php

namespace App\Controller;

use App\Entity\Allergen;
use App\Entity\Comment;
use App\Entity\Commentary;
use App\Entity\Recipe;
use App\Form\CommentaryType;
use App\Repository\IngredientPhotoRepository;
use App\Repository\RecipeQuantityRepository;
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
        ]);
    }
}
