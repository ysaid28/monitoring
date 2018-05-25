<?php

namespace App\Repository;

use App\Entity\EC2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EC2|null find($id, $lockMode = null, $lockVersion = null)
 * @method EC2|null findOneBy(array $criteria, array $orderBy = null)
 * @method EC2[]    findAll()
 * @method EC2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EC2Repository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EC2::class);
    }

//    /**
//     * @return EC2[] Returns an array of EC2 objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EC2
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
