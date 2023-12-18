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

        $data = json_decode(file_get_contents(__DIR__.'/data/RecipePhoto.json'), true);
        // Itération du json pour charger le contenu des images dans recipePhoto
        foreach($data as $key => $element) {
            $data[$key]['recipePhoto'] = file_get_contents(__DIR__."/data/".$element['recipePhoto']);
            ## dump($data[$key]['recipePhoto']);
        }

        $factory = RecipePhotoFactory::createSequence($data);
    }
}
