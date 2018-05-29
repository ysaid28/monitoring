<?php

namespace App\Entity\Traits;

use App\Model\Enum\InstanceState;
use App\Model\Enum\Notify;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notify Item.
 */
trait NotifyEntity
{
    /**
     * @ORM\Column(type="boolean", name="enable", nullable=true)
     */
    private $enable = true;

    /**
     * @return bool
     */
    public function getEnable(): bool
    {
        return $this->enable;
    }

    /**
     * @param mixed $enable
     */
    public function setEnable($enable): void
    {
        $this->enable = $enable;
    }
    
}
