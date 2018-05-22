<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sortable Item.
 */
trait SortableEntity
{
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int|null $position
     * @return SortableEntity
     */
    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
