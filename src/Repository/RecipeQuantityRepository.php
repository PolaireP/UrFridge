<?php

namespace App\Repository;

use App\Entity\RecipeQuantity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeQuantity>
 *
 * @method RecipeQuantity|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeQuantity|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeQuantity[]    findAll()
 * @method RecipeQuantity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeQuantityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeQuantity::class);
    }

    public function getIngredientQuantitiesForRecipe($recipeId)
    {
        $qb = $this->createQueryBuilder('rq')
            ->select('IDENTITY(rq.ingredient) as ingredientId', 'rq.quantity')
            ->where('rq.recipe = :recipeId')
            ->setParameter('recipeId', $recipeId);

        $result = $qb->getQuery()->getArrayResult();

        $quantities = [];
        foreach ($result as $row) {
            $quantities[$row['ingredientId']] = $row['quantity'];
        }

        return $quantities;
    }

}
