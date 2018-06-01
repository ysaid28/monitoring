<?php

namespace App\Entity\Traits;

use App\Model\Enum\InstanceState;
use Doctrine\ORM\Mapping as ORM;

/**
 * Info AWS .
 */
trait AwsEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="instance_id", type="string", length=255)
     */
    protected $instanceId;
    
    /**
     * @return string
     */
    public function getInstanceId(): ?string
    {
        return $this->instanceId;
    }

    /**
     * @param string $instanceId
     */
    public function setInstanceId(?string $instanceId): void
    {
        $this->instanceId = $instanceId;
    }
}
