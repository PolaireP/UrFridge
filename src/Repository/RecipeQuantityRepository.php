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

//    /**
//     * @return RecipeQuantity[] Returns an array of RecipeQuantity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecipeQuantity
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
