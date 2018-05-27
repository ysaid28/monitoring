<?php

namespace App\Repository;

use App\Entity\VPC;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VPC|null find($id, $lockMode = null, $lockVersion = null)
 * @method VPC|null findOneBy(array $criteria, array $orderBy = null)
 * @method VPC[]    findAll()
 * @method VPC[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VPCRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VPC::class);
    }

//    /**
//     * @return VPC[] Returns an array of VPC objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VPC
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
