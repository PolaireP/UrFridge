<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Factory\IngredientFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class IngredientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $ingredientsData = json_decode(file_get_contents(__DIR__.'/data/Ingredient.json'), true);

        foreach ($ingredientsData as $data) {
            $ingredient = new Ingredient();
            $ingredient->setIngredientName($data['ingredientName']);
            $ingredient->setAvgUnitWeight($data['avgUnitWeight']);
            $ingredient->setAvgUnitVolume($data['avgUnitVolume']);
            $ingredient->setCountable($data['countable']);
            $ingredient->setKgPrice($data['kgPrice']);

            $manager->persist($ingredient);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AllergenFixtures::class,
            IngredientTypeFixtures::class,
        ];
    }
}
