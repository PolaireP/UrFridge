<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Entity\RecipePhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function search(string $text = ''): array
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.recipeName LIKE :text')
            ->setParameter('text', '%'.$text.'%')
            ->orderBy('r.recipeName', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();
    }

    public function countStepsForRecipe(int $recipeId): int
    {
        $qb = $this->createQueryBuilder('r')
            ->select('count(s.id)')
            ->join('r.steps', 's')
            ->where('r.id = :recipeId')
            ->setParameter('recipeId', $recipeId);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function getAllergensForRecipe(int $recipeId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT a
        FROM App\Entity\Allergen a
        INNER JOIN a.ingredients i
        INNER JOIN i.recipes r
        WHERE r.id = :recipeId'
        )->setParameter('recipeId', $recipeId);

        return $query->getResult();
    }

    public function findPersonFavoriteRecipes(int $id, string $search) {

        $qb = $this->createQueryBuilder('r')
            ->addSelect('rcp.recipePhoto')
            ->leftJoin('App\Entity\RecipePhoto', 'rcp', 'WITH', 'rcp.id = r.recipePhoto')
            ->where($this->createQueryBuilder('recipe')->expr()->eq('r.author', $id));

        if ($search !== '') {
            $qb->andWhere('r.recipeName LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }

        return $qb->groupBy('r.id', 'r.recipeName')->getQuery()->getResult();
    }
}
