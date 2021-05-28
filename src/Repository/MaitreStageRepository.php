<?php

namespace App\Repository;

use App\Entity\MaitreStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaitreStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaitreStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaitreStage[]    findAll()
 * @method MaitreStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaitreStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaitreStage::class);
    }

    // /**
    //  * @return MaitreStage[] Returns an array of MaitreStage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MaitreStage
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
