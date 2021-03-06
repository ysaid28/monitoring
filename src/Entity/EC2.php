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
    protected $imageId;

    /**
     * @var string
     *
     * @ORM\Column(name="instance_type", type="string", length=255, nullable=true)
     */
    protected $instanceType;
    /**
     * @var string
     *
     * @ORM\Column(name="key_name", type="string", length=255, nullable=true)
     */
    protected $keyName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="launch_time", type="datetime", nullable=true)
     */
    protected $launchTime;

    /**
     * @var string
     *
     * @ORM\Column(name="public_ip_address", type="string", length=255, nullable=true)
     */
    protected $publicIpAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="public_dns_name", type="string", length=255, nullable=true)
     */
    protected $publicDnsName;

    /**
     * @var string
     *
     * @ORM\Column(name="private_ip_address", type="string", length=255, nullable=true)
     */
    protected $privateIpAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="private_dns_name", type="string", length=255, nullable=true)
     */
    protected $privateDnsName;

    /**
     * @var string
     *
     * @ORM\Column(name="state_transition_reason", type="string", length=255, nullable=true)
     */
    protected $stateTransitionReason;

    /**
     * @var string
     *
     * @ORM\Column(name="architecture", type="string", length=255, nullable=true)
     */
    protected $architecture;
    /**
     * @var string
     *
     * @ORM\Column(name="client_token", type="string", length=255, nullable=true)
     */
    protected $clientToken;

    /**
     * @var bool
     *
     * @ORM\Column(name="ebs_optimized", type="boolean", nullable=true)
     */
    protected $ebsOptimized;

    /**
     * @var bool
     *
     * @ORM\Column(name="ena_support", type="boolean", nullable=true)
     */
    protected $enaSupport;

    /**
     * @var string
     *
     * @ORM\Column(name="hypervisor", type="string", length=255, nullable=true)
     */
    protected $hypervisor;

    /**
     * @var bool
     *
     * @ORM\Column(name="source_dest_check", type="boolean", nullable=true)
     */
    protected $sourceDestCheck;

    /**
     * @var string
     *
     * @ORM\Column(name="virtualization_type", type="string", length=255, nullable=true)
     */
    protected $virtualizationType;

    /**
     * @var array
     *
     * @ORM\Column(name="cpu_options", type="array", nullable=true)
     */
    protected $cpuOptions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VPC", inversedBy="ec2s")
     *
     */
    protected $vpc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subnet", inversedBy="ec2s")
     *
     */
    protected $subnet;

    /**
     * EC2 constructor.
     */
    public function __construct()
    {
        parent::__construct(InstanceType::EC2);
    }

    /**
     * @return null|string
     */
    public function getImageId(): ?string
    {
        return $this->imageId;
    }

    /**
     * @param null|string $imageId
     */
    public function setImageId(?string $imageId): void
    {
        $this->imageId = $imageId;
    }

    /**
     * @return null|string
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
     * @return null|string
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
     * @param \DateTime|null $launchTime
     */
    public function setLaunchTime(?\DateTime $launchTime): void
    {
        $this->launchTime = $launchTime;
    }

    /**
     * @return null|string
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
     * @return null|string
     */
    public function getPrivateIpAddress(): ?string
    {
        return $this->privateIpAddress;
    }

    /**
     * @param null|string $privateIpAddress
     */
    public function setPrivateIpAddress(?string $privateIpAddress): void
    {
        if (!empty($privateIpAddress)) {
            $this->setPrivateId($privateIpAddress);
        }
        $this->privateIpAddress = $privateIpAddress;
    }

    /**
     * @return null|string
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
     * @return null|string
     */
    public function getStateTransitionReason(): ?string
    {
        return $this->stateTransitionReason;
    }

    /**
     * @param null|string $stateTransitionReason
     */
    public function setStateTransitionReason(?string $stateTransitionReason): void
    {
        $this->stateTransitionReason = $stateTransitionReason;
    }
    
    /**
     * @return null|string
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
     * @return null|string
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
     * @return null| bool
     */
    public function isEbsOptimized(): ?bool
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
     * @return null| bool
     */
    public function isEnaSupport(): ?bool
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
     * @return null|string
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
     * @return bool|null
     */
    public function isSourceDestCheck(): ?bool
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
     * @param string null|$virtualizationType
     */
    public function setVirtualizationType(?string $virtualizationType): void
    {
        $this->virtualizationType = $virtualizationType;
    }

    /**
     * @return null|array
     */
    public function getCpuOptions(): ?array
    {
        return $this->cpuOptions;
    }


    /**
     * @param array|null $cpuOptions
     */
    public function setCpuOptions(?array $cpuOptions): void
    {
        $this->cpuOptions = $cpuOptions;
    }
    
    /**
     * @return VPC|null
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
     * @return null|string
     */
    public function getPublicIpAddress(): ?string
    {
        return $this->publicIpAddress;
    }

    /**
     * @param null|string $publicIpAddress
     */
    public function setPublicIpAddress(?string $publicIpAddress): void
    {
        if (!empty($publicIpAddress)) {
            $this->setPublicId($publicIpAddress);
        }
        $this->publicIpAddress = $publicIpAddress;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return parent::getType(); // TODO: Change the autogenerated stubé"
    }
}
