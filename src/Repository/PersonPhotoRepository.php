<?php

namespace App\Repository;

use App\Entity\PersonPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonPhoto>
 *
 * @method PersonPhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonPhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonPhoto[]    findAll()
 * @method PersonPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonPhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonPhoto::class);
    }

//    /**
//     * @return PersonPhoto[] Returns an array of PersonPhoto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PersonPhoto
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
