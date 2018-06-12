<?php

namespace App\Entity\Traits;

use App\Model\Enum\InstanceState;
use App\Model\Enum\Notify;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notify Item.
 */
trait NotificationEntity
{
    /**
     * @ORM\Column(type="boolean", name="enable_notification", nullable=true)
     */
    protected $enabledNotification = true;


    /**
     * @ORM\Column(type="datetime", name="date_notification", nullable=true)
     */
    protected $dateNotification ;


    /**
     * @return bool
     */
    public function isNotified(): ?bool
    {
        return $this->enabledNotification;
    }

    /**
     * @param mixed $enable
     */
    public function setEnabledNotification(?bool $enable): void
    {
        $this->enabledNotification = $enable;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateNotification(): ?\DateTime
    {
        return $this->dateNotification;
    }

    /**
     * @param \DateTime $dateNotification
     */
    public function setDateNotification(?\DateTime $dateNotification): void
    {
        $this->dateNotification = $dateNotification;
    }

}
