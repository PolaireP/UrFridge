<?php

namespace App\DataFixtures;

use App\Factory\EquipmentFactory;
use App\Factory\EquipmentPhotoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EquipmentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $path = __DIR__.'/data/Equipment.json';

        $content = file_get_contents($path);
        $content_decode = json_decode($content, true);
        $actualPhoto = 0;
        $firstPhotoId = EquipmentPhotoFactory::first()->getId();

        foreach ($content_decode as $equipment) {
            $equipment['equipmentPhoto'] = EquipmentPhotoFactory::findBy(['id' => $firstPhotoId + $actualPhoto])[0];
            EquipmentFactory::createOne($equipment);
            ++$actualPhoto;
        }
    }

    public function getDependencies()
    {
        return [
            EquipmentPhotoFixtures::class
        ];
    }
}
