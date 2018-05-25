<?php

namespace App\Entity;

use App\Entity\Traits\AwsEntity;
use App\Model\Enum\InstanceType;
use App\Model\RDSInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RDSRepository")
 * @ORM\Table(name="rds")
 */
class RDS extends Instance implements RDSInterface
{
    use AwsEntity;

    /**
     * RDS constructor.
     */
    public function __construct()
    {
        parent::__construct(InstanceType::RDS);
    }
}
