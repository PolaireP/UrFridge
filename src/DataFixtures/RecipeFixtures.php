<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Factory\EquipmentFactory;
use App\Factory\RecipeFactory;
use App\Factory\RecipePhotoFactory;
use App\Repository\EquipmentRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Chargement des données
        $data = json_decode(file_get_contents(__DIR__.'/data/Recipe.json'), true);
        $equipments = json_decode(file_get_contents(__DIR__.'/data/recipeEquipment.json'), true);
        $photoId = RecipePhotoFactory::first()->getId();

        // Opération sur les données (recherche des RecipePhoto et ajout )
        foreach ($data as $key => $element) {
            $data[$key]['recipePhoto'] = RecipePhotoFactory::findBy(['id' => $photoId + $data[$key]['recipePhoto']])[0];
        }

        // Création de la séquence
        RecipeFactory::createSequence($data);
        $firstRecipe = RecipeFactory::first()->getId();
        $firstEquipment = EquipmentFactory::first()->getId() - 1;

        // Ajout des collections



        foreach ($equipments as $element) {

            $equipment = $manager->getRepository(Equipment::class)
                ->findOneBy(['id' => $firstEquipment + $element['equipmentId']]);
            RecipeFactory::findBy(['id' => $element['recipeId'] + $firstRecipe])[0]
                ->addEquipment($equipment);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RecipePhotoFixtures::class,
            EquipmentFixtures::class,
            IngredientFixtures::class,
        ];
    }
}
