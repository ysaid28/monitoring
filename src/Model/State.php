<?php

namespace App\Model;

interface State
{

    /**
     * @return int|null
     */
    public function getState(): ?int;

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void;
}
