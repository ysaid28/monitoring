<?php

namespace App\Model;

interface Sortable
{
    /**
     * @return int|null
     */
    public function getPosition(): ?int;

    /**
     * @param int|null $position
     * @return Sortable
     */
    public function setPosition(?int $position): self;
}
