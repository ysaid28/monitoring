<?php

namespace App\Repository;

use App\Entity\Instance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Instance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Instance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Instance[]    findAll()
 * @method Instance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstanceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Instance::class);
    }

    /**
     * @param bool $ssl
     * @param bool|null $enabled
     * @param null|string $sort
     * @param int|null $page
     * @param int|null $max
     * @return Instance[] Returns an array of Instance objects
     */
    public function getInstanceWithCertificate(bool $ssl = true, ?bool $enabled = true, ?string $sort = 'ASC', ?int $page = 0, ?int $max = null): ?array
    {
        $req = $this->createQueryBuilder('i')
            ->andWhere('i.enabledSSL = :ssl')
            ->andWhere('i.hostName IS NOT NULL')
            ->setParameter('ssl', $ssl)
            ->andWhere('i.enabled = :enabled')
            ->setParameter('enabled', $enabled)
            ->orderBy('i.certificateEndDate', in_array(strtoupper($sort), ['ASC', 'DESC']) ? $sort : 'ASC');

        if ($max) {
            $req = $req->getQuery()
                ->setMaxResults($max)
                ->setFirstResult($page * $max);
        } else {
            $req = $req->getQuery();
        }

        return $req->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Instance
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
