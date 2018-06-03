<?php

namespace App\Model;

interface Enabled
{

    /**
     * @return bool|null
     */
    public function isEnabled(): ?bool;

    /**
     * @param bool|null $enabled
     */
    public function setEnabled(? bool $enabled): void;
}
