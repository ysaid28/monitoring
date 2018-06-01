<?php

namespace App\Model;

interface Notify
{

    /**
     * @return int| bool
     */
    public function isEnableNotify(): ?bool;

    /**
     * @param bool|null $enable
     */
    public function setEnableNotify(?bool $enable): void;
}
