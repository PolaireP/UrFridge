<?php

namespace App\DataFixtures;

use App\Factory\RecipeFactory;
use App\Factory\StepFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class StepFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Chargement des données
        $data = json_decode(file_get_contents(__DIR__.'/data/Step.json'), true);
        $recipeId = RecipeFactory::first()->getId();

        // Opération sur les données (recherche des RecipePhoto et ajout )
        foreach($data as $key => $element) {
            $data[$key]['recipe'] = RecipeFactory::findBy(['id' => $recipeId + $data[$key]['recipe']])[0];
        }

        $factory = StepFactory::createSequence($data);
    }

    public function getDependencies()
    {
        return [
            RecipeFixtures::class
        ];

    }
}
