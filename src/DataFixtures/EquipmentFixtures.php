<?php

namespace App\DataFixtures;

use App\Factory\EquipmentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class EquipmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $path = __DIR__.'/data/Equipment.json';
        $content = file_get_contents($path);
        $content_decode = json_decode($content, true);

        foreach ($content_decode as $equipment) {
            EquipmentFactory::createOne($equipment);
        }

    }
}
