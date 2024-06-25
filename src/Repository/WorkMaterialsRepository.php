<?php

namespace App\Repository;

use App\Entity\WorkMaterials;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkMaterials>
 *
 * @method WorkMaterials|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkMaterials|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkMaterials[]    findAll()
 * @method WorkMaterials[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkMaterialsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkMaterials::class);
    }

//    /**
//     * @return WorkMaterials[] Returns an array of WorkMaterials objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WorkMaterials
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
