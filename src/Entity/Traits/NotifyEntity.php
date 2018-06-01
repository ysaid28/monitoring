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
     * @ORM\Column(type="boolean", name="enable_notify", nullable=true)
     */
    protected $enableNotify = true;

    /**
     * @return bool
     */
    public function isEnableNotify(): ?bool
    {
        return $this->enableNotify;
    }

    /**
     * @param mixed $enable
     */
    public function setEnableNotify(?bool $enable): void
    {
        $this->enableNotify = $enable;
    }
    
}
