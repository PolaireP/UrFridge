<?php

namespace App\DataFixtures;

use App\Factory\InventoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class InventoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    }
}
