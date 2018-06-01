<?php

namespace App\Model;

interface State
{

    /**
     * @return int|string
     */
    public function getState(): ?string ;

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void;
}
