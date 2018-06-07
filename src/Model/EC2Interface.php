<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanns
 * Date: 26/05/2018
 * Time: 00:16
 */

namespace App\Model;


use App\Entity\Subnet;
use App\Entity\VPC;

interface EC2Interface extends AWSInterface
{

    /**
     * @return null|string
     */
    public function getImageId(): ?string;

    /**
     * @param null|string $imageId
     */
    public function setImageId(?string $imageId): void;


    /**
     * @return null|string
     */
    public function getInstanceType(): ?string;

    /**
     * @param string $instanceType
     */
    public function setInstanceType(?string $instanceType): void;

    /**
     * @return null|string
     */
    public function getKeyName(): ?string;

    /**
     * @param string $keyName
     */
    public function setKeyName(?string $keyName): void;

    /**
     * @return \DateTime|null
     */
    public function getLaunchTime(): ?\DateTime;

    /**
     * @param \DateTime|null $launchTime
     */
    public function setLaunchTime(?\DateTime $launchTime): void;

    /**
     * @return null|string
     */
    public function getPublicDnsName(): ?string;

    /**
     * @param string $publicDnsName
     */
    public function setPublicDnsName(?string $publicDnsName): void;

    /**
     * @return null|string
     */
    public function getPrivateIpAddress(): ?string;

    /**
     * @param null|string $privateIpAddress
     */
    public function setPrivateIpAddress(?string $privateIpAddress): void;

    /**
     * @return null|string
     */
    public function getPrivateDnsName(): ?string;

    /**
     * @param string $privateDnsName
     */
    public function setPrivateDnsName(?string $privateDnsName): void;

    /**
     * @return null|string
     */
    public function getStateTransitionReason(): ?string;

    /**
     * @param null|string $stateTransitionReason
     */
    public function setStateTransitionReason(?string $stateTransitionReason): void;

    /**
     * @return null|string
     */
    public function getArchitecture(): ?string;

    /**
     * @param string $architecture
     */
    public function setArchitecture(?string $architecture): void;

    /**
     * @return null|string
     */
    public function getClientToken(): ?string;

    /**
     * @param string $clientToken
     */
    public function setClientToken(?string $clientToken): void;

    /**
     * @return null| bool
     */
    public function isEbsOptimized(): ?bool;

    /**
     * @param bool $ebsOptimized
     */
    public function setEbsOptimized(?bool $ebsOptimized): void;

    /**
     * @return null| bool
     */
    public function isEnaSupport(): ?bool;

    /**
     * @param bool $enaSupport
     */
    public function setEnaSupport(?bool $enaSupport): void;

    /**
     * @return null|string
     */
    public function getHypervisor(): ?string;

    /**
     * @param string $hypervisor
     */
    public function setHypervisor(?string $hypervisor): void;

    /**
     * @return bool|null
     */
    public function isSourceDestCheck(): ?bool;

    /**
     * @param bool $sourceDestCheck
     */
    public function setSourceDestCheck(?bool $sourceDestCheck): void;

    /**
     * @return null|string
     */
    public function getVirtualizationType(): ?string;

    /**
     * @param string null|$virtualizationType
     */
    public function setVirtualizationType(?string $virtualizationType): void;

    /**
     * @return null|array
     */
    public function getCpuOptions(): ?array;


    /**
     * @param array|null $cpuOptions
     */
    public function setCpuOptions(?array $cpuOptions): void;

    /**
     * @return VPC|null
     */
    public function getVpc(): ?VPC;

    /**
     * @param VPC $vpc
     */
    public function setVpc(?VPC $vpc): void;

    /**
     * @return Subnet|null
     */
    public function getSubnet(): ?Subnet;

    /**
     * @param Subnet $subnet
     */
    public function setSubnet(Subnet $subnet): void;

    /**
     * @return null|string
     */
    public function getPublicIpAddress(): ?string;

    /**
     * @param null|string $publicIpAddress
     */
    public function setPublicIpAddress(?string $publicIpAddress): void;

    /**
     * @return null|string
     */
    public function getType(): ?string;
}