<?php

namespace App\Repository;

use App\Entity\MaterialFiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MaterialFiles>
 *
 * @method MaterialFiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialFiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialFiles[]    findAll()
 * @method MaterialFiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialFilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialFiles::class);
    }

//    /**
//     * @return MaterialFiles[] Returns an array of MaterialFiles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MaterialFiles
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
