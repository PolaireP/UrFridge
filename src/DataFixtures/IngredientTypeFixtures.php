<?php

namespace App\DataFixtures;

use App\Factory\IngredientTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class IngredientTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $content = file_get_contents(__DIR__.'/data/IngredientType.json');
        $decode_content = json_decode($content, true);

        foreach ($decode_content as $ingredientType) {
            IngredientTypeFactory::createOne($ingredientType);
        }
    }
}
