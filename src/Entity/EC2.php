<?php

namespace App\Entity;

use App\Entity\Traits\AwsEntity;
use App\Model\EC2Interface;
use App\Model\Enum\InstanceType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EC2Repository")
 * @ORM\Table(name="ec2")
 */
class EC2 extends Instance implements EC2Interface
{
    use AwsEntity;

    /**
     * @var string
     *
     * @ORM\Column(name="image_id", type="string", length=255, nullable=true)
     */
    private $imageId;

    /**
     * @var string
     *
     * @ORM\Column(name="instance_type", type="string", length=255, nullable=true)
     */
    private $instanceType;
    /**
     * @var string
     *
     * @ORM\Column(name="key_name", type="string", length=255, nullable=true)
     */
    private $keyName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="launch_time", type="date", nullable=true)
     */
    private $launchTime;

    /**
     * @var string
     *
     * @ORM\Column(name="public_ip_address", type="string", length=255, nullable=true)
     */
    private $publicIpAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="public_dns_name", type="string", length=255, nullable=true)
     */
    private $publicDnsName;

    /**
     * @var string
     *
     * @ORM\Column(name="private_ip_address", type="string", length=255, nullable=true)
     */
    private $privateIpAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="private_dns_name", type="string", length=255, nullable=true)
     */
    private $privateDnsName;

    /**
     * @var string
     *
     * @ORM\Column(name="state_transition_reason", type="string", length=255, nullable=true)
     */
    private $stateTransitionReason;

    /**
     * @var string
     *
     * @ORM\Column(name="architecture", type="string", length=255, nullable=true)
     */
    private $architecture;
    /**
     * @var string
     *
     * @ORM\Column(name="client_token", type="string", length=255, nullable=true)
     */
    private $clientToken;

    /**
     * @var bool
     *
     * @ORM\Column(name="ebs_optimized", type="boolean", nullable=true)
     */
    private $ebsOptimized;

    /**
     * @var bool
     *
     * @ORM\Column(name="ena_support", type="boolean", nullable=true)
     */
    private $enaSupport;

    /**
     * @var string
     *
     * @ORM\Column(name="hypervisor", type="string", length=255, nullable=true)
     */
    private $hypervisor;

    /**
     * @var bool
     *
     * @ORM\Column(name="source_dest_check", type="boolean", nullable=true)
     */
    private $sourceDestCheck;

    /**
     * @var string
     *
     * @ORM\Column(name="virtualization_type", type="string", length=255, nullable=true)
     */
    private $virtualizationType;

    /**
     * @var array
     *
     * @ORM\Column(name="cpu_options", type="array", nullable=true)
     */
    private $cpuOptions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VPC", inversedBy="ec2s")
     *
     */
    private $vpc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subnet", inversedBy="ec2s")
     *
     */
    private $subnet;

    /**
     * EC2 constructor.
     */
    public function __construct()
    {
        parent::__construct(InstanceType::EC2);
    }

    /**
     * @return string
     */
    public function getImageId(): ?string
    {
        return $this->imageId;
    }

    /**
     * @param string $imageId
     */
    public function setImageId(?string $imageId): void
    {
        $this->imageId = $imageId;
    }

    /**
     * @return string
     */
    public function getInstanceType(): ?string
    {
        return $this->instanceType;
    }

    /**
     * @param string $instanceType
     */
    public function setInstanceType(?string $instanceType): void
    {
        $this->instanceType = $instanceType;
    }

    /**
     * @return string
     */
    public function getKeyName(): ?string
    {
        return $this->keyName;
    }

    /**
     * @param string $keyName
     */
    public function setKeyName(?string $keyName): void
    {
        $this->keyName = $keyName;
    }

    /**
     * @return \DateTime
     */
    public function getLaunchTime(): ?\DateTime
    {
        return $this->launchTime;
    }

    /**
     * @param \DateTime $launchTime
     */
    public function setLaunchTime(?\DateTime $launchTime): void
    {
        $this->launchTime = $launchTime;
    }

    /**
     * @return string
     */
    public function getPublicDnsName(): ?string
    {
        return $this->publicDnsName;
    }

    /**
     * @param string $publicDnsName
     */
    public function setPublicDnsName(?string $publicDnsName): void
    {
        $this->publicDnsName = $publicDnsName;
    }

    /**
     * @return string
     */
    public function getPrivateIpAddress(): ?string
    {
        return $this->privateIpAddress;
    }

    /**
     * @param string $privateIpAddress
     */
    public function setPrivateIpAddress(?string $privateIpAddress): void
    {
        if (!empty($privateIpAddress)) {
            $this->setPrivateId($privateIpAddress);
        }
        $this->privateIpAddress = $privateIpAddress;
    }

    /**
     * @return string
     */
    public function getPrivateDnsName(): ?string
    {
        return $this->privateDnsName;
    }

    /**
     * @param string $privateDnsName
     */
    public function setPrivateDnsName(?string $privateDnsName): void
    {
        $this->privateDnsName = $privateDnsName;
    }

    /**
     * @return string
     */
    public function getStateTransitionReason(): ?string
    {
        return $this->stateTransitionReason;
    }

    /**
     * @param string $stateTransitionReason
     */
    public function setStateTransitionReason(?string $stateTransitionReason): void
    {
        $this->stateTransitionReason = $stateTransitionReason;
    }

    /**
     * @return string
     */
    public function getArchitecture(): ?string
    {
        return $this->architecture;
    }

    /**
     * @param string $architecture
     */
    public function setArchitecture(?string $architecture): void
    {
        $this->architecture = $architecture;
    }

    /**
     * @return string
     */
    public function getClientToken(): ?string
    {
        return $this->clientToken;
    }

    /**
     * @param string $clientToken
     */
    public function setClientToken(?string $clientToken): void
    {
        $this->clientToken = $clientToken;
    }

    /**
     * @return bool
     */
    public function isEbsOptimized(): bool
    {
        return $this->ebsOptimized;
    }

    /**
     * @param bool $ebsOptimized
     */
    public function setEbsOptimized(?bool $ebsOptimized): void
    {
        $this->ebsOptimized = $ebsOptimized;
    }

    /**
     * @return bool
     */
    public function isEnaSupport(): bool
    {
        return $this->enaSupport;
    }

    /**
     * @param bool $enaSupport
     */
    public function setEnaSupport(?bool $enaSupport): void
    {
        $this->enaSupport = $enaSupport;
    }

    /**
     * @return string
     */
    public function getHypervisor(): ?string
    {
        return $this->hypervisor;
    }

    /**
     * @param string $hypervisor
     */
    public function setHypervisor(?string $hypervisor): void
    {
        $this->hypervisor = $hypervisor;
    }

    /**
     * @return bool
     */
    public function isSourceDestCheck(): bool
    {
        return $this->sourceDestCheck;
    }

    /**
     * @param bool $sourceDestCheck
     */
    public function setSourceDestCheck(?bool $sourceDestCheck): void
    {
        $this->sourceDestCheck = $sourceDestCheck;
    }

    /**
     * @return string
     */
    public function getVirtualizationType(): ?string
    {
        return $this->virtualizationType;
    }

    /**
     * @param string $virtualizationType
     */
    public function setVirtualizationType(?string $virtualizationType): void
    {
        $this->virtualizationType = $virtualizationType;
    }

    /**
     * @return array
     */
    public function getCpuOptions(): array
    {
        return $this->cpuOptions;
    }

    /**
     * @param array $cpuOptions
     */
    public function setCpuOptions(?array $cpuOptions): void
    {
        $this->cpuOptions = $cpuOptions;
    }

    /**
     * @return VPC
     */
    public function getVpc(): ?VPC
    {
        return $this->vpc;
    }

    /**
     * @param VPC $vpc
     */
    public function setVpc(?VPC $vpc): void
    {
        $this->vpc = $vpc;
    }


    /**
     * @return Subnet|null
     */
    public function getSubnet(): ?Subnet
    {
        return $this->subnet;
    }


    /**
     * @param Subnet $subnet
     */
    public function setSubnet(Subnet $subnet): void
    {
        $this->subnet = $subnet;
    }

    /**
     * @return string
     */
    public function getPublicIpAddress(): ?string
    {
        return $this->publicIpAddress;
    }

    /**
     * @param string $publicIpAddress
     */
    public function setPublicIpAddress(?string $publicIpAddress): void
    {
        if (!empty($publicIpAddressà)) {
            $this->setPublicId($publicIpAddress);
        }
        $this->publicIpAddress = $publicIpAddress;
    }
}
