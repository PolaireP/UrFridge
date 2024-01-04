<?php

namespace App\DataFixtures;

use App\Factory\IngredientPhotoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class IngredientPhotoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/data/IngredientPhoto.json'), true);

        foreach($data as $key => $element) {
            $data[$key]['ingredientPhoto'] = file_get_contents(__DIR__."/data/".$element['ingredientPhoto']);
        }

        $factory = IngredientPhotoFactory::createSequence($data);
    }
}
