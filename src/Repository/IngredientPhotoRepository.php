<?php

namespace App\Repository;

use App\Entity\IngredientPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IngredientPhoto>
 *
 * @method IngredientPhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientPhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientPhoto[]    findAll()
 * @method IngredientPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientPhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientPhoto::class);
    }

//    /**
//     * @return IngredientPhoto[] Returns an array of IngredientPhoto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?IngredientPhoto
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
