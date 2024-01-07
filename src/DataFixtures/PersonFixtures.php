<?php

namespace App\DataFixtures;

use App\Factory\PersonFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        PersonFactory::createSequence(
            [
                'email' => 'root@example.com',
                'firstname' => 'Tony',
                'lastname' => 'Stark',
                'roles' => ['ROLE_ADMIN'],
            ]
        );

        PersonFactory::createSequence([
            [
                'email' => 'user@example.com',
                'firstname' => 'Peter',
                'lastname' => 'Parker',
                'roles' => ['ROLE_USER'],
            ],
        ]);

        PersonFactory::createMany(10);

        $manager->flush();
    }
}
