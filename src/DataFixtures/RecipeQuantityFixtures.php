<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Factory\IngredientFactory;
use App\Factory\RecipeFactory;
use App\Factory\RecipeQuantityFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RecipeQuantityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/data/RecipeQuantity.json'), true);
        $ingredientId = IngredientFactory::first()->getId() + 1;
        $recipeId = RecipeFactory::first()->getId();

        // Ajout des entités dans les données pour remplir la BD
        foreach ($data as $key => $element) {
            $data[$key]['recipe'] = RecipeFactory::findBy(['id' => $recipeId + $data[$key]['recipe']])[0];
            $data[$key]['ingredient'] = IngredientFactory::findBy(['id' => $ingredientId + $data[$key]['ingredient']])[0];
        }

        RecipeQuantityFactory::createSequence($data);
    }

    public function getDependencies()
    {
        return [
            RecipeFixtures::class,
            IngredientFixtures::class,
        ];
    }
}
