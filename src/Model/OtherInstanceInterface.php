<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanns
 * Date: 26/05/2018
 * Time: 00:39
 */

namespace App\Model;


use App\Entity\OtherInstance;

interface OtherInstanceInterface
{
    /**
     * @return null|string
     */
    public function getCustomer(): ?string;

    /**
     * @param null|string $customer
     * @return OtherInstance
     */
    public function setCustomer(?string $customer): OtherInstance;

    /**
     * @return null|string
     */
    public function getLicence(): ?string;

    /**
     * @param null|string $licence
     * @return OtherInstance
     */
    public function setLicence(?string $licence): OtherInstance;

    /**
     * @return null|string
     */
    public function getSso(): ?string;

    /**
     * @param null|string $sso
     * @return OtherInstance
     */
    public function setSso(?string $sso): OtherInstance;

    /**
     * @return bool|null
     */
    public function getEnabledWebservice(): ?bool;

    /**
     * @param bool|null $enabledWebservice
     * @return OtherInstance
     */
    public function setEnabledWebservice(?bool $enabledWebservice): OtherInstance;

    /**
     * @return bool|null
     */
    public function getEnabledProvision(): ?bool;

    /**
     * @param bool|null $enabledProvision
     * @return OtherInstance
     */
    public function setEnabledProvision(?bool $enabledProvision): OtherInstance;

    /**
     * @return null|string
     */
    public function getCustom(): ?string;

    /**
     * @param null|string $custom
     * @return OtherInstance
     */
    public function setCustom(?string $custom): OtherInstance;

    /**
     * @return null|string
     */
    public function getMajorProductionVersion(): ?string;

    /**
     * @param null|string $majorProductionVersion
     * @return OtherInstance
     */
    public function setMajorProductionVersion(?string $majorProductionVersion): OtherInstance;
    
    
    /**
     * @return null|string
     */
    public function getMajorStagingVersion(): ?string;
    
        /**
     * @param null|string $majorStagingVersion
     * @return OtherInstance
     */
    public function setMajorStagingVersion(?string $majorStagingVersion): OtherInstance;

}