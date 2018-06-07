<?php

namespace App\Model;

interface Notification
{

    /**
     * @return int| bool
     */
    public function isNotified(): ?bool;

    /**
     * @param bool|null $enable
     */
    public function setEnabledNotification(?bool $enable): void;

    /**
     * @return \DateTime|null
     */
    public function getDateNotification(): ?\DateTime;

    /**
     * @param \DateTime $dateNotification
     */
    public function setDateNotification(?\DateTime $dateNotification): void;
}
