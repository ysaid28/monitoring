<?php

namespace App\Repository;

use App\Entity\OtherInstance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OtherInstance|null find($id, $lockMode = null, $lockVersion = null)
 * @method OtherInstance|null findOneBy(array $criteria, array $orderBy = null)
 * @method OtherInstance[]    findAll()
 * @method OtherInstance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OtherInstanceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OtherInstance::class);
    }

//    /**
//     * @return OtherInstance[] Returns an array of OtherInstance objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OtherInstance
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
