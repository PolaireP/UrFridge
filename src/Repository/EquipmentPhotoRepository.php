<?php

namespace App\Repository;

use App\Entity\EquipmentPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EquipmentPhoto>
 *
 * @method EquipmentPhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipmentPhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipmentPhoto[]    findAll()
 * @method EquipmentPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentPhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipmentPhoto::class);
    }

//    /**
//     * @return EquipmentPhoto[] Returns an array of EquipmentPhoto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EquipmentPhoto
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
