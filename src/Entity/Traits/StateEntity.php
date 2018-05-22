<?php

namespace App\Entity\Traits;

use App\Model\Enum\StateType;
use Doctrine\ORM\Mapping as ORM;

/**
 * State Item.
 */
trait StateEntity
{
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $state;

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        if (!StateType::isValid($state) && $state) {
            throw new \UnexpectedValueException("Value '$state' is not a valid Content Type");
        }
        $this->state = $state;
    }

    /**
     * @return int|null
     */
    public function getState(): ?integer
    {
        return $this->state;
    }
}
