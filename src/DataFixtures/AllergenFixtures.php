<?php

namespace App\DataFixtures;

use App\Factory\AllergenFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class AllergenFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $path = __DIR__.'/data/Allergen.json';
        $content = file_get_contents($path);
        $data = json_decode($content, true);

        foreach ($data as $allergenData){
            AllergenFactory::createOne($allergenData);
        }
    }
}
