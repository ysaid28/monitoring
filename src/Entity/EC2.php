<?php

namespace App\Entity;

use App\Entity\Traits\AwsEntity;
use App\Model\EC2Interface;
use App\Model\Enum\InstanceType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EC2Repository")
 * @ORM\Table(name="ec2")
 */
class EC2 extends Instance implements EC2Interface
{
    use AwsEntity;
    
    /**
     * EC2 constructor.
     */
    public function __construct()
    {
        parent::__construct(InstanceType::EC2);
    }
    
}
