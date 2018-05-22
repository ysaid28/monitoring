<?php

namespace App\Model;

interface State {
    
     /**
     * @return int|null
     */
    public function getState(): ?int;

    /**
     * @param int|null $state
     * @return State
     */
    public function setState(?int $state);
}
