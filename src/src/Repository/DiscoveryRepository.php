<?php

namespace App\Repository;

use App\Entity\Discovery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Discovery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discovery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discovery[]    findAll()
 * @method Discovery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscoveryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discovery::class);
    }

    // /**
    //  * @return Discovery[] Returns an array of Discovery objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Discovery
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
