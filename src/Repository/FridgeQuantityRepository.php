<?php

namespace App\Repository;

use App\Entity\FridgeQuantity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FridgeQuantity>
 *
 * @method FridgeQuantity|null find($id, $lockMode = null, $lockVersion = null)
 * @method FridgeQuantity|null findOneBy(array $criteria, array $orderBy = null)
 * @method FridgeQuantity[]    findAll()
 * @method FridgeQuantity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FridgeQuantityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FridgeQuantity::class);
    }

    //    /**
    //     * @return FridgeQuantity[] Returns an array of FridgeQuantity objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FridgeQuantity
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
