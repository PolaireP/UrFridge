<?php

namespace App\DataFixtures;

use App\Entity\RecipePhoto;
use App\Factory\RecipeFactory;
use App\Factory\RecipePhotoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class RecipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

    }

    public function getDepencies() {
        return [
            RecipePhotoFixtures::class
        ];
    }
}
