<?php

namespace App\Entity\Traits;

use App\Model\Enum\InstanceState;
use Doctrine\ORM\Mapping as ORM;

/**
 * State Item.
 */
trait StateEntity
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $state;

    /**
     * @param mixed $state
     */
    public function setState(?string $state): void
    {
        if (!InstanceState::isValid($state) && $state) {
            throw new \UnexpectedValueException("Value '$state' is not a valid Content Type");
        }
        $this->state = $state;
    }

    /**
     * @return int|null
     */
    public function getState(): ?int
    {
        return $this->state;
    }
}
