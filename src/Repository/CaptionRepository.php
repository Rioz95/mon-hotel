<?php

namespace App\Repository;

use App\Entity\Caption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Caption>
 *
 * @method Caption|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caption|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caption[]    findAll()
 * @method Caption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caption::class);
    }

//    /**
//     * @return Caption[] Returns an array of Caption objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Caption
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
