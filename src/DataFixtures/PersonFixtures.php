<?php

namespace App\DataFixtures;

use App\Factory\InventoryFactory;
use App\Factory\PersonFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PersonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        PersonFactory::createMany(20, function () {
            return [
                'inventory' => InventoryFactory::createOne(),
            ];
        });
    }

    public function getDependencies()
    {
        return [
            InventoryFixtures::class,
        ];
    }
}
