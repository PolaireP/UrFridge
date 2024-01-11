<?php

namespace App\Repository;

use App\Entity\Recipe;
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

    public function getRecipeFromCriterias(string $text = '',
        array $ingredientsId = null,
        array $allergensId = null,
        array $categoriesId = null,
        array $filters = null): array
    {
        $qb = $this->createQueryBuilder('r');
        $qb->where($qb->expr()->eq('r.verified', 1))
            ->addSelect('rp.recipePhoto')
            ->leftJoin('App\Entity\RecipePhoto', 'rp', 'WITH', 'r.recipePhoto = rp.id')
            ->andWhere('r.recipeName LIKE :text')
            ->setParameter('text', '%'.$text.'%');

        if (!empty($ingredientsId)) {
            $qb->join('r.ingredients', 'ir')
                ->andWhere($qb->expr()->in('ir.id', $ingredientsId))
                ->having($qb->expr()->eq(
                    $qb->expr()->countDistinct('ir.id'),
                    count($ingredientsId)
                ));
        }

        if (!empty($allergensId)) {
            $qb->andWhere($qb->expr()->not($qb->expr()->exists(
                $this->_em->createQueryBuilder()
                    ->select('1')
                    ->from('App:Ingredient', 'i')
                    ->join('i.allergens', 'ai')
                    ->where('i MEMBER OF r.ingredients')
                    ->andWhere($qb->expr()->in('ai.id', $allergensId))
                    ->getDQL()
            )));
        }

        if (!empty($categoriesId)) {
            $qb->join('r.categories', 'cr')
                ->andWhere($qb->expr()->in('cr.id', $categoriesId))
                ->having($qb->expr()->eq(
                    $qb->expr()->countDistinct('cr.id'),
                    count($categoriesId)
                ));
        }

        $qb->groupBy('r.id', 'r.recipeName');

        return $qb->getQuery()->getResult();
    }
}
