<?php

namespace App\Repository;

use App\Entity\RDS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RDS|null find($id, $lockMode = null, $lockVersion = null)
 * @method RDS|null findOneBy(array $criteria, array $orderBy = null)
 * @method RDS[]    findAll()
 * @method RDS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RDSRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RDS::class);
    }

//    /**
//     * @return RDS[] Returns an array of RDS objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RDS
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
