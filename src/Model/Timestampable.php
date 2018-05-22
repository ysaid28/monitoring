<?php

namespace App\Model;

/**
 * This interface is not necessary but can be implemented for classes
 * which in some cases needs to be identified as "timestampable".
 */
interface Timestampable
{
    /**
     * Returns date when object was created.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Sets the creation date.
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Returns date when object was last updated.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt();

    /**
     * Sets date when object was last updated.
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);
}
