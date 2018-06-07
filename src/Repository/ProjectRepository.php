<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }


    /**
     * @param bool $notify
     * @param bool|null $enabled
     * @param string $sort
     * @param int $page
     * @param int|null $max
     * @return Project[] Returns an array of Project objects
     */
    public function getProjects(?bool $notify = true, ?bool $enabled = true, ?string $sort = 'ASC', ?int $page = 0, ?int $max = null)
    {
        // Faudra exclure les private
        $req = $this->createQueryBuilder('p')
            ->join('p.instances', 'i')
            ->where('p.enabledNotification = :notify')
            ->andWhere('i.enabled = :enabled')
            ->setParameter('notify', $notify)
            ->setParameter('enabled', $enabled)
            ->orderBy('p.position', in_array(strtoupper($sort), ['ASC', 'DESC']) ? $sort : 'ASC');
        if ($max) {
            $req = $req->getQuery()
                ->setMaxResults($max)
                ->setFirstResult($page * $max);
        } else {
            $req = $req->getQuery();
        }

        return $req->getResult();
    }

}
