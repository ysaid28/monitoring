<?php

namespace App\Entity\Traits;

use App\Model\Enum\InstanceState;
use Doctrine\ORM\Mapping as ORM;

/**
 * State Item.
 */
trait EnabledEntity
{
    /**
     * @ORM\Column(type="boolean", name="enabled", nullable=true)
     */
    protected $enabled = true;

    /**
     * @return bool|null
     */
    public function isEnabled(): ?bool 
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled(? bool$enabled): void
    {
        $this->enabled = $enabled;
    }


}
