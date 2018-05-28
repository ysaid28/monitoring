<?php

namespace App\Entity;

use App\Model\Enum\InstanceType;
use App\Model\OtherInstanceInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OtherInstanceRepository")
 * @ORM\Table(name="other_instance")
 */
class OtherInstance extends Instance implements OtherInstanceInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="customer", type="string", length=255, nullable=true)
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="licence", type="string", length=255, nullable=true)
     */
    private $licence;

    /**
     * @var string
     *
     * @ORM\Column(name="sso", type="string", length=255, nullable=true)
     */
    private $sso;

    /**
     * @var string
     *
     * @ORM\Column(name="enabled_webservice", type="boolean",  nullable=true)
     */
    private $enabledWebservice = false;

    /**
     * @var string
     *
     * @ORM\Column(name="enabled_provision", type="boolean",  nullable=true)
     */
    private $enabledProvision = false;


    /**
     * @var string
     *
     * @ORM\Column(name="custom", type="string", nullable=true)
     */
    private $custom;

    /**
     * @var string
     *
     * @ORM\Column(name="major_production_version", type="string", length=20, nullable=true)
     */
    private $majorProductionVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="major_staging_version", type="string", length=20, nullable=true)
     */
    private $majorStagingVersion;


    /**
     * RDS constructor.
     */
    public function __construct()
    {
        parent::__construct(InstanceType::OTHER);
    }

    /**
     * @return null|string
     */
    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    /**
     * @param null|string $customer
     * @return OtherInstance
     */
    public function setCustomer(?string $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLicence(): ?string
    {
        return $this->licence;
    }

    /**
     * @param null|string $licence
     * @return OtherInstance
     */
    public function setLicence(?string $licence): self
    {
        $this->licence = $licence;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSso(): ?string
    {
        return $this->sso;
    }

    /**
     * @param null|string $sso
     * @return OtherInstance
     */
    public function setSso(?string $sso): self
    {
        $this->sso = $sso;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getEnabledWebservice(): ?bool
    {
        return $this->enabledWebservice;
    }

    /**
     * @param bool|null $enabledWebservice
     * @return OtherInstance
     */
    public function setEnabledWebservice(?bool $enabledWebservice): self
    {
        $this->enabledWebservice = $enabledWebservice;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getEnabledProvision(): ?bool
    {
        return $this->enabledProvision;
    }

    /**
     * @param bool|null $enabledProvision
     * @return OtherInstance
     */
    public function setEnabledProvision(?bool $enabledProvision): self
    {
        $this->enabledProvision = $enabledProvision;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCustom(): ?string
    {
        return $this->custom;
    }

    /**
     * @param null|string $custom
     * @return OtherInstance
     */
    public function setCustom(?string $custom): self
    {
        $this->custom = $custom;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMajorProductionVersion(): ?string
    {
        return $this->majorProductionVersion;
    }

    /**
     * @param null|string $majorProductionVersion
     * @return OtherInstance
     */
    public function setMajorProductionVersion(?string $majorProductionVersion): self
    {
        $this->majorProductionVersion = $majorProductionVersion;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMajorStagingVersion(): ?string
    {
        return $this->majorStagingVersion;
    }

    /**
     * @param null|string $majorStagingVersion
     * @return OtherInstance
     */
    public function setMajorStagingVersion(?string $majorStagingVersion): self
    {
        $this->majorStagingVersion = $majorStagingVersion;

        return $this;
    }
}
