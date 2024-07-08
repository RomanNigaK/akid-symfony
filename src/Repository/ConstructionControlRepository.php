<?php

namespace App\Repository;

use App\Entity\ConstructionControl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConstructionControl>
 *
 * @method ConstructionControl|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConstructionControl|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConstructionControl[]    findAll()
 * @method ConstructionControl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstructionControlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConstructionControl::class);
    }

//    /**
//     * @return ConstructionControl[] Returns an array of ConstructionControl objects
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

//    public function findOneBySomeField($value): ?ConstructionControl
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
