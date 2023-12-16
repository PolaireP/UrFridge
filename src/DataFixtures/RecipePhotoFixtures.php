<?php

namespace App\DataFixtures;

use App\Factory\RecipePhotoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class RecipePhotoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $sequence = json_decode(file_get_contents(__DIR__.'/data/RecipePhoto.json', boolval(FILE_USE_INCLUDE_PATH)), true);
        // Itération du json pour charger le contenu des images dans recipePhoto
        foreach($sequence as $element) {
            $element['recipePhoto'] = file_get_contents(__DIR__.'/data/'.$element['recipePhoto']);
        }

        $factory = RecipePhotoFactory::createSequence($sequence);
    }
}
