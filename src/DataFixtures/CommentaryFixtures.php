<?php

namespace App\DataFixtures;

use App\Factory\CommentaryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class CommentaryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CommentaryFactory::createMany(10);
    }
}
