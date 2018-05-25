<?php

namespace App\Entity\Traits;

use App\Model\Enum\StateType;
use Doctrine\ORM\Mapping as ORM;

/**
 * Info AWS .
 */
trait AwsEntity
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $arn;
    
    /**
     * @return null|string
     */
    public function getArn(): ?string
    {
        return $this->arn;
    }

    /**
     * @param null|string $arn
     */
    public function setArn(?string $arn)
    {
        $this->arn = $arn;
    }
}
