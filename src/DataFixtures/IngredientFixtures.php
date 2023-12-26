<?php

namespace App\DataFixtures;

use App\Factory\IngredientFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/data/Ingredient.json'), true);

        foreach ($data as $ingredient) {
            IngredientFactory::createOne($ingredient);
        }

    }
}
