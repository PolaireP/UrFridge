<?php

namespace App\DataFixtures;

use App\Factory\EquipmentPhotoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipmentPhotoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/data/EquipmentPhoto.json'), true);

        // Itération du json pour charger le contenu des images dans recipePhoto
        foreach ($data as $key => $element) {
            $data[$key]['equipmentPhoto'] = file_get_contents(__DIR__.'/data/'.$element['equipmentPhoto']);
        }

        $factory = EquipmentPhotoFactory::createSequence($data);
    }
}
