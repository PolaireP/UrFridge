<?php

namespace App\DataFixtures;

use App\Factory\RecipeFactory;
use App\Factory\RecipePhotoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Chargement des données
        $data = json_decode(file_get_contents(__DIR__.'/data/Recipe.json'), true);
        $photoId = RecipePhotoFactory::first()->getId();

        // Opération sur les données (recherche des RecipePhoto et ajout )
        foreach($data as $key => $element) {
            $data[$key]['recipePhoto'] = RecipePhotoFactory::findBy(['id' => $photoId + $data[$key]['recipePhoto']])[0];
        }

        // Création de la séquence
        $factory = RecipeFactory::createSequence($data);
    }

    public function getDependencies() : array {
        return [
            RecipePhotoFixtures::class
        ];
    }
}
